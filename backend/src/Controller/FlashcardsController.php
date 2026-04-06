<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Response;

class FlashcardsController extends AppController
{
    private $FlashcardsTable;

    public function initialize(): void
    {
        parent::initialize();
        $this->FlashcardsTable = TableRegistry::getTableLocator()->get('Flashcards');
    }

    private function jsonResponse($data, int $statusCode = 200): Response
    {
        $this->response = $this->response->withStatus($statusCode);
        $this->response = $this->response->withType('application/json');
        $this->response = $this->response->withStringBody(json_encode($data, JSON_UNESCAPED_UNICODE));
        return $this->response;
    }

    /**
     * GET /flashcards - Lista todos os flashcards
     */
    public function index(): Response
    {
        try {
            $flashcards = $this->FlashcardsTable->find()
                ->select(['id', 'usuario_id', 'frente', 'verso', 'nivel_dificuldade', 'criado_em', 'atualizado_em'])
                ->orderBy(['criado_em' => 'DESC'])
                ->all();
            
            return $this->jsonResponse([
                'success' => true,
                'data' => $flashcards->toArray()
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Erro ao carregar flashcards: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /flashcards/{id} - Busca um flashcard específico
     */
    public function view($id = null): Response
    {
        $flashcardId = $id ?? $this->request->getParam('id');
        
        if (!$flashcardId) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'ID do flashcard não informado'
            ], 400);
        }
        
        try {
            $flashcard = $this->FlashcardsTable->get($flashcardId);
            
            return $this->jsonResponse([
                'success' => true,
                'data' => $flashcard
            ]);
        } catch (RecordNotFoundException $e) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Flashcard não encontrado'
            ], 404);
        } catch (\Exception $e) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Erro ao buscar flashcard: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /flashcards - Cria um novo flashcard
     */
    public function add(): Response
    {
        try {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            
            if (!$data) {
                $data = $this->request->getData();
            }
            
            if (empty($data['frente'])) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'A pergunta (frente) é obrigatória'
                ], 400);
            }
            
            if (empty($data['verso'])) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'A resposta (verso) é obrigatória'
                ], 400);
            }
            
            $flashcardData = [
                'usuario_id' => $data['usuario_id'] ?? 1,
                'frente' => trim($data['frente']),
                'verso' => trim($data['verso']),
                'nivel_dificuldade' => $data['nivel_dificuldade'] ?? 'iniciante'
            ];
            
            $flashcard = $this->FlashcardsTable->newEntity($flashcardData);
            
            if ($this->FlashcardsTable->save($flashcard)) {
                return $this->jsonResponse([
                    'success' => true,
                    'message' => 'Flashcard criado com sucesso',
                    'data' => $flashcard
                ], 201);
            } else {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Erro ao criar flashcard',
                    'errors' => $flashcard->getErrors()
                ], 422);
            }
        } catch (\Exception $e) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Erro ao criar flashcard: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * PUT /flashcards/{id} - Atualiza um flashcard
     */
    public function edit($id = null): Response
    {
        $flashcardId = $id ?? $this->request->getParam('id');
        
        if (!$flashcardId) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'ID do flashcard não informado'
            ], 400);
        }
        
        try {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            
            if (!$data) {
                $data = $this->request->getData();
            }
            
            $flashcard = $this->FlashcardsTable->get($flashcardId);
            unset($data['usuario_id']);
            
            $flashcard = $this->FlashcardsTable->patchEntity($flashcard, $data);
            
            if ($this->FlashcardsTable->save($flashcard)) {
                return $this->jsonResponse([
                    'success' => true,
                    'message' => 'Flashcard atualizado com sucesso',
                    'data' => $flashcard
                ]);
            } else {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Erro ao atualizar flashcard',
                    'errors' => $flashcard->getErrors()
                ], 422);
            }
        } catch (RecordNotFoundException $e) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Flashcard não encontrado'
            ], 404);
        } catch (\Exception $e) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Erro ao atualizar flashcard: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE /flashcards/{id} - Remove um flashcard
     */
    public function delete($id = null): Response
    {
        $flashcardId = $id ?? $this->request->getParam('id');
        
        if (!$flashcardId) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'ID do flashcard não informado'
            ], 400);
        }
        
        try {
            $flashcard = $this->FlashcardsTable->get($flashcardId);
            
            if ($this->FlashcardsTable->delete($flashcard)) {
                return $this->jsonResponse([
                    'success' => true,
                    'message' => 'Flashcard excluído com sucesso'
                ]);
            } else {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Erro ao excluir flashcard'
                ], 500);
            }
        } catch (RecordNotFoundException $e) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Flashcard não encontrado'
            ], 404);
        } catch (\Exception $e) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Erro ao excluir flashcard: ' . $e->getMessage()
            ], 500);
        }
    }
}