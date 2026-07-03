<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * User Entity
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     */
    protected array $_accessible = [
        'nome' => true,
        'email' => true,
        'senha' => true,
        'senha_hash' => true,
        'telefone' => true,
        'nivel_ingles' => true,
        'idioma_preferido' => true,
        'objetivos_aprendizado' => true,
        'foto_perfil' => true,
        'status' => true,
        'token' => true,
        'token_expires' => true,
        'criado_em' => true,
        'atualizado_em' => true,
        'ultimo_login' => true,
        'confirmar_senha' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     */
    protected array $_hidden = [
        'senha_hash',
        'senha',
        'token',
    ];

    /**
     * Virtual fields
     */
    protected array $_virtual = ['confirmar_senha'];

    /**
     * Setter for password - hashes the password and stores in senha_hash
     *
     * @param string $senha The plain text password
     * @return void
     */
    protected function setSenha(string $senha): void
    {
        if (strlen($senha) > 0) {
            $this->set('senha_hash', (new DefaultPasswordHasher())->hash($senha));
        }
    }

    /**
     * Getter for confirmar_senha virtual field
     *
     * @return null
     */
    protected function getConfirmarSenha()
    {
        return null;
    }
}
