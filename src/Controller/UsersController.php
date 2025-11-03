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

        // 🔥 AGORA USA NOSSO AuthComponent CUSTOM
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);

                // Log de login bem-sucedido (se você tiver a tabela LoginsLog)
                try {
                    $loginsLogTable = $this->fetchTable('LoginsLog');
                    $logEntry = $loginsLogTable->newEntity([
                        'user_id' => $user->id,
                        'login_time' => new \DateTime(),
                        'ip_address' => $this->request->clientIp(),
                        'success' => true,
                    ]);
                    $loginsLogTable->save($logEntry);
                } catch (\Exception $e) {
                    // Ignora erro se a tabela não existir
                }

                $this->Flash->success(('Bem-vindo, ' . $user->email));
                return $this->redirect($this->Auth->redirectUrl());
            }

            // Log de login falhado (se você tiver a tabela LoginsLog)
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

            $this->Flash->error(('Email ou senha inválidos.'));
        }
    }

    public function logout()
    {
        // 🔥 AGORA USA NOSSO AuthComponent CUSTOM
        $this->Flash->success(('Você saiu com sucesso.'));
        return $this->redirect($this->Auth->logout());
    }

    public function add()
    {
        $usersTable = $this->fetchTable('Users');
        $user = $usersTable->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $usersTable->patchEntity($user, $this->request->getData());
            if ($usersTable->save($user)) {
                $this->Flash->success(('O usuário foi salvo.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(('O usuário não pôde ser salvo. Por favor, tente novamente.'));
        }
        $this->set(compact('user'));
    }

    public function forgotPassword()
    {
        $this->request->allowMethod(['get', 'post']);
        $usersTable = $this->fetchTable('Users');

        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            $user = $usersTable->find()->where(['email' => $email])->first();

            if ($user) {
                $token = Security::hash(Security::randomBytes(32));
                $user->token = $token;
                $user->token_expires = new \DateTime('+1 hour');

                if ($usersTable->save($user)) {
                    $resetLink = Router::url(['controller' => 'Users', 'action' => 'resetPassword', $token], true);

                    // Simulação de envio de e-mail
                    $mailer = new Mailer('default');
                    $mailer
                        ->setFrom(['no-reply@beready.com' => 'BeReady'])
                        ->setTo($user->email)
                        ->setSubject('Recuperação de Senha')
                        ->deliver('Clique no link para redefinir sua senha: ' . $resetLink);

                    $this->Flash->success(('Um link de recuperação de senha foi enviado para o seu e-mail.'));
                    return $this->redirect(['action' => 'login']);
                }
            }
            $this->Flash->error(('E-mail não encontrado ou erro ao gerar o token.'));
        }
    }

    public function resetPassword($token = null)
    {
        $usersTable = $this->fetchTable('Users');

        if (!$token) {
            $this->Flash->error(('Token de redefinição de senha inválido.'));
            return $this->redirect(['action' => 'forgotPassword']);
        }

        $user = $usersTable->find()->where([
            'token' => $token,
            'token_expires >' => new \DateTime(),
        ])->first();

        if (!$user) {
            $this->Flash->error(('Token de redefinição de senha expirado ou inválido.'));
            return $this->redirect(['action' => 'forgotPassword']);
        }

        if ($this->request->is(['post', 'put'])) {
            $user = $usersTable->patchEntity($user, $this->request->getData());
            $user->token = null;
            $user->token_expires = null;

            if ($usersTable->save($user)) {
                $this->Flash->success(('Sua senha foi redefinida com sucesso.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(('A senha não pôde ser redefinida. Por favor, tente novamente.'));
        }

        $this->set(compact('user'));
    }
}