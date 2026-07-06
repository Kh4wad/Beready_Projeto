<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class FlashcardTagsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = [
        'app.FlashcardTags',  // Nome da classe do fixture (FlashcardTagsFixture)
        'app.Flashcards',     // Nome da classe do fixture (FlashcardsFixture)
        'app.Tags',           // Nome da classe do fixture (TagsFixture)
        'app.Users',          // Nome da classe do fixture (UsersFixture)
    ];

    public function testGetByFlashcard(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}