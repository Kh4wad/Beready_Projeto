<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class TagsFixture extends TestFixture
{
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'nome' => 'Geography',
                'criado_em' => '2026-07-05 21:29:21',
                'atualizado_em' => '2026-07-05 21:29:21', // ADICIONE ESTE CAMPO
            ],
            [
                'id' => 2,
                'nome' => 'English',
                'criado_em' => '2026-07-05 21:29:21',
                'atualizado_em' => '2026-07-05 21:29:21', // ADICIONE ESTE CAMPO
            ],
            [
                'id' => 3,
                'nome' => 'Science',
                'criado_em' => '2026-07-05 21:29:21',
                'atualizado_em' => '2026-07-05 21:29:21', // ADICIONE ESTE CAMPO
            ],
        ];
        parent::init();
    }
}
