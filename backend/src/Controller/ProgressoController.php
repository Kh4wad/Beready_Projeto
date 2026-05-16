<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

class ProgressoController extends AppController
{
    private $table;
    
    public function initialize(): void
    {
        parent::initialize();
        $this->table = TableRegistry::getTableLocator()->get('ProgressoUsuario');
    }
    
    // GET /progresso/usuario/{usuarioId}
    public function getByUsuario($usuarioId = null)
    {
        $userId = $usuarioId ?? $this->request->getParam('usuarioId') ?? $this->request->getQuery('usuarioId');
        
        error_log("=== GET BY USUARIO ===");
        error_log("usuarioId param: " . ($usuarioId ?? 'null'));
        error_log("usuarioId from request: " . ($this->request->getParam('usuarioId') ?? 'null'));
        error_log("Final userId: " . $userId);
        
        if (!$userId) {
            return $this->jsonError('ID do usuário não informado', 400);
        }
        
        try {
            $progresso = $this->table->find()
                ->where(['usuario_id' => $userId])
                ->first();
            
            if (!$progresso) {
                return $this->jsonSuccess([
                    'usuario_id' => (int)$userId,
                    'vocabulario_aprendido' => 0,
                    'flashcards_concluidos' => 0,
                    'quizes_concluidos' => 0,
                    'tempo_total_estudo' => 0,
                    'sequencia_atual' => 0,
                    'maior_sequencia' => 0,
                    'ultima_atividade' => null,
                    'progresso_nivel' => null
                ]);
            }
            
            return $this->jsonSuccess($progresso->toArray());
            
        } catch (\Exception $e) {
            return $this->jsonError($e->getMessage(), 500);
        }
    }
    
    // POST /progresso
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
}