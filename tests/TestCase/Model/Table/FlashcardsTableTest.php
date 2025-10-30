<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FlashcardsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FlashcardsTable Test Case
 */
class FlashcardsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FlashcardsTable
     */
    protected $Flashcards;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Flashcards',
        'app.Usuarios',
        'app.Prompts',
        'app.ImagemFrentes',
        'app.ImagemVersos',
        'app.FlashcardTags',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Flashcards') ? [] : ['className' => FlashcardsTable::class];
        $this->Flashcards = $this->getTableLocator()->get('Flashcards', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Flashcards);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\FlashcardsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\FlashcardsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
