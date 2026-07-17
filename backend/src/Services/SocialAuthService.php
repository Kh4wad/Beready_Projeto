<?php
declare(strict_types=1);

namespace App\Services;

use Cake\ORM\TableRegistry;

class SocialAuthService
{
    private JwtService $jwtService;

    public function __construct()
    {
        $this->jwtService = new JwtService();
    }

    /**
     * Handle login social
     */
    public function handleLogin($user): array
    {
        // Se for Entity, converte para array
        if (is_object($user) && method_exists($user, 'toArray')) {
            $userArray = $user->toArray();
        } else if (is_array($user)) {
            $userArray = $user;
        } else {
            throw new \InvalidArgumentException('Usuário inválido');
        }

        // Remove a senha do array
        unset($userArray['senha_hash']);

        // Gera os tokens JWT (passa o ARRAY)
        $tokens = $this->jwtService->generateTokens($userArray);

        return [
            'user' => $userArray,
            'tokens' => $tokens
        ];
    }
}