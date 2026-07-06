<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ProgressoUsuarioFixture extends TestFixture
{
    public string $table = 'progresso_usuario';

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'quiz_id' => 1,
                'pontuacao' => 85,
                'respostas_corretas' => 17,
                'respostas_erradas' => 3,
                'tempo_gasto' => 120,
                'concluido' => 1,
                'criado_em' => '2026-07-05 21:30:58',
                'atualizado_em' => '2026-07-05 21:30:58',
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'quiz_id' => 1,
                'pontuacao' => 60,
                'respostas_corretas' => 12,
                'respostas_erradas' => 8,
                'tempo_gasto' => 150,
                'concluido' => 1,
                'criado_em' => '2026-07-05 21:30:58',
                'atualizado_em' => '2026-07-05 21:30:58',
            ],
        ];
        parent::init();
    }
}
