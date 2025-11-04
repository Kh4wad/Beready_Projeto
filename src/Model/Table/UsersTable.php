<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;

class UsersTable extends Table
{
    /**
     * Initialize method
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'criado_em' => 'new',
                    'atualizado_em' => 'always'
                ]
            ]
        ]);

        // Relacionamentos
        // $this->hasMany('Flashcards', ['foreignKey' => 'usuario_id']);
        // $this->hasMany('LoginsLog', ['foreignKey' => 'user_id']);
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
            ->scalar('senha')
            ->minLength('senha', 6, 'A senha deve ter pelo menos 6 caracteres.')
            ->requirePresence('senha', 'create')
            ->notEmptyString('senha', 'A senha é obrigatória.', 'create')
            ->allowEmptyString('senha', 'update');

        $validator
            ->scalar('telefone')
            ->maxLength('telefone', 20)
            ->allowEmptyString('telefone');

        $validator
            ->scalar('nivel_ingles')
            ->maxLength('nivel_ingles', 50)
            ->allowEmptyString('nivel_ingles');

        $validator
            ->scalar('idioma_preferido')
            ->maxLength('idioma_preferido', 10)
            ->allowEmptyString('idioma_preferido');

        $validator
            ->scalar('objetivos_aprendizado')
            ->allowEmptyString('objetivos_aprendizado');

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->notEmptyString('status')
            ->inList('status', ['ativo', 'inativo'], 'Status deve ser "ativo" ou "inativo"');

        // Validação para confirmação de senha (campo virtual)
        $validator
            ->add('confirmar_senha', 'custom', [
                'rule' => function ($value, $context) {
                    if (isset($context['data']['senha'])) {
                        return $value === $context['data']['senha'];
                    }
                    return true; // Permite vazio se não houver senha (update)
                },
                'message' => 'As senhas não coincidem.'
            ])
            ->allowEmptyString('confirmar_senha');

        return $validator;
    }

    /**
     * Regras de integridade da aplicação
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), [
            'errorField' => 'email', 
            'message' => 'Este e-mail já está cadastrado.'
        ]);

        return $rules;
    }

    /**
     * BeforeSave callback - para hash da senha
     */
    public function beforeSave($event, $entity, $options)
    {
        // Se a senha foi modificada, faz o hash
        if ($entity->isDirty('senha') && !empty($entity->senha)) {
            $entity->senha_hash = password_hash($entity->senha, PASSWORD_DEFAULT);
        }

        // Define valores padrão se não foram informados
        if ($entity->isNew() && empty($entity->status)) {
            $entity->status = 'ativo';
        }

        if ($entity->isNew() && empty($entity->nivel_ingles)) {
            $entity->nivel_ingles = 'iniciante';
        }

        if ($entity->isNew() && empty($entity->idioma_preferido)) {
            $entity->idioma_preferido = 'pt-BR';
        }
    }
}