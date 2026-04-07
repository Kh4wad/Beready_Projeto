<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

class PreferenciasController extends AppController
{
    private $table;
    
    public function initialize(): void
    {
        parent::initialize();
        $this->table = TableRegistry::getTableLocator()->get('PreferenciasUsuario');
    }
    
    // GET /preferencias/usuario/{usuarioId}
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
        
        $preferencia = $this->table->find()
            ->where(['usuario_id' => $usuarioId])
            ->first();
        
        if (!$preferencia) {
            // Retorna preferências padrão
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'data' => [
                    'usuario_id' => (int)$usuarioId,
                    'tema' => 'claro',
                    'modo_daltonico' => false,
                    'notificacoes_ativas' => true,
                    'som_ativo' => true,
                    'traducao_automatica' => true,
                    'preferencia_dificuldade' => 'adaptativo',
                    'meta_diaria_minutos' => 30,
                ]
            ]));
            return $this->response;
        }
        
        $this->response->getBody()->write(json_encode([
            'success' => true,
            'data' => $preferencia
        ]));
        return $this->response;
    }
    
    // POST /preferencias
    public function save()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true) ?: $this->request->getData();
        
        if (empty($data['usuario_id'])) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID do usuário é obrigatório'
            ]));
            return $this->response;
        }
        
        $existing = $this->table->find()
            ->where(['usuario_id' => $data['usuario_id']])
            ->first();
        
        if ($existing) {
            $entity = $this->table->patchEntity($existing, $data);
        } else {
            $entity = $this->table->newEntity($data);
        }
        
        if ($this->table->save($entity)) {
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Preferências salvas com sucesso',
                'data' => $entity
            ]));
            return $this->response;
        }
        
        $this->response = $this->response->withStatus(500);
        $this->response->getBody()->write(json_encode([
            'success' => false,
            'message' => 'Erro ao salvar preferências',
            'errors' => $entity->getErrors()
        ]));
        return $this->response;
    }
}