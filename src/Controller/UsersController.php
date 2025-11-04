<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Utility\Security;
use Cake\Mailer\Mailer;
use Cake\Routing\Router;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

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

                $this->Flash->success(('Bem-vindo, ' . $user['email']));
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

            $this->Flash->error(('Email ou senha inválidos.'));
        }
    }

    public function logout()
    {
        $this->Flash->success(('Você saiu com sucesso.'));
        return $this->redirect($this->Auth->logout());
    }

    public function add()
    {
        $usersTable = $this->fetchTable('Users');
        $user = $usersTable->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // 🔥 REMOVIDO: Processamento de upload de imagem
            
            // Mapear campos corretamente
            $userData = [
                'nome' => $data['nome'],
                'email' => $data['email'],
                'senha_hash' => $data['senha'], // ✅ Campo correto do banco
                'telefone' => $data['telefone'] ?? null,
                'nivel_ingles' => $data['nivel_ingles'] ?? 'iniciante',
                'idioma_preferido' => $data['idioma_preferido'] ?? 'pt-BR',
                'objetivos_aprendizado' => $data['objetivos_aprendizado'] ?? null,
                'status' => 'ativo'
            ];
            
            // Remover campos que não existem na tabela
            unset($data['confirmar_senha']);
            unset($data['foto_perfil']); // 🔥 REMOVIDO: campo de imagem
            
            $user = $usersTable->patchEntity($user, $userData);
            
            if ($usersTable->save($user)) {
                $this->Flash->success(('Usuário criado com sucesso. Faça login para continuar.'));
                return $this->redirect(['action' => 'login']);
            }
            
            $this->Flash->error(('O usuário não pôde ser salvo. Por favor, tente novamente.'));
        }
        $this->set(compact('user'));
    }

// 🔥 REMOVIDO: Método processUpload completo

    /**
     * Processa o upload do arquivo de foto de perfil
     */
    private function processUpload($uploadedFile)
    {
        // Verificar se é uma imagem válida
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($uploadedFile->getClientMediaType(), $allowedTypes)) {
            $this->Flash->error('Tipo de arquivo não permitido. Use apenas JPEG, PNG, GIF ou WebP.');
            return null;
        }

        // Verificar tamanho do arquivo (máximo 5MB)
        if ($uploadedFile->getSize() > 5 * 1024 * 1024) {
            $this->Flash->error('Arquivo muito grande. O tamanho máximo é 5MB.');
            return null;
        }

        // Criar diretório de uploads se não existir
        $uploadDir = WWW_ROOT . 'uploads' . DS . 'profiles';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Gerar nome único para o arquivo
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . strtolower($extension);

        // Mover arquivo para o diretório de uploads
        try {
            $uploadedFile->moveTo($uploadDir . DS . $filename);
            return $filename;
        } catch (\Exception $e) {
            $this->Flash->error('Erro ao fazer upload do arquivo.');
            return null;
        }
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