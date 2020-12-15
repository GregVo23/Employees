<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CandidatesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CandidatesTable Test Case
 */
class CandidatesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CandidatesTable
     */
    protected $Candidates;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Candidates',
        'app.Vacancies',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Candidates') ? [] : ['className' => CandidatesTable::class];
        $this->Candidates = $this->getTableLocator()->get('Candidates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Candidates);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
