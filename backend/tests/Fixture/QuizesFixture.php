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
                'usuario_id' => 1,
                'titulo' => 'Geography Quiz',
                'descricao' => 'Test your geography knowledge',
                'tipo_criacao' => 'manual',
                'nivel_dificuldade' => 'intermediario',
                'total_questoes' => 10,
                'tempo_limite' => 30,
                'publico' => true,
                'criado_em' => date('Y-m-d H:i:s'),
                'atualizado_em' => date('Y-m-d H:i:s'),
                'uuid' => 'dddddddd-dddd-dddd-dddd-dddddddddddd',
            ],
            [
                'id' => 2,
                'usuario_id' => 1,
                'titulo' => 'English Vocabulary',
                'descricao' => 'Test your English skills',
                'tipo_criacao' => 'ia_gerado',
                'nivel_dificuldade' => 'iniciante',
                'total_questoes' => 5,
                'tempo_limite' => 15,
                'publico' => false,
                'criado_em' => date('Y-m-d H:i:s'),
                'atualizado_em' => date('Y-m-d H:i:s'),
                'uuid' => 'eeeeeeee-eeee-eeee-eeee-eeeeeeeeeeee',
            ],
        ];
        parent::init();
    }
}