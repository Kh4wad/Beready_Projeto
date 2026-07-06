<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class PreferenciasUsuarioFixture extends TestFixture
{
    public string $table = 'preferencias_usuario';

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'tema' => 'escuro',
                'notificacoes' => 1,
                'idioma_preferido' => 'pt-BR',
                'criado_em' => '2026-07-05 21:30:58',
                'atualizado_em' => '2026-07-05 21:30:58',
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'tema' => 'claro',
                'notificacoes' => 0,
                'idioma_preferido' => 'en',
                'criado_em' => '2026-07-05 21:30:58',
                'atualizado_em' => '2026-07-05 21:30:58',
            ],
        ];
        parent::init();
    }
}
