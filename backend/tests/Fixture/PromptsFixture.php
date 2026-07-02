<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class PromptsFixture extends TestFixture
{
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'usuario_id' => 1,
                'texto_original' => 'Hello world, this is a test',
                'idioma_original' => 'en',
                'contexto' => 'manual',
                'midia_origem_id' => null,
                'sessao_id' => 'session_123',
                'criado_em' => date('Y-m-d H:i:s'),
                'uuid' => 'aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa',
            ],
            [
                'id' => 2,
                'usuario_id' => 1,
                'texto_original' => 'Another test prompt',
                'idioma_original' => 'pt-BR',
                'contexto' => 'conversacao',
                'midia_origem_id' => null,
                'sessao_id' => 'session_456',
                'criado_em' => date('Y-m-d H:i:s'),
                'uuid' => 'bbbbbbbb-bbbb-bbbb-bbbb-bbbbbbbbbbbb',
            ],
            [
                'id' => 3,
                'usuario_id' => 2,
                'texto_original' => 'Third prompt for testing',
                'idioma_original' => 'en',
                'contexto' => 'manual',
                'midia_origem_id' => null,
                'sessao_id' => null,
                'criado_em' => date('Y-m-d H:i:s'),
                'uuid' => 'cccccccc-cccc-cccc-cccc-cccccccccccc',
            ],
        ];
        parent::init();
    }
}