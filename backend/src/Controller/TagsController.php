<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\TagService;
use App\Repositories\TagRepository;

class TagsController extends AppController
{
    private TagService $service;
    
    public function initialize(): void
    {
        parent::initialize();
        $this->service = new TagService(new TagRepository());
    }
    
    // GET /tags
    public function index()
    {
        try {
            $tags = $this->service->getAllTags();
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'data' => $tags
            ]));
            return $this->response;
        } catch (\Exception $e) {
            $this->response = $this->response->withStatus(500);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]));
            return $this->response;
        }
    }
    
    // GET /tags/usuario/{usuarioId}
    public function getByUsuario($usuarioId = null)
    {
        if (!$usuarioId) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID do usuário não informado'
            ]));
            return $this->response;
        }
        
        try {
            $tags = $this->service->getTagsByUsuario((int)$usuarioId);
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'data' => $tags
            ]));
            return $this->response;
        } catch (\Exception $e) {
            $this->response = $this->response->withStatus(500);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]));
            return $this->response;
        }
    }
    
    // GET /tags/view/{id}
    public function view($id = null)
    {
        if (!$id) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID da tag não informado'
            ]));
            return $this->response;
        }
        
        try {
            $tag = $this->service->getTagById((int)$id);
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'data' => $tag
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
                'message' => $e->getMessage()
            ]));
            return $this->response;
        }
    }
    
    // POST /tags
    public function add()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true) ?: $this->request->getData();
        
        try {
            $tag = $this->service->createTag($data);
            $this->response = $this->response->withStatus(201);
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Tag criada com sucesso',
                'data' => $tag
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
            $code = $e->getCode() ?: 409;
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
                'message' => $e->getMessage()
            ]));
            return $this->response;
        }
    }
    
    // PUT /tags/edit/{id}
    public function edit($id = null)
    {
        if (!$id) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID da tag não informado'
            ]));
            return $this->response;
        }
        
        $input = file_get_contents('php://input');
        $data = json_decode($input, true) ?: $this->request->getData();
        
        try {
            $tag = $this->service->updateTag((int)$id, $data);
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Tag atualizada com sucesso',
                'data' => $tag
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
                'message' => $e->getMessage()
            ]));
            return $this->response;
        }
    }
    
    // DELETE /tags/delete/{id}
    public function delete($id = null)
    {
        if (!$id) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID da tag não informado'
            ]));
            return $this->response;
        }
        
        try {
            $this->service->deleteTag((int)$id);
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Tag excluída com sucesso'
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
                'message' => $e->getMessage()
            ]));
            return $this->response;
        }
    }
}