<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class TagsFixture extends TestFixture
{
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'criado_por' => 1,
                'nome' => 'Geography',
                'cor' => '#4CAF50',
                'descricao' => 'Geography related tags',
                'tag_sistema' => false,
                'criado_em' => date('Y-m-d H:i:s'),
                'uuid' => '11111111-1111-1111-1111-111111111111',  // UUID único
            ],
            [
                'id' => 2,
                'criado_por' => 1,
                'nome' => 'English',
                'cor' => '#2196F3',
                'descricao' => 'English language tags',
                'tag_sistema' => true,
                'criado_em' => date('Y-m-d H:i:s'),
                'uuid' => '22222222-2222-2222-2222-222222222222',  // UUID único
            ],
            [
                'id' => 3,
                'criado_por' => 2,
                'nome' => 'Science',
                'cor' => '#FF9800',
                'descricao' => 'Science related tags',
                'tag_sistema' => false,
                'criado_em' => date('Y-m-d H:i:s'),
                'uuid' => '33333333-3333-3333-3333-333333333333',  // UUID único
            ],
        ];
        parent::init();
    }
}
