<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DeptManagerTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DeptManagerTable Test Case
 */
class DeptManagerTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DeptManagerTable
     */
    protected $DeptManager;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.DeptManager',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DeptManager') ? [] : ['className' => DeptManagerTable::class];
        $this->DeptManager = $this->getTableLocator()->get('DeptManager', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DeptManager);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
