<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmployeeTitle Entity
 *
 * @property int $emp_title_no
 * @property int $emp_no
 * @property int $title_no
 * @property \Cake\I18n\FrozenDate $from_date
 * @property \Cake\I18n\FrozenDate|null $to_date
 */
class EmployeeTitle extends Entity
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
        'emp_no' => true,
        'title_no' => true,
        'from_date' => true,
        'to_date' => true,
    ];
}
