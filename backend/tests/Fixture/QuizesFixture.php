<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class QuizesFixture extends TestFixture
{
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1, // ADICIONE ESTE CAMPO
                'titulo' => 'Geography Quiz',
                'descricao' => 'Test your geography knowledge',
                'nivel_dificuldade' => 'intermediario',
                'pontuacao_maxima' => 100,
                'criado_em' => '2026-07-05 21:30:58',
                'atualizado_em' => '2026-07-05 21:30:58',
            ],
            [
                'id' => 2,
                'user_id' => 1, // ADICIONE ESTE CAMPO
                'titulo' => 'English Vocabulary',
                'descricao' => 'Test your English skills',
                'nivel_dificuldade' => 'iniciante',
                'pontuacao_maxima' => 50,
                'criado_em' => '2026-07-05 21:30:58',
                'atualizado_em' => '2026-07-05 21:30:58',
            ],
        ];
        parent::init();
    }
}
