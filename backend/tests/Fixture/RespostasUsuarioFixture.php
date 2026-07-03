<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class RespostasUsuarioFixture extends TestFixture
{
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'usuario_id' => 1,
                'tipo' => 'flashcard',
                'referencia_id' => 1,
                'correto' => true,
                'criado_em' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'usuario_id' => 1,
                'tipo' => 'quiz',
                'referencia_id' => 1,
                'correto' => false,
                'criado_em' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'usuario_id' => 2,
                'tipo' => 'flashcard',
                'referencia_id' => 2,
                'correto' => true,
                'criado_em' => date('Y-m-d H:i:s'),
            ],
        ];
        parent::init();
    }
}
