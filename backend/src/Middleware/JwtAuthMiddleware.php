<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Cake\Http\Response;
use App\Services\JwtService;

class JwtAuthMiddleware implements MiddlewareInterface
{
    private JwtService $jwtService;
    
    private array $publicRoutes = [
        '/', '/health', '/auth/login', '/auth/register', 
        '/auth/forgot-password', '/auth/reset-password',
        '/auth/refresh'
    ];
    
    public function __construct()
    {
        $this->jwtService = new JwtService();
    }
    
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        
        // Rotas públicas não precisam de token
        if ($this->isPublicRoute($path)) {
            return $handler->handle($request);
        }
        
        $token = $this->jwtService->getTokenFromRequest($request);
        
        if (!$token) {
            return $this->jsonError('Token não informado', 401);
        }
        
        $payload = $this->jwtService->validateToken($token);
        
        if (!$payload) {
            return $this->jsonError('Token inválido ou expirado', 401);
        }
        
        if ($payload['type'] !== 'access') {
            return $this->jsonError('Tipo de token inválido', 401);
        }
        
        // Adiciona dados do usuário na requisição
        $request = $request->withAttribute('user_id', $payload['sub'])
                           ->withAttribute('user_email', $payload['email'])
                           ->withAttribute('user_role', $payload['role']);
        
        return $handler->handle($request);
    }
    
    private function isPublicRoute(string $path): bool
    {
        foreach ($this->publicRoutes as $route) {
            if (strpos($path, $route) === 0) {
                return true;
            }
        }
        return false;
    }
    
    private function jsonError(string $message, int $status): ResponseInterface
    {
        $response = new Response([
            'status' => $status,
            'type' => 'application/json',
            'body' => json_encode([
                'success' => false,
                'message' => $message
            ])
        ]);
        
        return $response->withHeader('Content-Type', 'application/json');
    }
}