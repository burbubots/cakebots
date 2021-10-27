<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tradeaccount Entity
 *
 * @property int $id
 * @property string $account
 * @property string $cuenta
 * @property string $net
 * @property string|null $notas
 *
 * @property \App\Model\Entity\Tradeasociado[] $tradeasociados
 * @property \App\Model\Entity\Tradetransaction[] $tradetransactions
 */
class Tradeaccount extends Entity
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
        'account' => true,
        'cuenta' => true,
        'net' => true,
        'notas' => true,
        'tradeasociados' => true,
        'tradetransactions' => true,
    ];
}
