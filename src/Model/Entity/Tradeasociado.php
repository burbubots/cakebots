<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tradeasociado Entity
 *
 * @property int $id
 * @property int $tradeaccount_id
 * @property string $associatedAccount
 * @property int $tradecoin_id
 *
 * @property \App\Model\Entity\Tradeaccount $tradeaccount
 * @property \App\Model\Entity\Tradecoin $tradecoin
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
        'tradeaccount_id' => true,
        'associatedAccount' => true,
        'tradecoin_id' => true,
        'tradeaccount' => true,
        'tradecoin' => true,
    ];
}
