<?php
declare(strict_types=1);

namespace App;

use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;
use App\Middleware\CorsMiddleware;
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
    }

    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            // 1. CORS primeiro (headers globais)
            ->add(new CorsMiddleware())

            // 2. ERROR HANDLER (tem que vir cedo)
            ->add(new ErrorHandlerMiddleware([
                'exceptionRenderer' => function ($exception, $request) {

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
            ]))

            // 3. Body parser (JSON POST/PUT)
            ->add(new \Cake\Http\Middleware\BodyParserMiddleware())

            // 4. Router
            ->add(new \Cake\Routing\Middleware\RoutingMiddleware($this))

            // 5. Assets
            ->add(new \Cake\Routing\Middleware\AssetMiddleware());

        return $middlewareQueue;
    }

    public function routes(RouteBuilder $routes): void
    {
        require CONFIG . 'routes.php';
    }
}