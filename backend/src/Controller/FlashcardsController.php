<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\FlashcardService;
use App\Repositories\FlashcardRepository;

class FlashcardsController extends AppController
{
    private FlashcardService $flashcardService;
    
    public function initialize(): void
    {
        parent::initialize();
        $this->flashcardService = new FlashcardService(new FlashcardRepository());
    }
    
    // GET /flashcards
    public function index()
    {
        try {
            $flashcards = $this->flashcardService->getAllFlashcards();
            
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'data' => $flashcards
            ]));
            return $this->response;
            
        } catch (\Exception $e) {
            $this->response = $this->response->withStatus(500);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Erro ao carregar flashcards: ' . $e->getMessage()
            ]));
            return $this->response;
        }
    }
    
    // GET /flashcards/view/{id}
    public function view($id = null)
    {
        if (!$id) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID do flashcard não informado'
            ]));
            return $this->response;
        }
        
        try {
            $flashcard = $this->flashcardService->getFlashcardById((int)$id);
            
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'data' => $flashcard
            ]));
            return $this->response;
            
        } catch (\RuntimeException $e) {
            $code = $e->getCode() ?: 404;
            $this->response = $this->response->withStatus($code);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]));
            return $this->response;
        } catch (\Exception $e) {
            $this->response = $this->response->withStatus(500);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Erro interno: ' . $e->getMessage()
            ]));
            return $this->response;
        }
    }
    
    // POST /flashcards
    public function add()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true) ?: $this->request->getData();
        
        try {
            $flashcard = $this->flashcardService->createFlashcard($data);
            
            $this->response = $this->response->withStatus(201);
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Flashcard criado com sucesso',
                'data' => $flashcard
            ]));
            return $this->response;
            
        } catch (\InvalidArgumentException $e) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]));
            return $this->response;
        } catch (\RuntimeException $e) {
            $code = $e->getCode() ?: 404;
            $this->response = $this->response->withStatus($code);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]));
            return $this->response;
        } catch (\Exception $e) {
            $this->response = $this->response->withStatus(500);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Erro interno: ' . $e->getMessage()
            ]));
            return $this->response;
        }
    }
    
    // PUT /flashcards/edit/{id} ou PUT /flashcards/{id}
    public function edit($id = null)
    {
        // 🔥 Pega o ID de várias formas
        $flashcardId = $id ?? $this->request->getParam('id') ?? $this->request->getData('id');
        
        error_log("=== EDIT FLASHCARD ===");
        error_log("ID recebido: " . $flashcardId);
        error_log("ID do parâmetro: " . ($id ?? 'null'));
        error_log("ID do request param: " . ($this->request->getParam('id') ?? 'null'));
        
        if (!$flashcardId) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID do flashcard não informado'
            ]));
            return $this->response;
        }
        
        $input = file_get_contents('php://input');
        $data = json_decode($input, true) ?: $this->request->getData();
        
        error_log("Dados recebidos: " . print_r($data, true));
        
        try {
            $flashcard = $this->flashcardService->updateFlashcard((int)$flashcardId, $data);
            
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Flashcard atualizado com sucesso',
                'data' => $flashcard
            ]));
            return $this->response;
            
        } catch (\RuntimeException $e) {
            $code = $e->getCode() ?: 404;
            $this->response = $this->response->withStatus($code);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]));
            return $this->response;
        } catch (\Exception $e) {
            error_log("ERRO: " . $e->getMessage());
            $this->response = $this->response->withStatus(500);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Erro interno: ' . $e->getMessage()
            ]));
            return $this->response;
        }
    }
    
    // DELETE /flashcards/delete/{id} ou DELETE /flashcards/{id}
    public function delete($id = null)
    {
        // 🔥 Pega o ID de várias formas
        $flashcardId = $id ?? $this->request->getParam('id') ?? $this->request->getData('id');
        
        error_log("=== DELETE FLASHCARD ===");
        error_log("ID recebido: " . $flashcardId);
        
        if (!$flashcardId) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID do flashcard não informado'
            ]));
            return $this->response;
        }
        
        try {
            $this->flashcardService->deleteFlashcard((int)$flashcardId);
            
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Flashcard excluído com sucesso'
            ]));
            return $this->response;
            
        } catch (\RuntimeException $e) {
            $code = $e->getCode() ?: 404;
            $this->response = $this->response->withStatus($code);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]));
            return $this->response;
        } catch (\Exception $e) {
            error_log("ERRO: " . $e->getMessage());
            $this->response = $this->response->withStatus(500);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Erro interno: ' . $e->getMessage()
            ]));
            return $this->response;
        }
    }
}