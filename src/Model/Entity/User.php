<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $senha_hash
 * @property string|null $telefone
 * @property string|null $nivel_ingles
 * @property string|null $idioma_preferido
 * @property string|null $objetivos_aprendizado
 * @property string $status
 * @property string|null $token
 * @property \Cake\I18n\DateTime|null $token_expires
 * @property \Cake\I18n\DateTime $criado_em
 * @property \Cake\I18n\DateTime $atualizado_em
 * @property \Cake\I18n\DateTime|null $ultimo_login
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     */
    protected array $_accessible = [
        'nome' => true,
        'email' => true,
        'senha_hash' => true,
        'telefone' => true,
        'nivel_ingles' => true,
        'idioma_preferido' => true,
        'objetivos_aprendizado' => true,
        'status' => true,
        'token' => true,
        'token_expires' => true,
        'criado_em' => true,
        'atualizado_em' => true,
        'ultimo_login' => true,
        'confirmar_senha' => true, // Campo virtual para confirmação
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     */
    protected array $_hidden = [
        'senha_hash',
        'token',
    ];

    // Campos virtuais
    protected array $_virtual = ['confirmar_senha'];

    // Automaticamente hasheia a senha quando setar 'senha_hash'
    protected function _setSenhaHash(string $senha): ?string
    {
        if (strlen($senha) > 0) {
            return (new DefaultPasswordHasher())->hash($senha);
        }
        return null;
    }

    // Getter para o campo virtual confirmar_senha
    protected function _getConfirmarSenha()
    {
        return null; // Sempre retorna null pois é apenas para validação
    }
}