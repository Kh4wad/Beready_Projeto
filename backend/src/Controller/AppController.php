<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        
        // Configura CORS
        $this->response = $this->response->withHeader('Access-Control-Allow-Origin', 'http://localhost:5173');
        $this->response = $this->response->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $this->response = $this->response->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-CSRF-Token');
        $this->response = $this->response->withHeader('Access-Control-Allow-Credentials', 'true');
        
        // Força JSON
        $this->response = $this->response->withType('application/json');
        
        // Desabilita views
        $this->autoRender = false;
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        
        // Responde OPTIONS
        if ($this->request->is('options')) {
            $this->response = $this->response->withStatus(200);
            $this->response = $this->response->withStringBody('');
        }
    }
}