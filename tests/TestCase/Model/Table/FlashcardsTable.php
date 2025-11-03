<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FlashcardsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('flashcards');
        $this->setDisplayField('id'); // Mude para 'question' ou outro campo relevante se preferir
        $this->setPrimaryKey('id');

        // Associações
        $this->hasMany('FlashcardTags', [
            'foreignKey' => 'flashcard_id',
        ]);

        $this->belongsToMany('Tags', [
            'foreignKey' => 'flashcard_id',
            'targetForeignKey' => 'tag_id',
            'through' => 'FlashcardTags',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        // Adicione validações para campos reais da tabela, ex:
        // $validator
        //     ->scalar('question')
        //     ->maxLength('question', 255)
        //     ->requirePresence('question', 'create')
        //     ->notEmptyString('question');

        // $validator
        //     ->scalar('answer')
        //     ->maxLength('answer', 255)
        //     ->requirePresence('answer', 'create')
        //     ->notEmptyString('answer');

        return $validator;
    }
}