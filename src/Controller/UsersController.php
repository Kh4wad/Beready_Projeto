<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Utility\Security;
use Cake\Mailer\Mailer;
use Cake\Routing\Router;

class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        // As ações permitidas já estão configuradas no AppController com $this->Auth->allow()
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);

                // Atualiza último login
                $userEntity = $this->Users->get($user['id']);
                $userEntity->ultimo_login = new \DateTime();
                $this->Users->save($userEntity);

                // Log de login bem-sucedido
                try {
                    $loginsLogTable = $this->fetchTable('LoginsLog');
                    $logEntry = $loginsLogTable->newEntity([
                        'user_id' => $user['id'],
                        'login_time' => new \DateTime(),
                        'ip_address' => $this->request->clientIp(),
                        'success' => true,
                    ]);
                    $loginsLogTable->save($logEntry);
                } catch (\Exception $e) {
                    // Ignora erro se a tabela não existir
                }

                $this->Flash->success(__('Bem-vindo, {0}!', $user['nome']));
                return $this->redirect($this->Auth->redirectUrl());
            }

            // Log de login falhado
            try {
                $loginsLogTable = $this->fetchTable('LoginsLog');
                $usersTable = $this->fetchTable('Users');
                $data = $this->request->getData();
                $user = $usersTable->find()->where(['email' => $data['email']])->first();

                if ($user) {
                    $logEntry = $loginsLogTable->newEntity([
                        'user_id' => $user->id,
                        'login_time' => new \DateTime(),
                        'ip_address' => $this->request->clientIp(),
                        'success' => false,
                    ]);
                    $loginsLogTable->save($logEntry);
                }
            } catch (\Exception $e) {
                // Ignora erro se a tabela não existir
            }

            $this->Flash->error(__('Email ou senha inválidos.'));
        }
    }

    public function logout()
    {
        $this->Flash->success(__('Você saiu com sucesso.'));
        return $this->redirect($this->Auth->logout());
    }

    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Dados diretos para o banco
            $userData = [
                'nome' => $data['nome'],
                'email' => $data['email'],
                'senha_hash' => (new \Authentication\PasswordHasher\DefaultPasswordHasher())->hash($data['senha']),
                'telefone' => $data['telefone'] ?? null,
                'nivel_ingles' => $data['nivel_ingles'] ?? 'iniciante',
                'idioma_preferido' => $data['idioma_preferido'] ?? 'pt-BR',
                'objetivos_aprendizado' => $data['objetivos_aprendizado'] ?? null,
                'status' => 'ativo'
            ];
            
            $user = $this->Users->newEntity($userData);
            
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário cadastrado com sucesso! Faça login para continuar.'));
                return $this->redirect(['action' => 'login']);
            }
            
            $this->Flash->error(__('Erro ao cadastrar usuário. Por favor, verifique os dados e tente novamente.'));
        }
        
        $this->set(compact('user'));
    }

    public function forgotPassword()
    {
        $this->request->allowMethod(['get', 'post']);

        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            $user = $this->Users->find()->where(['email' => $email])->first();

            if ($user) {
                $token = Security::hash(Security::randomBytes(32));
                $user->token = $token;
                $user->token_expires = new \DateTime('+1 hour');

                if ($this->Users->save($user)) {
                    $resetLink = Router::url(['controller' => 'Users', 'action' => 'resetPassword', $token], true);

                    // Simulação de envio de e-mail
                    $mailer = new Mailer('default');
                    $mailer
                        ->setFrom(['no-reply@beready.com' => 'BeReady'])
                        ->setTo($user->email)
                        ->setSubject('Recuperação de Senha')
                        ->deliver('Clique no link para redefinir sua senha: ' . $resetLink);

                    $this->Flash->success(__('Um link de recuperação de senha foi enviado para o seu e-mail.'));
                    return $this->redirect(['action' => 'login']);
                }
            }
            $this->Flash->error(__('E-mail não encontrado ou erro ao gerar o token.'));
        }
    }

    public function resetPassword($token = null)
    {
        if (!$token) {
            $this->Flash->error(__('Token de redefinição de senha inválido.'));
            return $this->redirect(['action' => 'forgotPassword']);
        }

        $user = $this->Users->find()->where([
            'token' => $token,
            'token_expires >' => new \DateTime(),
        ])->first();

        if (!$user) {
            $this->Flash->error(__('Token de redefinição de senha expirado ou inválido.'));
            return $this->redirect(['action' => 'forgotPassword']);
        }

        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->token = null;
            $user->token_expires = null;

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Sua senha foi redefinida com sucesso.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('A senha não pôde ser redefinida. Por favor, tente novamente.'));
        }

        $this->set(compact('user'));
    }

    public function index()
    {
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
    }

    public function view($id = null)
    {
        // Verifica se o ID foi fornecido
        if (!$id) {
            // Se não tem ID, mostra o perfil do usuário logado
            $userId = $this->Auth->user('id');
            if (!$userId) {
                $this->Flash->error(__('Usuário não autenticado.'));
                return $this->redirect(['action' => 'login']);
            }
            return $this->redirect(['action' => 'view', $userId]);
        }

        try {
            $user = $this->Users->get($id);
            $this->set(compact('user'));
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Usuário não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function edit($id = null)
    {
        // Verifica se o ID foi fornecido
        if (!$id) {
            // Se não tem ID, edita o perfil do usuário logado
            $userId = $this->Auth->user('id');
            if (!$userId) {
                $this->Flash->error(__('Usuário não autenticado.'));
                return $this->redirect(['action' => 'login']);
            }
            return $this->redirect(['action' => 'edit', $userId]);
        }

        try {
            $user = $this->Users->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Usuário não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            // Se a senha estiver vazia, remove para não atualizar
            if (empty($data['senha'])) {
                unset($data['senha']);
                unset($data['confirmar_senha']);
            } else {
                // Se tem senha, faz o hash
                $data['senha_hash'] = (new \Authentication\PasswordHasher\DefaultPasswordHasher())->hash($data['senha']);
                unset($data['senha']);
                unset($data['confirmar_senha']);
            }
            
            $user = $this->Users->patchEntity($user, $data);
            
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Perfil atualizado com sucesso.'));
                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Erro ao atualizar perfil. Por favor, tente novamente.'));
        }
        
        $this->set(compact('user'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        if (!$id) {
            $this->Flash->error(__('ID do usuário não especificado.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $user = $this->Users->get($id);
            
            // Impede que o usuário exclua a si mesmo
            $currentUserId = $this->Auth->user('id');
            if ($user->id === $currentUserId) {
                $this->Flash->error(__('Você não pode excluir sua própria conta.'));
                return $this->redirect(['action' => 'index']);
            }
            
            if ($this->Users->delete($user)) {
                $this->Flash->success(__('Usuário excluído com sucesso.'));
            } else {
                $this->Flash->error(__('Erro ao excluir usuário. Por favor, tente novamente.'));
            }
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Usuário não encontrado.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Método profile - redireciona para view/edit do usuário logado
     */
    public function profile()
    {
        $userId = $this->Auth->user('id');
        if (!$userId) {
            $this->Flash->error(__('Usuário não autenticado.'));
            return $this->redirect(['action' => 'login']);
        }
        return $this->redirect(['action' => 'view', $userId]);
    }

    /**
     * Método myProfile - para editar o próprio perfil
     */
    public function myProfile()
    {
        $userId = $this->Auth->user('id');
        if (!$userId) {
            $this->Flash->error(__('Usuário não autenticado.'));
            return $this->redirect(['action' => 'login']);
        }
        return $this->redirect(['action' => 'edit', $userId]);
    }
}