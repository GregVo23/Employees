<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vacancy Entity
 *
 * @property int $vac_no
 * @property string $dept_no
 * @property int $title_no
 * @property int $quantity
 *
 * @property \App\Model\Entity\Title $title
 * @property \App\Model\Entity\Department $department
 */
class Vacancy extends Entity
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
        'dept_no' => true,
        'title_no' => true,
        'quantity' => true,
    ];
}
