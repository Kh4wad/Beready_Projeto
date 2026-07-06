<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class FlashcardsFixture extends TestFixture
{
    public string $table = 'flashcards';

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'uuid' => '11111111-1111-1111-1111-111111111111',
                'frase_original' => 'Hello world',
                'frase_traduzida' => 'Olá mundo',
                'contexto' => 'Saudação',
                'nivel_dificuldade' => 'iniciante',
                'tags' => 'saudacao, basico',
                'vezes_revisada' => 0,
                'ultima_revisao' => null,
                'proxima_revisao' => null,
                'criado_em' => '2026-07-05 21:30:58',
                'atualizado_em' => '2026-07-05 21:30:58',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'uuid' => '22222222-2222-2222-2222-222222222222',
                'frase_original' => 'Good morning',
                'frase_traduzida' => 'Bom dia',
                'contexto' => 'Saudação matinal',
                'nivel_dificuldade' => 'intermediario',
                'tags' => 'saudacao, diario',
                'vezes_revisada' => 0,
                'ultima_revisao' => null,
                'proxima_revisao' => null,
                'criado_em' => '2026-07-05 21:30:58',
                'atualizado_em' => '2026-07-05 21:30:58',
            ],
            [
                'id' => 3,
                'user_id' => 2,
                'uuid' => '33333333-3333-3333-3333-333333333333',
                'frase_original' => 'Thank you',
                'frase_traduzida' => 'Obrigado',
                'contexto' => 'Agradecimento',
                'nivel_dificuldade' => 'avancado',
                'tags' => 'educacao, formal',
                'vezes_revisada' => 0,
                'ultima_revisao' => null,
                'proxima_revisao' => null,
                'criado_em' => '2026-07-05 21:30:58',
                'atualizado_em' => '2026-07-05 21:30:58',
            ],
        ];
        parent::init();
    }
}
