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
                'user_id' => 1,
                'palavra' => 'Hello',
                'traducao' => 'Olá',
                'nivel' => 'iniciante',
                'criado_em' => '2026-07-05 21:44:23',
                'atualizado_em' => '2026-07-05 21:44:23',
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'palavra' => 'Goodbye',
                'traducao' => 'Adeus',
                'nivel' => 'iniciante',
                'criado_em' => '2026-07-05 21:44:23',
                'atualizado_em' => '2026-07-05 21:44:23',
            ],
        ];
        parent::init();
    }
}
