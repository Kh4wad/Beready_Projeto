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
                'usuario_id' => 1,
                'tema' => 'escuro',
                'modo_daltonico' => false,
                'notificacoes_ativas' => true,
                'som_ativo' => true,
                'traducao_automatica' => true,
                'preferencia_dificuldade' => 'adaptativo',
                'meta_diaria_minutos' => 30,
                'criado_em' => date('Y-m-d H:i:s'),
                'atualizado_em' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'usuario_id' => 2,
                'tema' => 'claro',
                'modo_daltonico' => false,
                'notificacoes_ativas' => true,
                'som_ativo' => true,
                'traducao_automatica' => true,
                'preferencia_dificuldade' => 'intermediario',
                'meta_diaria_minutos' => 45,
                'criado_em' => date('Y-m-d H:i:s'),
                'atualizado_em' => date('Y-m-d H:i:s'),
            ],
        ];
        parent::init();
    }
}