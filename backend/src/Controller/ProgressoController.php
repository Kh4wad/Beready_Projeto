<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

class ProgressoController extends AppController
{
    private $table;
    private $respostasTable;
    private $flashcardsTable;
    private $quizesTable;

    public function initialize(): void
    {
        parent::initialize();
        $this->table = TableRegistry::getTableLocator()->get('ProgressoUsuario');
        $this->respostasTable = TableRegistry::getTableLocator()->get('RespostasUsuario');
        $this->flashcardsTable = TableRegistry::getTableLocator()->get('Flashcards');
        $this->quizesTable = TableRegistry::getTableLocator()->get('Quizes');
    }

    public function getByUsuario($usuarioId = null)
    {
        $userId = $usuarioId ?? $this->request->getParam('usuarioId') ?? $this->request->getQuery('usuarioId');

        if (!$userId) {
            return $this->jsonError('ID do usuário não informado', 400);
        }

        try {
            $progresso = $this->table->find()
                ->where(['usuario_id' => $userId])
                ->first();

            $data = $progresso
                ? $progresso->toArray()
                : [
                    'usuario_id' => (int)$userId,
                    'vocabulario_aprendido' => 0,
                    'flashcards_concluidos' => 0,
                    'quizes_concluidos' => 0,
                    'tempo_total_estudo' => 0,
                    'sequencia_atual' => 0,
                    'maior_sequencia' => 0,
                    'ultima_atividade' => null,
                    'progresso_nivel' => null,
                ];

            $totalRespostas = $this->respostasTable->find()
                ->where(['usuario_id' => $userId])
                ->count();

            $respostasCorretas = $this->respostasTable->find()
                ->where(['usuario_id' => $userId, 'correto' => true])
                ->count();

            $data['taxa_acerto'] = $totalRespostas > 0
                ? (int)round(($respostasCorretas / $totalRespostas) * 100)
                : 0;

            $totalFlashcards = $this->flashcardsTable->find()
                ->where(['usuario_id' => $userId])
                ->count();

            $totalQuizes = $this->quizesTable->find()
                ->where(['usuario_id' => $userId])
                ->count();

            $percFlashcards = $totalFlashcards > 0
                ? ($data['flashcards_concluidos'] / $totalFlashcards)
                : 0;

            $percQuizes = $totalQuizes > 0
                ? ($data['quizes_concluidos'] / $totalQuizes)
                : 0;

            $progressoCalculado = (int)round((($percFlashcards + $percQuizes) / 2) * 100);
            $data['progresso_geral'] = min(100, $progressoCalculado);

            return $this->jsonSuccess($data);
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(), 500);
        }
    }

    public function save()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true) ?: $this->request->getData();

        if (empty($data['usuario_id'])) {
            return $this->jsonError('ID do usuário é obrigatório', 400);
        }

        try {
            $existing = $this->table->find()
                ->where(['usuario_id' => $data['usuario_id']])
                ->first();

            if ($existing) {
                $entity = $this->table->patchEntity($existing, $data);
            } else {
                $entity = $this->table->newEntity($data);
            }

            if ($this->table->save($entity)) {
                return $this->jsonSuccess($entity, 'Progresso salvo com sucesso');
            }

            return $this->jsonError('Erro ao salvar progresso', 422, $entity->getErrors());
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(), 500);
        }
    }

    public function incrementarFlashcards()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true) ?: $this->request->getData();

        $userId = $data['usuario_id'] ?? null;
        $quantidade = isset($data['quantidade']) ? (int)$data['quantidade'] : 1;

        if (!$userId || $quantidade <= 0) {
            return $this->jsonError('Dados inválidos para incrementar progresso', 400);
        }

        try {
            $existing = $this->table->find()
                ->where(['usuario_id' => $userId])
                ->first();

            if (!$existing) {
                $existing = $this->table->newEntity([
                    'usuario_id' => $userId,
                    'flashcards_concluidos' => 0,
                ]);
                $this->table->saveOrFail($existing);
            }

            $this->table->updateAll(
                ['flashcards_concluidos = flashcards_concluidos + ' . $quantidade],
                ['usuario_id' => $userId]
            );

            $this->atualizarSequencia($userId);

            $atualizado = $this->table->find()
                ->where(['usuario_id' => $userId])
                ->first();

            return $this->jsonSuccess($atualizado, 'Progresso incrementado com sucesso');
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(), 500);
        }
    }

    public function incrementarTempo()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true) ?: $this->request->getData();

        $userId = $data['usuario_id'] ?? null;
        $segundos = isset($data['segundos']) ? (int)$data['segundos'] : 0;

        if (!$userId || $segundos <= 0) {
            return $this->jsonError('Dados inválidos para incrementar tempo de estudo', 400);
        }

        try {
            $existing = $this->table->find()
                ->where(['usuario_id' => $userId])
                ->first();

            if (!$existing) {
                $existing = $this->table->newEntity([
                    'usuario_id' => $userId,
                    'tempo_total_estudo' => 0,
                ]);
                $this->table->saveOrFail($existing);
            }

            $this->table->updateAll(
                ['tempo_total_estudo = tempo_total_estudo + ' . $segundos],
                ['usuario_id' => $userId]
            );

            $atualizado = $this->table->find()
                ->where(['usuario_id' => $userId])
                ->first();

            return $this->jsonSuccess($atualizado, 'Tempo de estudo atualizado com sucesso');
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(), 500);
        }
    }

    private function atualizarSequencia($userId): void
    {
        $progresso = $this->table->find()
            ->where(['usuario_id' => $userId])
            ->first();

        if (!$progresso) {
            return;
        }

        $hoje = new \DateTime('today');
        $ultimaAtividade = $progresso->ultima_atividade
            ? new \DateTime($progresso->ultima_atividade->format('Y-m-d'))
            : null;

        if ($ultimaAtividade === null) {
            $novaSequencia = 1;
        } else {
            $diffDays = (int)$hoje->diff($ultimaAtividade)->format('%a');

            if ($diffDays === 0) {
                return;
            } elseif ($diffDays === 1) {
                $novaSequencia = ($progresso->sequencia_atual ?? 0) + 1;
            } else {
                $novaSequencia = 1;
            }
        }

        $maiorSequencia = max($progresso->maior_sequencia ?? 0, $novaSequencia);

        $this->table->updateAll(
            [
                'sequencia_atual' => $novaSequencia,
                'maior_sequencia' => $maiorSequencia,
                'ultima_atividade' => $hoje->format('Y-m-d H:i:s'),
            ],
            ['usuario_id' => $userId]
        );
    }
}