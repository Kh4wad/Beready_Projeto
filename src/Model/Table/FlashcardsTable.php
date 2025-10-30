<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Flashcards Model
 *
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsTo $Usuarios
 * @property \App\Model\Table\PromptsTable&\Cake\ORM\Association\BelongsTo $Prompts
 * @property \App\Model\Table\ImagensGeradasTable&\Cake\ORM\Association\BelongsTo $ImagemFrentes
 * @property \App\Model\Table\ImagensGeradasTable&\Cake\ORM\Association\BelongsTo $ImagemVersos
 * @property \App\Model\Table\FlashcardTagsTable&\Cake\ORM\Association\HasMany $FlashcardTags
 *
 * @method \App\Model\Entity\Flashcard newEmptyEntity()
 * @method \App\Model\Entity\Flashcard newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Flashcard> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Flashcard get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Flashcard findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Flashcard patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Flashcard> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Flashcard|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Flashcard saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Flashcard>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Flashcard>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Flashcard>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Flashcard> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Flashcard>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Flashcard>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Flashcard>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Flashcard> deleteManyOrFail(iterable $entities, array $options = [])
 */
class FlashcardsTable extends Table
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

        $this->setTable('flashcards');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Prompts', [
            'foreignKey' => 'prompt_id',
        ]);
        $this->belongsTo('ImagemFrentes', [
            'foreignKey' => 'imagem_frente_id',
            'className' => 'ImagensGeradas',
        ]);
        $this->belongsTo('ImagemVersos', [
            'foreignKey' => 'imagem_verso_id',
            'className' => 'ImagensGeradas',
        ]);
        $this->hasMany('FlashcardTags', [
            'foreignKey' => 'flashcard_id',
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
            ->integer('usuario_id')
            ->notEmptyString('usuario_id');

        $validator
            ->integer('prompt_id')
            ->allowEmptyString('prompt_id');

        $validator
            ->scalar('texto_frente')
            ->allowEmptyString('texto_frente');

        $validator
            ->scalar('texto_verso')
            ->allowEmptyString('texto_verso');

        $validator
            ->integer('imagem_frente_id')
            ->allowEmptyString('imagem_frente_id');

        $validator
            ->integer('imagem_verso_id')
            ->allowEmptyString('imagem_verso_id');

        $validator
            ->scalar('audio_frente_url')
            ->maxLength('audio_frente_url', 500)
            ->allowEmptyString('audio_frente_url');

        $validator
            ->scalar('audio_verso_url')
            ->maxLength('audio_verso_url', 500)
            ->allowEmptyString('audio_verso_url');

        $validator
            ->scalar('nivel_dificuldade')
            ->allowEmptyString('nivel_dificuldade');

        $validator
            ->scalar('tipo_criacao')
            ->allowEmptyString('tipo_criacao');

        $validator
            ->integer('vezes_revisado')
            ->allowEmptyString('vezes_revisado');

        $validator
            ->integer('vezes_acertado')
            ->allowEmptyString('vezes_acertado');

        $validator
            ->dateTime('ultima_revisao')
            ->allowEmptyDateTime('ultima_revisao');

        $validator
            ->dateTime('proxima_revisao')
            ->allowEmptyDateTime('proxima_revisao');

        $validator
            ->boolean('arquivado')
            ->allowEmptyString('arquivado');

        $validator
            ->dateTime('criado_em')
            ->allowEmptyDateTime('criado_em');

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
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'), ['errorField' => 'usuario_id']);
        $rules->add($rules->existsIn(['prompt_id'], 'Prompts'), ['errorField' => 'prompt_id']);
        $rules->add($rules->existsIn(['imagem_frente_id'], 'ImagemFrentes'), ['errorField' => 'imagem_frente_id']);
        $rules->add($rules->existsIn(['imagem_verso_id'], 'ImagemVersos'), ['errorField' => 'imagem_verso_id']);

        return $rules;
    }
}
