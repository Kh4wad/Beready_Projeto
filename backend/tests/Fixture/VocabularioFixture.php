<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class VocabularioFixture extends TestFixture
{
    public string $table = 'vocabulario';

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'usuario_id' => 1,
                'palavra_frase' => 'Hello',
                'criado_em' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'usuario_id' => 1,
                'palavra_frase' => 'World',
                'criado_em' => date('Y-m-d H:i:s'),
            ],
        ];
        parent::init();
    }
}
