<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class FrasesSemelhantesFixture extends TestFixture
{
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'prompt_id' => 1,
                'frase_semelhante' => 'The capital city of Brazil is Brasília',
                'idioma' => 'en', // ADICIONE ESTE CAMPO
                'pontuacao_similaridade' => 0.95,
                'criado_em' => '2026-07-05 21:30:58',
            ],
            [
                'id' => 2,
                'prompt_id' => 1,
                'frase_semelhante' => 'Brasília is the capital of Brazil',
                'idioma' => 'en', // ADICIONE ESTE CAMPO
                'pontuacao_similaridade' => 0.90,
                'criado_em' => '2026-07-05 21:30:58',
            ],
        ];
        parent::init();
    }
}
