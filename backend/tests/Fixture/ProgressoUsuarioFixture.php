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
                'usuario_id' => 1,
                'vocabulario_aprendido' => 50,
                'flashcards_concluidos' => 25,
                'quizes_concluidos' => 5,
                'tempo_total_estudo' => 120,
                'sequencia_atual' => 3,
                'maior_sequencia' => 7,
                'ultima_atividade' => date('Y-m-d H:i:s'),
                'progresso_nivel' => json_encode(['iniciante' => 100, 'intermediario' => 0]),
                'atualizado_em' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'usuario_id' => 2,
                'vocabulario_aprendido' => 0,
                'flashcards_concluidos' => 4,
                'quizes_concluidos' => 0,
                'tempo_total_estudo' => 0,
                'sequencia_atual' => 0,
                'maior_sequencia' => 0,
                'ultima_atividade' => null,
                'progresso_nivel' => null,
                'atualizado_em' => date('Y-m-d H:i:s'),
            ],
        ];
        parent::init();
    }
}