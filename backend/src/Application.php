<?php
declare(strict_types=1);

namespace App;

use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;
use App\Middleware\CorsMiddleware;
use App\Middleware\RateLimitMiddleware;
use App\Middleware\JwtAuthMiddleware;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\Response;

// Exceptions custom
use App\Exceptions\EmailAlreadyExistsException;
use App\Exceptions\WeakPasswordException;
use App\Exceptions\InvalidTokenException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\FlashcardNotFoundException;
use App\Exceptions\QuizNotFoundException;

class Application extends BaseApplication
{
    public function bootstrap(): void
    {
        parent::bootstrap();
        
        $dsn = env('SENTRY_DSN');
        if (!empty($dsn)) {
            \Sentry\init([
                'dsn' => $dsn,
                'environment' => env('APP_ENV', 'development'),
                'traces_sample_rate' => 1.0,
                'send_default_pii' => false,
                'release' => '1.0.0',
                'http_ssl_verify_peer' => false,
            ]);
        }
    }

    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        // CORS
        $middlewareQueue->add(new CorsMiddleware());

        // Rate Limit
        $middlewareQueue->add(new RateLimitMiddleware(100, 60));

        // JWT
        $middlewareQueue->add(new JwtAuthMiddleware());

        // Error Handler
        $middlewareQueue->add(new ErrorHandlerMiddleware([
            'exceptionRenderer' => function ($exception, $request) {
                \Sentry\captureException($exception);
                \Sentry\flush(2000);

                $status = 500;
                $message = $exception->getMessage();

                if ($exception instanceof EmailAlreadyExistsException) $status = 409;
                elseif ($exception instanceof WeakPasswordException) $status = 400;
                elseif ($exception instanceof InvalidTokenException) $status = 400;
                elseif ($exception instanceof UserNotFoundException) $status = 404;
                elseif ($exception instanceof FlashcardNotFoundException) $status = 404;
                elseif ($exception instanceof QuizNotFoundException) $status = 404;
                elseif ($exception instanceof \InvalidArgumentException) $status = 400;
                elseif ($exception instanceof \RuntimeException && $exception->getCode() === 404) $status = 404;

                return new Response([
                    'status' => $status,
                    'type' => 'application/json',
                    'body' => json_encode([
                        'success' => false,
                        'message' => $message
                    ])
                ]);
            }
        ]));

        // Body Parser
        $middlewareQueue->add(new \Cake\Http\Middleware\BodyParserMiddleware());

        // Router
        $middlewareQueue->add(new \Cake\Routing\Middleware\RoutingMiddleware($this));

        // Asset
        $middlewareQueue->add(new \Cake\Routing\Middleware\AssetMiddleware());

        return $middlewareQueue;
    }

    public function routes(RouteBuilder $routes): void
    {
        require CONFIG . 'routes.php';
    }
}