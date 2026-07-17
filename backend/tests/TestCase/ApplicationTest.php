<?php

declare(strict_types=1);

namespace App\Test\TestCase;

use App\Application;
use App\Middleware\CorsMiddleware;
use App\Middleware\JwtAuthMiddleware;
use App\Middleware\RateLimitMiddleware;
use ADmad\SocialAuth\Middleware\SocialAuthMiddleware;
use Cake\Core\Configure;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * ApplicationTest class
 */
class ApplicationTest extends TestCase
{
    use IntegrationTestTrait;

    public function testBootstrap()
    {
        Configure::write('debug', false);
        $app = new Application(dirname(__DIR__, 2) . '/config');
        $app->bootstrap();
        $plugins = $app->getPlugins();

        $this->assertTrue($plugins->has('Bake'));
        $this->assertFalse($plugins->has('DebugKit'));
        $this->assertTrue($plugins->has('Migrations'));
    }

    public function testBootstrapInDebug()
    {
        Configure::write('debug', true);
        $app = new Application(dirname(__DIR__, 2) . '/config');
        $app->bootstrap();
        $plugins = $app->getPlugins();

        $this->assertTrue($plugins->has('DebugKit'));
    }

    public function testMiddleware()
    {
        $app = new Application(dirname(__DIR__, 2) . '/config');
        $middleware = new MiddlewareQueue();

        $middleware = $app->middleware($middleware);

        // ORDEM ATUAL DOS MIDDLEWARES (com SocialAuth)

        // Posição 0: CorsMiddleware
        $middleware->seek(0);
        $this->assertInstanceOf(CorsMiddleware::class, $middleware->current());

        // Posição 1: BodyParserMiddleware
        $middleware->seek(1);
        $this->assertInstanceOf(BodyParserMiddleware::class, $middleware->current());

        // Posição 2: RateLimitMiddleware
        $middleware->seek(2);
        $this->assertInstanceOf(RateLimitMiddleware::class, $middleware->current());

        // Posição 3: JwtAuthMiddleware
        $middleware->seek(3);
        $this->assertInstanceOf(JwtAuthMiddleware::class, $middleware->current());

        // Posição 4: ErrorHandlerMiddleware
        $middleware->seek(4);
        $this->assertInstanceOf(ErrorHandlerMiddleware::class, $middleware->current());

        // Posição 5: RoutingMiddleware
        $middleware->seek(5);
        $this->assertInstanceOf(RoutingMiddleware::class, $middleware->current());

        // Posição 6: SocialAuthMiddleware
        $middleware->seek(6);
        $this->assertInstanceOf(SocialAuthMiddleware::class, $middleware->current());

        // Posição 7: AssetMiddleware
        $middleware->seek(7);
        $this->assertInstanceOf(AssetMiddleware::class, $middleware->current());
    }
}
