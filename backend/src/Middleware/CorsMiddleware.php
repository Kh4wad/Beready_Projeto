<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Cake\Http\Response;

class CorsMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Origens permitidas (pode vir do .env)
        $allowedOrigins = explode(',', env('CORS_ALLOWED_ORIGINS'));
        
        $origin = $request->getHeaderLine('Origin');
        
        // Se a origem estiver na lista, usa ela; senão, usa a primeira
        $allowedOrigin = in_array($origin, $allowedOrigins) ? $origin : $allowedOrigins[0];

        // Log para debug
        error_log("CORS - Origin: " . $origin);
        error_log("CORS - Allowed Origin: " . $allowedOrigin);

        // Responde requisições OPTIONS (preflight)
        if ($request->getMethod() === 'OPTIONS') {
            $response = new Response();
            return $response
                ->withStatus(200)
                ->withHeader('Access-Control-Allow-Origin', $allowedOrigin)
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
                ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-CSRF-Token, X-Requested-With, Accept, Cache-Control')
                ->withHeader('Access-Control-Allow-Credentials', 'true')
                ->withHeader('Access-Control-Max-Age', '86400');
        }

        // Processa a requisição normal
        $response = $handler->handle($request);

        // Adiciona os headers CORS na resposta
        return $response
            ->withHeader('Access-Control-Allow-Origin', $allowedOrigin)
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-CSRF-Token, X-Requested-With, Accept, Cache-Control')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Expose-Headers', 'Authorization, X-CSRF-Token');
    }
}
