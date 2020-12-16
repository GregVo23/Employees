<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EmployeeTitleFixture
 */
class EmployeeTitleFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'employee_title';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'emp_title_no' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'emp_no' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'title_no' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'from_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'to_date' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'foreign_key_emp_no' => ['type' => 'index', 'columns' => ['emp_no'], 'length' => []],
            'foreign_key_title_no' => ['type' => 'index', 'columns' => ['title_no'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['emp_title_no'], 'length' => []],
            'foreign_key_title_no' => ['type' => 'foreign', 'columns' => ['title_no'], 'references' => ['titles', 'title_no'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'foreign_key_emp_no' => ['type' => 'foreign', 'columns' => ['emp_no'], 'references' => ['employees', 'emp_no'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'emp_title_no' => 1,
                'emp_no' => 1,
                'title_no' => 1,
                'from_date' => '2020-12-15',
                'to_date' => '2020-12-15',
            ],
        ];
        parent::init();
    }
}
