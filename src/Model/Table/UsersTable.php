<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;

class UsuariosTable extends Table
{
    /**
     * Initialize method
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Nome da tabela no banco
        $this->setTable('usuarios');

        // Campo de exibição
        $this->setDisplayField('nome');

        // Chave primária
        $this->setPrimaryKey('id');

        // Comportamento de timestamps (created, modified)
        $this->addBehavior('Timestamp');

        // Relacionamentos (exemplo, se existir)
        // $this->hasMany('Flashcards', ['foreignKey' => 'usuario_id']);
        // $this->hasMany('LoginsLog', ['foreignKey' => 'usuario_id']);
    }

    /**
     * Regras de validação padrão
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('nome')
            ->maxLength('nome', 100)
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome', 'O nome é obrigatório.');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email', 'O e-mail é obrigatório.');

        $validator
            ->scalar('senha_hash')
            ->maxLength('senha_hash', 255)
            ->requirePresence('senha_hash', 'create')
            ->notEmptyString('senha_hash', 'A senha é obrigatória.');

        return $validator;
    }

    /**
     * Regras de integridade da aplicação
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        // E-mail único
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email', 'message' => 'Este e-mail já está cadastrado.']);

        return $rules;
    }
}
