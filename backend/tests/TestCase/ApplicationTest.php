<?php

declare(strict_types=1);

namespace App\Test\TestCase;

use App\Application;
use App\Middleware\CorsMiddleware;
use App\Middleware\JwtAuthMiddleware;
use App\Middleware\RateLimitMiddleware;
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

        // Posição 0: CorsMiddleware
        $this->assertInstanceOf(CorsMiddleware::class, $middleware->current());

        // Posição 1: RateLimitMiddleware
        $middleware->seek(1);
        $this->assertInstanceOf(RateLimitMiddleware::class, $middleware->current());

        // Posição 2: JwtAuthMiddleware
        $middleware->seek(2);
        $this->assertInstanceOf(JwtAuthMiddleware::class, $middleware->current());

        // Posição 3: ErrorHandlerMiddleware
        $middleware->seek(3);
        $this->assertInstanceOf(ErrorHandlerMiddleware::class, $middleware->current());

        // Posição 4: BodyParserMiddleware
        $middleware->seek(4);
        $this->assertInstanceOf(BodyParserMiddleware::class, $middleware->current());

        // Posição 5: RoutingMiddleware
        $middleware->seek(5);
        $this->assertInstanceOf(RoutingMiddleware::class, $middleware->current());

        // Posição 6: AssetMiddleware
        $middleware->seek(6);
        $this->assertInstanceOf(AssetMiddleware::class, $middleware->current());
    }
}
