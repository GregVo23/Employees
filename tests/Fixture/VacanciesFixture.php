<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * VacanciesFixture
 */
class VacanciesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'vac_no' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'dept_no' => ['type' => 'string', 'length' => 4, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'title_no' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'quantity' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'foreign_key_title' => ['type' => 'index', 'columns' => ['title_no'], 'length' => []],
            'dept_no' => ['type' => 'index', 'columns' => ['dept_no'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['vac_no'], 'length' => []],
            'foreign_key_title' => ['type' => 'foreign', 'columns' => ['title_no'], 'references' => ['titles', 'title_no'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'foreign_key_department' => ['type' => 'foreign', 'columns' => ['dept_no'], 'references' => ['departments', 'dept_no'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'vac_no' => 1,
                'dept_no' => 'Lo',
                'title_no' => 1,
                'quantity' => 1,
            ],
        ];
        parent::init();
    }
}
