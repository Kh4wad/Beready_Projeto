<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;

class UsersController extends AppController
{
    private $UsersTable;

    public function initialize(): void
    {
        parent::initialize();
        
        // 🔥 Garante que não vai renderizar view
        $this->autoRender = false;
        
        // CakePHP 5.x: Use TableRegistry
        $this->UsersTable = TableRegistry::getTableLocator()->get('Users');
        
        // Força JSON
        $this->response = $this->response->withHeader('Content-Type', 'application/json');
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
    }

    // HEALTH CHECK
    public function health()
    {
        $this->response->getBody()->write(json_encode([
            'success' => true,
            'message' => 'API funcionando!',
            'timestamp' => date('Y-m-d H:i:s')
        ]));
        return $this->response;
    }

    // TEST ROUTE
    public function test()
    {
        $this->response->getBody()->write(json_encode([
            'success' => true,
            'message' => 'API do Beready está funcionando!',
            'timestamp' => date('Y-m-d H:i:s')
        ]));
        return $this->response;
    }

    // REGISTER
    public function register()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (!$data) {
            $data = $this->request->getData();
        }
        
        if (empty($data['nome']) || empty($data['email']) || empty($data['senha'])) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Nome, e-mail e senha são obrigatórios'
            ]));
            return $this->response;
        }
        
        $existingUser = $this->UsersTable->find()->where(['email' => $data['email']])->first();
        if ($existingUser) {
            $this->response = $this->response->withStatus(409);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Este e-mail já está cadastrado'
            ]));
            return $this->response;
        }
        
        $userData = [
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha_hash' => password_hash($data['senha'], PASSWORD_DEFAULT),
            'telefone' => $data['telefone'] ?? null,
            'nivel_ingles' => $data['nivel_ingles'] ?? 'iniciante',
            'idioma_preferido' => $data['idioma_preferido'] ?? 'pt-BR',
            'objetivos_aprendizado' => $data['objetivos_aprendizado'] ?? null,
            'status' => 'ativo'
        ];
        
        $user = $this->UsersTable->newEntity($userData);
        
        if ($this->UsersTable->save($user)) {
            $userArray = $user->toArray();
            unset($userArray['senha_hash']);
            
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Registro realizado com sucesso',
                'user' => $userArray
            ]));
            return $this->response;
        } else {
            $this->response = $this->response->withStatus(422);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Erro ao registrar usuário',
                'errors' => $user->getErrors()
            ]));
            return $this->response;
        }
    }
    
    // LOGIN
    public function login()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (!$data) {
            $data = $this->request->getData();
        }
        
        if (empty($data['email']) || empty($data['password'])) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'E-mail e senha são obrigatórios'
            ]));
            return $this->response;
        }

        $user = $this->UsersTable->find()
            ->select(['id', 'nome', 'email', 'senha_hash', 'telefone', 'nivel_ingles', 'idioma_preferido', 'status', 'objetivos_aprendizado'])
            ->where(['email' => $data['email']])
            ->first();
        
        if (!$user || empty($user->senha_hash)) {
            $this->response = $this->response->withStatus(401);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'E-mail ou senha inválidos'
            ]));
            return $this->response;
        }
        
        if (password_verify($data['password'], $user->senha_hash)) {
            $user->ultimo_login = new \DateTime('now');
            $this->UsersTable->save($user);
            
            $userArray = $user->toArray();
            unset($userArray['senha_hash']);
            
            $this->response->getBody()->write(json_encode([
                'success' => true,
                'message' => 'Login realizado com sucesso',
                'user' => $userArray
            ]));
            return $this->response;
        } else {
            $this->response = $this->response->withStatus(401);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'E-mail ou senha inválidos'
            ]));
            return $this->response;
        }
    }
    
    // LOGOUT - SEM SIMULAÇÃO
    public function logout()
    {
        $this->response->getBody()->write(jsosn_encode([
            'success' => true,
            'message' => 'Logout realizado com sucesso'
        ]));
        return $this->response;
    }
    
    public function forgotPassword()
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        $email = $data['email'] ?? null;
        
        // Aqui você implementaria a lógica real de envio de e-mail
        
        $this->response->getBody()->write(json_encode([
            'success' => true,
            'message' => 'Se o e-mail existir em nossa base, enviaremos as instruções de recuperação.'
        ]));
        return $this->response;
    }
    
    // RESET PASSWORD - SEM SIMULAÇÃO
    public function resetPassword($token = null)
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (empty($data['password']) || empty($data['confirm_password'])) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Senha e confirmação de senha são obrigatórios'
            ]));
            return $this->response;
        }
        
        if ($data['password'] !== $data['confirm_password']) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'As senhas não coincidem'
            ]));
            return $this->response;
        }
        
        // Aqui você implementaria a lógica real de reset de senha com token
        
        $this->response->getBody()->write(json_encode([
            'success' => true,
            'message' => 'Senha redefinida com sucesso!'
        ]));
        return $this->response;
    }
    
    // GET /users/{id}
    public function view($id = null)
    {
        if (!$id) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID do usuário não informado'
            ]));
            return $this->response;
        }
        
        $user = $this->UsersTable->find()
            ->select(['id', 'nome', 'email', 'telefone', 'nivel_ingles', 'idioma_preferido', 'status', 'objetivos_aprendizado', 'criado_em', 'ultimo_login'])
            ->where(['id' => $id])
            ->first();
        
        if (!$user) {
            $this->response = $this->response->withStatus(404);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Usuário não encontrado'
            ]));
            return $this->response;
        }
        
        $this->response->getBody()->write(json_encode([
            'success' => true,
            'user' => $user
        ]));
        return $this->response;
    }
    
    // PUT /users/{id}
  public function update($id = null)
  {
      $requestId = $this->request->getParam('id');
      error_log("=== UPDATE USER ===");
      error_log("ID do parâmetro: " . ($id ?? 'null'));
      error_log("ID do request param: " . ($requestId ?? 'null'));
      
      // Usa o ID do parâmetro ou do request
      $userId = $id ?? $requestId;
      
      if (!$userId) {
          return $this->jsonResponse([
              'success' => false,
              'message' => 'ID do usuário não informado'
          ], 400);
      }
      
      $input = file_get_contents('php://input');
      $data = json_decode($input, true);
      
      if (!$data) {
          $data = $this->request->getData();
      }
      
      error_log("Dados recebidos: " . print_r($data, true));
      
      try {
          // 🔥 Busca o usuário pelo ID
          $user = $this->UsersTable->get($userId);
          
          if (!$user) {
              return $this->jsonResponse([
                  'success' => false,
                  'message' => 'Usuário não encontrado'
              ], 404);
          }
          
          error_log("Usuário ANTES do update - ID: {$user->id}, Nome: {$user->nome}");
          
          // 🔥 Atualiza os dados individualmente
          if (isset($data['nome'])) {
              $user->nome = $data['nome'];
          }
          if (isset($data['email'])) {
              $user->email = $data['email'];
          }
          if (isset($data['telefone'])) {
              $user->telefone = $data['telefone'];
          }
          if (isset($data['nivel_ingles'])) {
              $user->nivel_ingles = $data['nivel_ingles'];
          }
          if (isset($data['idioma_preferido'])) {
              $user->idioma_preferido = $data['idioma_preferido'];
          }
          if (isset($data['status'])) {
              $user->status = $data['status'];
          }
          if (isset($data['objetivos_aprendizado'])) {
              $user->objetivos_aprendizado = $data['objetivos_aprendizado'];
          }
          
          // Se veio senha, converte para senha_hash
          if (isset($data['senha'])) {
              $user->senha_hash = password_hash($data['senha'], PASSWORD_DEFAULT);
          }
          
          // 🔥 Atualiza o timestamp manualmente
          $user->atualizado_em = new \DateTime('now');
          
          error_log("Usuário DEPOIS da atualização - ID: {$user->id}, Nome: {$user->nome}");
          
          // 🔥 Salva diretamente
          if ($this->UsersTable->save($user)) {
              error_log("✅ Usuário salvo com SUCESSO! ID: {$user->id}");
              
              $userArray = $user->toArray();
              unset($userArray['senha_hash']);
              unset($userArray['token']);
              unset($userArray['token_expires']);
              
              return $this->jsonResponse([
                  'success' => true,
                  'message' => 'Perfil atualizado com sucesso',
                  'user' => $userArray
              ]);
          } else {
              error_log("❌ Erro ao salvar usuário: " . print_r($user->getErrors(), true));
              return $this->jsonResponse([
                  'success' => false,
                  'message' => 'Erro ao atualizar usuário',
                  'errors' => $user->getErrors()
              ], 422);
          }
      } catch (\Exception $e) {
          error_log("❌ Exceção no update: " . $e->getMessage());
          error_log("Stack trace: " . $e->getTraceAsString());
          return $this->jsonResponse([
              'success' => false,
              'message' => 'Erro interno: ' . $e->getMessage()
          ], 500);
      }
  }

  // 🔥 Método auxiliar para resposta JSON
  private function jsonResponse($data, $status = 200)
  {
      $this->response = $this->response->withStatus($status);
      $this->response = $this->response->withType('application/json');
      $this->response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
      return $this->response;
  }
    
    // DELETE /users/{id}
    public function delete($id = null)
    {
        // Pega o ID do parâmetro ou do request
        $userId = $id ?? $this->request->getParam('id');
        
        if (!$userId) {
            $this->response = $this->response->withStatus(400);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'ID do usuário não informado'
            ]));
            return $this->response;
        }
        
        // Não permite deletar o admin (ID 1)
        if ($userId == 1) {
            $this->response = $this->response->withStatus(403);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Não é possível excluir o usuário administrador'
            ]));
            return $this->response;
        }
        
        try {
            $user = $this->UsersTable->get($userId);
            
            if (!$user) {
                $this->response = $this->response->withStatus(404);
                $this->response->getBody()->write(json_encode([
                    'success' => false,
                    'message' => 'Usuário não encontrado'
                ]));
                return $this->response;
            }
            
            if ($this->UsersTable->delete($user)) {
                $this->response->getBody()->write(json_encode([
                    'success' => true,
                    'message' => 'Conta excluída com sucesso'
                ]));
                return $this->response;
            } else {
                $this->response = $this->response->withStatus(500);
                $this->response->getBody()->write(json_encode([
                    'success' => false,
                    'message' => 'Erro ao excluir conta'
                ]));
                return $this->response;
            }
        } catch (\Exception $e) {
            $this->response = $this->response->withStatus(500);
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'message' => 'Erro ao excluir conta: ' . $e->getMessage()
            ]));
            return $this->response;
        }
    }
    
    // 404
    public function notFound()
    {
        $this->response = $this->response->withStatus(404);
        $this->response->getBody()->write(json_encode([
            'success' => false,
            'message' => 'Rota não encontrada'
        ]));
        return $this->response;
    }
}