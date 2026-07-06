<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FlashcardsTable;
use Cake\TestSuite\TestCase;

class FlashcardsTableTest extends TestCase
{
    protected FlashcardsTable $Flashcards;

    protected array $fixtures = [
        'app.Flashcards',
        'app.Users',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->Flashcards = $this->getTableLocator()->get('Flashcards');
    }

    protected function tearDown(): void
    {
        unset($this->Flashcards);
        parent::tearDown();
    }

    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}