<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class TradecoinsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('tradecoins');
        $this->setDisplayField('coin');
        $this->setPrimaryKey('id');

//        $this->hasMany('Tradeasociados', [
        $this->hasOne('Tradeasociados', [
            'foreignKey' => 'tradecoin_id',
        ]);
        
        
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('coin')
            ->maxLength('coin', 100)
            ->requirePresence('coin', 'create')
            ->notEmptyString('coin');

        $validator
            ->scalar('address')
            ->maxLength('address', 200)
            ->allowEmptyString('address');

        $validator
            ->scalar('symbol')
            ->maxLength('symbol', 100)
            ->allowEmptyString('symbol');

        $validator
            ->scalar('geckoname')
            ->maxLength('geckoname', 100)
            ->allowEmptyString('geckoname');

        $validator
            ->numeric('valorusd')
            ->notEmptyString('valorusd');

        $validator
            ->numeric('balance')
            ->notEmptyString('balance');

        $validator
            ->numeric('acumusd')
            ->notEmptyString('acumusd');

        $validator
            ->numeric('inc1h')
            ->notEmptyString('inc1h');

        $validator
            ->numeric('inc24h')
            ->notEmptyString('inc24h');

        $validator
            ->numeric('inc7d')
            ->notEmptyString('inc7d');

        $validator
            ->numeric('inc14d')
            ->notEmptyString('inc14d');

        $validator
            ->numeric('inc30d')
            ->notEmptyString('inc30d');

        $validator
            ->numeric('inc60d')
            ->notEmptyString('inc60d');

        $validator
            ->numeric('max_supply')
            ->notEmptyString('max_supply');

        $validator
            ->numeric('total_supply')
            ->notEmptyString('total_supply');

        $validator
            ->numeric('circulating_supply')
            ->notEmptyString('circulating_supply');

        $validator
            ->numeric('market_cap')
            ->notEmptyString('market_cap');

        $validator
            ->scalar('small_image')
            ->maxLength('small_image', 255)
            ->allowEmptyFile('small_image');

        $validator
            ->notEmptyString('getticker');

        return $validator;
    }
}
