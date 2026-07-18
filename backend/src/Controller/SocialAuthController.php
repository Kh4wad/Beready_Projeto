<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\SocialAuthService;
use Cake\ORM\TableRegistry;
use Cake\Http\Client;
use App\Mailer\UserMailer;

class SocialAuthController extends AppController
{
    private SocialAuthService $socialAuthService;

    public function initialize(): void
    {
        parent::initialize();
        $this->socialAuthService = new SocialAuthService();
        $this->autoRender = false;
    }

    public function callback($provider = null)
    {
        $provider = $this->request->getParam('provider') ?? null;
        
        if (empty($provider)) {
            $path = $this->request->getUri()->getPath();
            if (preg_match('/\/callback\/([a-zA-Z]+)/', $path, $matches)) {
                $provider = $matches[1];
            }
        }
        
        if (!in_array($provider, ['google', 'facebook', 'linkedin'])) {
            return $this->jsonError('Provedor não suportado: ' . $provider, 400);
        }
        
        $code = $this->request->getQuery('code');
        
        if (!$code) {
            return $this->jsonError('Código de autorização não encontrado', 400);
        }

        if ($provider === 'google') {
            $tokenData = $this->getGoogleAccessToken($code);
        } elseif ($provider === 'facebook') {
            $tokenData = $this->getFacebookAccessToken($code);
        } elseif ($provider === 'linkedin') {
            $tokenData = $this->getLinkedInAccessToken($code);
        } else {
            return $this->jsonError('Provedor não suportado', 400);
        }
        
        if (!$tokenData) {
            return $this->jsonError('Erro ao obter token do ' . ucfirst($provider), 400);
        }

        if ($provider === 'google') {
            $userInfo = $this->getGoogleUserInfo($tokenData['access_token']);
        } elseif ($provider === 'facebook') {
            $userInfo = $this->getFacebookUserInfo($tokenData['access_token']);
        } elseif ($provider === 'linkedin') {
            $userInfo = $this->getLinkedInUserInfo($tokenData['access_token']);
        }
        
        if (!$userInfo || !isset($userInfo['email'])) {
            return $this->jsonError('Erro ao obter informações do usuário', 400);
        }

        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $user = $usersTable->find()->where(['email' => $userInfo['email']])->first();
        
        $name = $userInfo['name'] ?? $userInfo['given_name'] ?? $userInfo['first_name'] ?? 'Usuário';
        if (!empty($userInfo['given_name']) && !empty($userInfo['family_name'])) {
            $name = $userInfo['given_name'] . ' ' . $userInfo['family_name'];
        }
        $picture = $userInfo['picture'] ?? $userInfo['avatar'] ?? null;
        
        $isNewUser = false;
        
        if (!$user) {
            $isNewUser = true;
            $user = $usersTable->newEntity([
                'email' => $userInfo['email'],
                'nome' => $name,
                'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'status' => 'ativo',
                'role' => 'user',
                'nivel_ingles' => 'iniciante',
                'idioma_preferido' => 'pt-BR',
                'foto_perfil' => $picture,
            ]);
            $usersTable->save($user);
        } else {
            $updateData = [];
            if (empty($user->nome) || $user->nome === 'Usuário') {
                $updateData['nome'] = $name;
            }
            if (empty($user->foto_perfil) && $picture) {
                $updateData['foto_perfil'] = $picture;
            }
            if (!empty($updateData)) {
                $user = $usersTable->patchEntity($user, $updateData);
                $usersTable->save($user);
            }
        }

        // ENVIA E-MAIL DE BOAS-VINDAS PARA NOVOS USUÁRIOS
        if ($isNewUser) {
            try {
                $mailer = new UserMailer();
                $mailer->welcome($user);
            } catch (\Exception $e) {
                error_log("❌ Erro ao enviar e-mail de boas-vindas: " . $e->getMessage());
            }
        }

        $result = $this->socialAuthService->handleLogin($user);

        $frontendUrl = env('APP_BASE_URL');
        $redirectUrl = $frontendUrl . 'oauth-callback?' . http_build_query([
            'token' => $result['tokens']['access_token'],
            'refresh_token' => $result['tokens']['refresh_token'],
            'user' => json_encode($result['user'])
        ]);

        return $this->redirect($redirectUrl);
    }

    // GOOGLE
    private function getGoogleAccessToken(string $code): ?array
    {
        $http = new Client();
        $response = $http->post(env('GOOGLE_TOKEN_URL'), [
            'code' => $code,
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
            'grant_type' => 'authorization_code',
        ]);

        if ($response->isOk()) {
            return $response->getJson();
        }

        error_log("Erro ao obter token Google: " . $response->getBody());
        return null;
    }

    private function getGoogleUserInfo(string $accessToken): ?array
    {
        $http = new Client();
        $response = $http->get(
            env('GOOGLE_USERINFO_URL'),
            [],
            ['headers' => ['Authorization' => 'Bearer ' . $accessToken]]
        );

        if ($response->isOk()) {
            return $response->getJson();
        }

        error_log("Erro ao obter user info Google: " . $response->getBody());
        return null;
    }

    // FACEBOOK
    private function getFacebookAccessToken(string $code): ?array
    {
        $http = new Client();
        $response = $http->get(env('FACEBOOK_TOKEN_URL'), [
            'client_id' => env('FACEBOOK_CLIENT_ID'),
            'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
            'redirect_uri' => env('FACEBOOK_REDIRECT_URI'),
            'code' => $code,
        ]);

        if ($response->isOk()) {
            return $response->getJson();
        }

        error_log("Erro ao obter token Facebook: " . $response->getBody());
        return null;
    }

    private function getFacebookUserInfo(string $accessToken): ?array
    {
        $http = new Client();
        $response = $http->get(env('FACEBOOK_USERINFO_URL'), [
            'fields' => 'id,name,email,picture',
            'access_token' => $accessToken,
        ]);

        if ($response->isOk()) {
            $data = $response->getJson();
            if (isset($data['picture']['data']['url'])) {
                $data['picture'] = $data['picture']['data']['url'];
            }
            return $data;
        }

        error_log("Erro ao obter user info Facebook: " . $response->getBody());
        return null;
    }

    // LINKEDIN
    private function getLinkedInAccessToken(string $code): ?array
    {
        $http = new Client();
        $response = $http->post(env('LINKEDIN_TOKEN_URL'), [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'client_id' => env('LINKEDIN_CLIENT_ID'),
            'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
            'redirect_uri' => env('LINKEDIN_REDIRECT_URI'),
        ], ['headers' => ['Content-Type' => 'application/x-www-form-urlencoded']]);

        if ($response->isOk()) {
            return $response->getJson();
        }

        error_log("Erro ao obter token LinkedIn: " . $response->getBody());
        return null;
    }

    private function getLinkedInUserInfo(string $accessToken): ?array
    {
        $http = new Client();
        $response = $http->get(
            env('LINKEDIN_USERINFO_URL'),
            [],
            ['headers' => ['Authorization' => 'Bearer ' . $accessToken]]
        );

        if ($response->isOk()) {
            return $response->getJson();
        }

        error_log("Erro ao obter user info LinkedIn: " . $response->getBody());
        return null;
    }
}