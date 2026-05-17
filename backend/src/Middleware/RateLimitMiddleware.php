<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Cake\Http\Response;

class RateLimitMiddleware implements MiddlewareInterface
{
    /**
     * Limite máximo de requisições por janela de tempo
     */
    private int $maxRequests = 100;
    
    /**
     * Janela de tempo em segundos (1 minuto = 60)
     */
    private int $timeWindow = 60;
    
    /**
     * Cache de requisições (em produção, use Redis/Memcached)
     * Para desenvolvimento, usamos arquivo temporário
     */
    private string $cachePath;
    
    public function __construct(int $maxRequests = 100, int $timeWindow = 60)
    {
        $this->maxRequests = $maxRequests;
        $this->timeWindow = $timeWindow;
        $this->cachePath = TMP . 'rate_limit' . DS;
        
        // Cria diretório de cache se não existir
        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0755, true);
        }
    }
    
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Rotas que NÃO devem ter rate limit (ex: health, static files)
        $excludedPaths = ['/health', '/', '/favicon.ico'];
        $currentPath = $request->getUri()->getPath();
        
        if (in_array($currentPath, $excludedPaths)) {
            return $handler->handle($request);
        }
        
        // Identifica o cliente (IP + endpoint + método)
        $clientId = $this->getClientIdentifier($request);
        
        // Verifica o limite
        $rateLimitData = $this->getRateLimitData($clientId);
        
        // Se excedeu o limite
        if ($rateLimitData['count'] >= $this->maxRequests) {
            $retryAfter = $rateLimitData['reset_time'] - time();
            
            return $this->createRateLimitResponse($retryAfter);
        }
        
        // Incrementa contador
        $this->incrementRateLimit($clientId, $rateLimitData);
        
        // Processa a requisição normalmente
        $response = $handler->handle($request);
        
        // Adiciona headers de rate limit na resposta
        return $this->addRateLimitHeaders($response, $rateLimitData);
    }
    
    /**
     * Identificador único do cliente
     */
    private function getClientIdentifier(ServerRequestInterface $request): string
    {
        $ip = $request->getClientIp() ?? 'unknown';
        $path = $request->getUri()->getPath();
        $method = $request->getMethod();
        
        // Diferencia endpoints sensíveis
        $isSensitive = preg_match('/\/(login|register|forgot-password|reset-password)/', $path);
        
        if ($isSensitive) {
            // Endpoints sensíveis têm limites mais restritivos
            return md5($ip . $path . $method . '_sensitive');
        }
        
        return md5($ip . $path . $method);
    }
    
    /**
     * Recupera dados de rate limit do cache
     */
    private function getRateLimitData(string $clientId): array
    {
        $cacheFile = $this->cachePath . $clientId . '.json';
        $now = time();
        
        if (file_exists($cacheFile)) {
            $data = json_decode(file_get_contents($cacheFile), true);
            
            // Verifica se a janela de tempo expirou
            if ($data['reset_time'] > $now) {
                return $data;
            }
        }
        
        // Nova janela de tempo
        return [
            'count' => 0,
            'reset_time' => $now + $this->timeWindow,
            'limit' => $this->maxRequests
        ];
    }
    
    /**
     * Incrementa o contador de requisições
     */
    private function incrementRateLimit(string $clientId, array &$data): void
    {
        $data['count']++;
        $cacheFile = $this->cachePath . $clientId . '.json';
        file_put_contents($cacheFile, json_encode($data));
        
        // Limpa arquivos antigos (opcional, a cada 100 requisições)
        if (rand(1, 100) === 1) {
            $this->cleanOldCacheFiles();
        }
    }
    
    /**
     * Adiciona headers de rate limit na resposta
     */
    private function addRateLimitHeaders(ResponseInterface $response, array $data): ResponseInterface
    {
        $remaining = max(0, $this->maxRequests - $data['count']);
        $resetTime = $data['reset_time'];
        
        return $response
            ->withHeader('X-RateLimit-Limit', (string)$this->maxRequests)
            ->withHeader('X-RateLimit-Remaining', (string)$remaining)
            ->withHeader('X-RateLimit-Reset', (string)$resetTime);
    }
    
    /**
     * Cria resposta de rate limit excedido
     */
    private function createRateLimitResponse(int $retryAfter): ResponseInterface
    {
        $response = new Response([
            'status' => 429,
            'type' => 'application/json',
            'body' => json_encode([
                'success' => false,
                'message' => 'Muitas requisições. Por favor, aguarde ' . $retryAfter . ' segundos.',
                'retry_after' => $retryAfter
            ])
        ]);
        
        return $response
            ->withHeader('Retry-After', (string)$retryAfter)
            ->withHeader('X-RateLimit-Limit', (string)$this->maxRequests)
            ->withHeader('X-RateLimit-Remaining', '0');
    }
    
    /**
     * Limpa arquivos de cache antigos (mais de 1 hora)
     */
    private function cleanOldCacheFiles(): void
    {
        $files = glob($this->cachePath . '*.json');
        $now = time();
        $maxAge = 3600; // 1 hora
        
        foreach ($files as $file) {
            if ($now - filemtime($file) > $maxAge) {
                @unlink($file);
            }
        }
    }
}