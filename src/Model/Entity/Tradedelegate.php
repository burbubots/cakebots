<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tradedelegate Entity
 *
 * @property int $id
 * @property string $delegate
 * @property int $tradeaccount_id
 * @property int $tradeasociado_id
 * @property float $cantidad
 *
 * @property \App\Model\Entity\Tradeaccount $tradeaccount
 * @property \App\Model\Entity\Tradeasociado $tradeasociado
 */
class Tradedelegate extends Entity
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
        'delegate' => true,
        'tradeaccount_id' => true,
        'tradeasociado_id' => true,
        'cantidad' => true,
        'tradeaccount' => true,
        'tradeasociado' => true,
    ];
}
