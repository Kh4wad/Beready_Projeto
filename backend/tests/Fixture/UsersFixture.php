<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture
{
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'uuid' => '11111111-1111-1111-1111-111111111111',
                'nome' => 'Admin User',
                'email' => 'admin@test.com',
                'senha_hash' => 'password_hash_1',
                'telefone' => '11999999999',
                'nivel_ingles' => 'avancado',
                'idioma_preferido' => 'pt-BR',
                'status' => 'ativo',
                'criado_em' => date('Y-m-d H:i:s'),
                'atualizado_em' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'uuid' => '22222222-2222-2222-2222-222222222222',
                'nome' => 'Test User',
                'email' => 'test@test.com',
                'senha_hash' => 'password_hash_2',
                'telefone' => '11888888888',
                'nivel_ingles' => 'intermediario',
                'idioma_preferido' => 'en',
                'status' => 'ativo',
                'criado_em' => date('Y-m-d H:i:s'),
                'atualizado_em' => date('Y-m-d H:i:s'),
            ],
        ];
        parent::init();
    }
}
