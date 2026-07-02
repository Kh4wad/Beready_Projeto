<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class FlashcardsFixture extends TestFixture
{
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'usuario_id' => 1,
                'frente' => 'What is the capital of Brazil?',
                'verso' => 'Brasília',
                'nivel_dificuldade' => 'iniciante',
                'criado_em' => date('Y-m-d H:i:s'),
                'atualizado_em' => date('Y-m-d H:i:s'),
                'uuid' => '11111111-1111-1111-1111-111111111111',
            ],
            [
                'id' => 2,
                'usuario_id' => 1,
                'frente' => 'What is the largest ocean?',
                'verso' => 'Pacific Ocean',
                'nivel_dificuldade' => 'intermediario',
                'criado_em' => date('Y-m-d H:i:s'),
                'atualizado_em' => date('Y-m-d H:i:s'),
                'uuid' => '22222222-2222-2222-2222-222222222222',
            ],
            [
                'id' => 3,
                'usuario_id' => 2,
                'frente' => 'What is the smallest country?',
                'verso' => 'Vatican City',
                'nivel_dificuldade' => 'avancado',
                'criado_em' => date('Y-m-d H:i:s'),
                'atualizado_em' => date('Y-m-d H:i:s'),
                'uuid' => '33333333-3333-3333-3333-333333333333',
            ],
        ];
        parent::init();
    }
}