<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Usuarios Model
 *
 * @property \App\Model\Table\ProgressoUsuarioTable&\Cake\ORM\Association\HasOne $ProgressoUsuario
 * @property \App\Model\Table\FlashcardsTable&\Cake\ORM\Association\HasMany $Flashcards
 * @property \App\Model\Table\PreferenciasUsuarioTable&\Cake\ORM\Association\HasMany $PreferenciasUsuario
 * @property \App\Model\Table\PromptsTable&\Cake\ORM\Association\HasMany $Prompts
 * @property \App\Model\Table\QuizesTable&\Cake\ORM\Association\HasMany $Quizes
 * @property \App\Model\Table\TentativasQuizTable&\Cake\ORM\Association\HasMany $TentativasQuiz
 * @property \App\Model\Table\VocabularioTable&\Cake\ORM\Association\HasMany $Vocabulario
 *
 * @method \App\Model\Entity\Usuario newEmptyEntity()
 * @method \App\Model\Entity\Usuario newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Usuario> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Usuario get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Usuario findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Usuario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Usuario> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Usuario|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Usuario saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Usuario>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Usuario>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Usuario>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Usuario> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Usuario>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Usuario>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Usuario>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Usuario> deleteManyOrFail(iterable $entities, array $options = [])
 */
class UsuariosTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('usuarios');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');

        $this->hasOne('ProgressoUsuario', [
            'foreignKey' => 'usuario_id',
        ]);
        $this->hasMany('Flashcards', [
            'foreignKey' => 'usuario_id',
        ]);
        $this->hasMany('PreferenciasUsuario', [
            'foreignKey' => 'usuario_id',
        ]);
        $this->hasMany('Prompts', [
            'foreignKey' => 'usuario_id',
        ]);
        $this->hasMany('Quizes', [
            'foreignKey' => 'usuario_id',
        ]);
        $this->hasMany('TentativasQuiz', [
            'foreignKey' => 'usuario_id',
        ]);
        $this->hasMany('Vocabulario', [
            'foreignKey' => 'usuario_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('nome')
            ->maxLength('nome', 100)
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('senha_hash')
            ->maxLength('senha_hash', 255)
            ->requirePresence('senha_hash', 'create')
            ->notEmptyString('senha_hash');

        $validator
            ->scalar('telefone')
            ->maxLength('telefone', 20)
            ->allowEmptyString('telefone');

        $validator
            ->scalar('foto_perfil')
            ->maxLength('foto_perfil', 255)
            ->allowEmptyString('foto_perfil');

        $validator
            ->scalar('nivel_ingles')
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
            ->allowEmptyString('status');

        $validator
            ->dateTime('criado_em')
            ->allowEmptyDateTime('criado_em');

        $validator
            ->dateTime('atualizado_em')
            ->allowEmptyDateTime('atualizado_em');

        $validator
            ->dateTime('ultimo_login')
            ->allowEmptyDateTime('ultimo_login');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

        return $rules;
    }
}
