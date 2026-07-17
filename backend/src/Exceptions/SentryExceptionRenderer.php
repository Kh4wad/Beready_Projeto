<?php
declare(strict_types=1);

namespace App\Exceptions;

use Cake\Error\ExceptionRendererInterface;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Throwable;

// Importa suas exceções
use App\Exceptions\EmailAlreadyExistsException;
use App\Exceptions\WeakPasswordException;
use App\Exceptions\InvalidTokenException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\FlashcardNotFoundException;
use App\Exceptions\QuizNotFoundException;

class SentryExceptionRenderer implements ExceptionRendererInterface
{
    private Throwable $error;
    private ?ServerRequest $request = null;
    private ?Response $response = null;

    public function __construct(Throwable $error, ?ServerRequest $request = null)
    {
        $this->error = $error;
        $this->request = $request;
    }

    public function render(): Response
    {
        $exception = $this->error;
        
        try {
            \Sentry\captureException($exception);
            \Sentry\flush(2000);
        } catch (\Exception $e) {
            error_log("Sentry error: " . $e->getMessage());
        }

        $status = 500;
        $message = $exception->getMessage();

        // Mapeia exceções customizadas
        if ($exception instanceof EmailAlreadyExistsException) {
            $status = 409;
        } elseif ($exception instanceof WeakPasswordException) {
            $status = 400;
        } elseif ($exception instanceof InvalidTokenException) {
            $status = 400;
        } elseif ($exception instanceof UserNotFoundException) {
            $status = 404;
        } elseif ($exception instanceof FlashcardNotFoundException) {
            $status = 404;
        } elseif ($exception instanceof QuizNotFoundException) {
            $status = 404;
        } elseif ($exception instanceof \InvalidArgumentException) {
            $status = 400;
        } elseif ($exception instanceof \RuntimeException && $exception->getCode() === 404) {
            $status = 404;
        }

        $responseData = [
            'success' => false,
            'message' => $message
        ];

        if (env('APP_ENV', 'development') === 'development') {
            $responseData['debug'] = [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'type' => get_class($exception)
            ];
        }

        $this->response = new Response();
        $this->response = $this->response->withStatus($status);
        $this->response = $this->response->withType('application/json');
        $this->response = $this->response->withStringBody(json_encode($responseData));

        return $this->response;
    }

    public function write(ResponseInterface|string $output): void
    {
        if (is_string($output)) {
            $response = new Response();
            $response = $response->withStringBody($output);
            $output = $response;
        }

        if ($output instanceof ResponseInterface) {
            foreach ($output->getHeaders() as $name => $values) {
                foreach ($values as $value) {
                    header(sprintf('%s: %s', $name, $value), false);
                }
            }
            
            $statusLine = sprintf(
                'HTTP/%s %d %s',
                $output->getProtocolVersion(),
                $output->getStatusCode(),
                $output->getReasonPhrase()
            );
            header($statusLine, true, $output->getStatusCode());
            
            echo (string) $output->getBody();
        }
    }
}