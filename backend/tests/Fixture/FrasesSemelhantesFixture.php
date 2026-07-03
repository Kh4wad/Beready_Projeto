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
                'pontuacao_semelhante' => 0.95,
                'tipo_frase' => 'relacionada',
                'nivel_dificuldade' => 'iniciante',
                'criado_em' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'prompt_id' => 1,
                'frase_semelhante' => 'Brasília is the capital of Brazil',
                'pontuacao_semelhante' => 0.90,
                'tipo_frase' => 'relacionada',
                'nivel_dificuldade' => 'iniciante',
                'criado_em' => date('Y-m-d H:i:s'),
            ],
        ];
        parent::init();
    }
}
