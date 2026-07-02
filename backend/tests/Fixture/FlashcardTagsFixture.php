<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class FlashcardTagsFixture extends TestFixture
{
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'flashcard_id' => 1,
                'tag_id' => 1,
                'criado_em' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'flashcard_id' => 1,
                'tag_id' => 2,
                'criado_em' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'flashcard_id' => 2,
                'tag_id' => 1,
                'criado_em' => date('Y-m-d H:i:s'),
            ],
        ];
        parent::init();
    }
}