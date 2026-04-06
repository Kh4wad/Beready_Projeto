<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\QuizService;
use App\Repositories\QuizRepository;

class QuizesController extends AppController
{
    private QuizService $quizService;
    
    public function initialize(): void
    {
        parent::initialize();
        $this->quizService = new QuizService(new QuizRepository());
    }
    
    // GET /quizes
    public function index()
    {
        try {
            $quizzes = $this->quizService->getAllQuizzes();
            
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'data' => $quizzes
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
    
    // GET /quizes/view/{id}
    public function view($id = null)
    {
        if (!$id) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID do quiz não informado'
            ]));
            return $this->response;
        }
        
        try {
            $quiz = $this->quizService->getQuizById((int)$id);
            
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'data' => $quiz
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
    
    // POST /quizes
    public function add()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true) ?: $this->request->getData();
        
        try {
            $quiz = $this->quizService->createQuiz($data);
            
            $this->response = $this->response->withStatus(201);
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Quiz criado com sucesso',
                'data' => $quiz
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
    
    // PUT /quizes/edit/{id}
    public function edit($id = null)
    {
        // 🔥 Pega o ID de várias formas
        $quizId = $id ?? $this->request->getParam('id') ?? $this->request->getData('id');
        
        error_log("=== EDIT QUIZ ===");
        error_log("ID recebido: " . $quizId);
        
        if (!$quizId) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID do quiz não informado'
            ]));
            return $this->response;
        }
        
        $input = file_get_contents('php://input');
        $data = json_decode($input, true) ?: $this->request->getData();
        
        try {
            $quiz = $this->quizService->updateQuiz((int)$quizId, $data);
            
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Quiz atualizado com sucesso',
                'data' => $quiz
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
    
    // DELETE /quizes/delete/{id}
    public function delete($id = null)
    {
        // 🔥 Pega o ID de várias formas
        $quizId = $id ?? $this->request->getParam('id') ?? $this->request->getData('id');
        
        error_log("=== DELETE QUIZ ===");
        error_log("ID recebido: " . $quizId);
        
        if (!$quizId) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID do quiz não informado'
            ]));
            return $this->response;
        }
        
        try {
            $this->quizService->deleteQuiz((int)$quizId);
            
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Quiz excluído com sucesso'
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
}