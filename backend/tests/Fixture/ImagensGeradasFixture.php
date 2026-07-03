<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ImagensGeradasFixture extends TestFixture
{
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'prompt_id' => 1,
                'traducao_id' => null,
                'url_imagem' => 'https://example.com/image1.jpg',
                'prompt_imagem' => 'A beautiful landscape',
                'servico_geracao' => 'dalle',
                'qualidade_imagem' => 'alta',
                'tamanho_arquivo' => 1024,
                'dimensoes' => '1024x1024',
                'criado_em' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'prompt_id' => 2,
                'traducao_id' => 1,
                'url_imagem' => 'https://example.com/image2.jpg',
                'prompt_imagem' => 'A city at night',
                'servico_geracao' => 'midjourney',
                'qualidade_imagem' => 'media',
                'tamanho_arquivo' => 512,
                'dimensoes' => '512x512',
                'criado_em' => date('Y-m-d H:i:s'),
            ],
        ];
        parent::init();
    }
}
