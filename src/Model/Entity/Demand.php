<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Demand Entity
 *
 * @property int $demand_no
 * @property int $emp_no
 * @property string $type
 * @property string $about
 * @property bool $validated_once
 * @property string $status
 *
 * @property \App\Model\Entity\Employee $employee
 */
class Demand extends Entity
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
        'type' => true,
        'about' => true,
        'validated_once' => true,
        'status' => true,
        'employee' => true,
    ];
}
