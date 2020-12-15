<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Candidate Entity
 *
 * @property int $cand_no
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $resume
 *
 * @property \App\Model\Entity\Vacancy[] $vacancies
 */
class Candidate extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'first_name' => true,
        'last_name' => true,
        'birth_date' => true,
        'email' => true,
        'resume' => true,
        'vac_no' => true,
        'vacancies' => true,
    ];
}
