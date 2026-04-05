<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

class QuizesController extends AppController
{
    private $QuizesTable;

    public function initialize(): void
    {
        parent::initialize();
        
        $this->autoRender = false;
        $this->QuizesTable = TableRegistry::getTableLocator()->get('Quizes');
        $this->response = $this->response->withHeader('Content-Type', 'application/json');
    }

    /**
     * GET /quizes - Lista todos os quizes
     */
    public function index()
    {
        try {
            $quizes = $this->QuizesTable->find()
                ->select(['id', 'usuario_id', 'titulo', 'descricao', 'nivel_dificuldade', 'total_questoes', 'tempo_limite', 'publico', 'criado_em', 'atualizado_em'])
                ->orderBy(['criado_em' => 'DESC'])
                ->all();
            
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'data' => $quizes
            ]));
            return $this->response;
        } catch (\Exception $e) {
            $this->response = $this->response->withStatus(500);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Erro ao carregar quizzes: ' . $e->getMessage()
            ]));
            return $this->response;
        }
    }

    /**
     * GET /quizes/user/{usuario_id} - Lista quizes de um usuário específico
     */
    public function userQuizes($usuarioId = null)
    {
        $usuarioId = $usuarioId ?? $this->request->getParam('usuarioId');
        
        if (!$usuarioId) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID do usuário não informado'
            ]));
            return $this->response;
        }
        
        try {
            $quizes = $this->QuizesTable->find()
                ->where(['usuario_id' => $usuarioId])
                ->select(['id', 'titulo', 'descricao', 'nivel_dificuldade', 'total_questoes', 'tempo_limite', 'publico', 'criado_em'])
                ->orderBy(['criado_em' => 'DESC'])
                ->all();
            
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'data' => $quizes
            ]));
            return $this->response;
        } catch (\Exception $e) {
            $this->response = $this->response->withStatus(500);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Erro ao carregar quizzes do usuário'
            ]));
            return $this->response;
        }
    }

    /**
     * GET /quizes/{id} - Busca um quiz específico
     */
    public function view($id = null)
    {
        $quizId = $id ?? $this->request->getParam('id');
        
        if (!$quizId) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID do quiz não informado'
            ]));
            return $this->response;
        }
        
        try {
            $quiz = $this->QuizesTable->get($quizId);
            
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'data' => $quiz
            ]));
            return $this->response;
        } catch (\Exception $e) {
            $this->response = $this->response->withStatus(404);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Quiz não encontrado'
            ]));
            return $this->response;
        }
    }

    /**
     * POST /quizes - Cria um novo quiz
     */
    public function add()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (!$data) {
            $data = $this->request->getData();
        }
        
        // Validação
        if (empty($data['titulo'])) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Título é obrigatório'
            ]));
            return $this->response;
        }
        
        if (empty($data['usuario_id'])) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID do usuário é obrigatório'
            ]));
            return $this->response;
        }
        
        $quizData = [
            'usuario_id' => $data['usuario_id'],
            'titulo' => $data['titulo'],
            'descricao' => $data['descricao'] ?? null,
            'tipo_criacao' => $data['tipo_criacao'] ?? 'manual',
            'nivel_dificuldade' => $data['nivel_dificuldade'] ?? 'iniciante',
            'total_questoes' => $data['total_questoes'] ?? 0,
            'tempo_limite' => $data['tempo_limite'] ?? null,
            'publico' => $data['publico'] ?? false
        ];
        
        $quiz = $this->QuizesTable->newEntity($quizData);
        
        if ($this->QuizesTable->save($quiz)) {
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Quiz criado com sucesso',
                'data' => $quiz
            ]));
            return $this->response;
        } else {
            $this->response = $this->response->withStatus(422);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Erro ao criar quiz',
                'errors' => $quiz->getErrors()
            ]));
            return $this->response;
        }
    }

    /**
     * PUT /quizes/{id} - Atualiza um quiz
     */
    public function edit($id = null)
    {
        $quizId = $id ?? $this->request->getParam('id');
        
        if (!$quizId) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID do quiz não informado'
            ]));
            return $this->response;
        }
        
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (!$data) {
            $data = $this->request->getData();
        }
        
        try {
            $quiz = $this->QuizesTable->get($quizId);
            
            // Não permitir alterar o usuario_id
            unset($data['usuario_id']);
            
            $quiz = $this->QuizesTable->patchEntity($quiz, $data);
            
            if ($this->QuizesTable->save($quiz)) {
                $this->response->getBody()->write(json_encode([
                    'success' => true,
                    'message' => 'Quiz atualizado com sucesso',
                    'data' => $quiz
                ]));
                return $this->response;
            } else {
                $this->response = $this->response->withStatus(422);
                $this->response->getBody()->write(json_encode([
                    'success' => false,
                    'message' => 'Erro ao atualizar quiz',
                    'errors' => $quiz->getErrors()
                ]));
                return $this->response;
            }
        } catch (\Exception $e) {
            $this->response = $this->response->withStatus(404);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Quiz não encontrado'
            ]));
            return $this->response;
        }
    }

    /**
     * DELETE /quizes/{id} - Remove um quiz
     */
    public function delete($id = null)
    {
        $quizId = $id ?? $this->request->getParam('id');
        
        if (!$quizId) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID do quiz não informado'
            ]));
            return $this->response;
        }
        
        try {
            $quiz = $this->QuizesTable->get($quizId);
            
            if ($this->QuizesTable->delete($quiz)) {
                $this->response->getBody()->write(json_encode([
                    'success' => true,
                    'message' => 'Quiz excluído com sucesso'
                ]));
                return $this->response;
            } else {
                $this->response = $this->response->withStatus(500);
                $this->response->getBody()->write(json_encode([
                    'success' => false,
                    'message' => 'Erro ao excluir quiz'
                ]));
                return $this->response;
            }
        } catch (\Exception $e) {
            $this->response = $this->response->withStatus(404);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Quiz não encontrado'
            ]));
            return $this->response;
        }
    }
}