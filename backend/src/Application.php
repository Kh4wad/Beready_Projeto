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
use App\Exceptions\SentryExceptionRenderer;

use ADmad\SocialAuth\Middleware\SocialAuthMiddleware;

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

        // Body Parser
        $middlewareQueue->add(new \Cake\Http\Middleware\BodyParserMiddleware());

        // Rate Limit
        $middlewareQueue->add(new RateLimitMiddleware(100, 60));

        // JWT
        $middlewareQueue->add(new JwtAuthMiddleware());

        // Error Handler
         $middlewareQueue->add(new ErrorHandlerMiddleware([
            'exceptionRenderer' => \App\Exceptions\SentryExceptionRenderer::class
        ]));

        // Router
        $middlewareQueue->add(new \Cake\Routing\Middleware\RoutingMiddleware($this));

        // SOCIAL AUTH
        $middlewareQueue->add(new SocialAuthMiddleware([
            'requestMethod' => 'GET',
            'loginUrl' => '/login',
            'loginRedirect' => env('APP_BASE_URL') . 'oauth-callback',
            'userModel' => 'Users',
            'userFinder' => 'getUser',
            'redirectUri' => env('GOOGLE_REDIRECT_URI'),
            'serviceConfig' => [
                'provider' => [
                    'google' => [
                        'applicationId' => env('GOOGLE_CLIENT_ID'),
                        'applicationSecret' => env('GOOGLE_CLIENT_SECRET'),
                        'redirectUri' => env('GOOGLE_REDIRECT_URI'),
                        'scope' => [
                            'https://www.googleapis.com/auth/userinfo.email',
                            'https://www.googleapis.com/auth/userinfo.profile',
                        ],
                    ],
                    'facebook' => [
                        'applicationId' => env('FACEBOOK_CLIENT_ID'),
                        'applicationSecret' => env('FACEBOOK_CLIENT_SECRET'),
                        'redirectUri' => env('FACEBOOK_REDIRECT_URI'),
                        'scope' => ['email', 'public_profile'],
                    ],
                    'linkedin' => [
                        'applicationId' => env('LINKEDIN_CLIENT_ID'),
                        'applicationSecret' => env('LINKEDIN_CLIENT_SECRET'),
                        'redirectUri' => env('LINKEDIN_REDIRECT_URI'),
                        'scope' => ['openid', 'profile', 'email'],
                    ],
                ],
            ],
        ]));

        // Asset
        $middlewareQueue->add(new \Cake\Routing\Middleware\AssetMiddleware());

        return $middlewareQueue;
    }

    public function routes(RouteBuilder $routes): void
    {
        require CONFIG . 'routes.php';
    }
}
