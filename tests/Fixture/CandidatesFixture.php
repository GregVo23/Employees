<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CandidatesFixture
 */
class CandidatesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'cand_no' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'first_name' => ['type' => 'string', 'length' => 14, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'last_name' => ['type' => 'string', 'length' => 16, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'birth_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'email' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'resume' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'vac_no' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['cand_no'], 'length' => []],
            'unique_key_vacancy_email' => ['type' => 'unique', 'columns' => ['vac_no', 'email'], 'length' => []],
            'fk_vac_no' => ['type' => 'foreign', 'columns' => ['vac_no'], 'references' => ['vacancies', 'vac_no'], 'update' => 'restrict', 'delete' => 'cascade', 'length' => []],
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
                'cand_no' => 1,
                'first_name' => 'Lorem ipsum ',
                'last_name' => 'Lorem ipsum do',
                'birth_date' => '2020-12-15',
                'email' => 'Lorem ipsum dolor sit amet',
                'resume' => 'Lorem ipsum dolor sit amet',
                'vac_no' => 1,
            ],
        ];
        parent::init();
    }
}
