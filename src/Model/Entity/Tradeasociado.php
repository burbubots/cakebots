<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tradeasociado Entity
 *
 * @property int $id
 * @property int $tradecoin_id
 * @property int $tradeaccount_id
 * @property string $associatedAccount
 * @property float $balance
 * @property float $acumusd
 *
 * @property \App\Model\Entity\Tradecoin $tradecoin
 * @property \App\Model\Entity\Tradeaccount $tradeaccount
 */
class Tradeasociado extends Entity
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
        'tradecoin_id' => true,
        'tradeaccount_id' => true,
        'associatedAccount' => true,
        'balance' => true,
        'acumusd' => true,
        'tradecoin' => true,
        'tradeaccount' => true,
    ];
}
