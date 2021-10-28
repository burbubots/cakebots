<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tradecoin Entity
 *
 * @property int $id
 * @property string $coin
 * @property string|null $address
 * @property string|null $symbol
 * @property string|null $geckoname
 * @property float $valorusd
 * @property float $inc1h
 * @property float $inc24h
 * @property float $inc7d
 * @property float $inc14d
 * @property float $inc30d
 * @property float $inc60d
 * @property float $max_supply
 * @property float $total_supply
 * @property float $circulating_supply
 * @property float $market_cap
 * @property string|null $small_image
 * @property int $getticker
 *
 * @property \App\Model\Entity\Tradeasociado[] $tradeasociados
 */
class Tradecoin extends Entity
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
        'coin' => true,
        'address' => true,
        'symbol' => true,
        'geckoname' => true,
        'valorusd' => true,
        'inc1h' => true,
        'inc24h' => true,
        'inc7d' => true,
        'inc14d' => true,
        'inc30d' => true,
        'inc60d' => true,
        'max_supply' => true,
        'total_supply' => true,
        'circulating_supply' => true,
        'market_cap' => true,
        'small_image' => true,
        'getticker' => true,
        'tradeasociados' => true,
    ];
}
