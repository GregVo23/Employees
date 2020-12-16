<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DeptEmp Entity
 *
 * @property int $emp_no
 * @property string $dept_no
 * @property \Cake\I18n\FrozenDate $from_date
 * @property \Cake\I18n\FrozenDate $to_date
 */
class DeptEmp extends Entity
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
        'from_date' => true,
        'to_date' => true,
    ];
}
