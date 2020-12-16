<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DeptEmpTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DeptEmpTable Test Case
 */
class DeptEmpTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DeptEmpTable
     */
    protected $DeptEmp;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.DeptEmp',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DeptEmp') ? [] : ['className' => DeptEmpTable::class];
        $this->DeptEmp = $this->getTableLocator()->get('DeptEmp', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DeptEmp);

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
