<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

// phpcs:disable CakePHP.Classes.Import.UseFullyQualifiedName
use App\Model\Table\PreferenciasUsuarioTable;
use Cake\TestSuite\TestCase;

// phpcs:enable CakePHP.Classes.Import.UseFullyQualifiedName

/**
 * App\Model\Table\PreferenciasUsuarioTable Test Case
 */
final class PreferenciasUsuarioTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PreferenciasUsuarioTable
     */
    protected PreferenciasUsuarioTable $PreferenciasUsuario;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Users',
        'app.PreferenciasUsuario',
    ];

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\PreferenciasUsuarioTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\PreferenciasUsuarioTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $config = $this->getTableLocator()->exists('PreferenciasUsuario')
            ? []
            : ['className' => PreferenciasUsuarioTable::class];

        $this->PreferenciasUsuario = $this->getTableLocator()->get('PreferenciasUsuario', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PreferenciasUsuario);

        parent::tearDown();
    }
}
