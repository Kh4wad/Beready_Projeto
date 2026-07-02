<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class TraducoesFixture extends TestFixture
{
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'prompt_id' => 1,
                'texto_traduzido' => 'Olá mundo, isso é um teste',
                'idioma_destino' => 'pt-BR',
                'pontuacao_confianca' => 0.98,
                'servico_traducao' => 'google',
                'traducoes_alternativas' => json_encode(['Olá mundo, isto é um teste']),
                'criado_em' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'prompt_id' => 2,
                'texto_traduzido' => 'Outro prompt de teste',
                'idioma_destino' => 'en',
                'pontuacao_confianca' => 0.95,
                'servico_traducao' => 'deepL',
                'traducoes_alternativas' => null,
                'criado_em' => date('Y-m-d H:i:s'),
            ],
        ];
        parent::init();
    }
}