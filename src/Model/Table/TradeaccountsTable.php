<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class TradeaccountsTable extends Table
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

        $this->setTable('tradeaccounts');
        $this->setDisplayField('cuenta');
        $this->setPrimaryKey('id');

        $this->hasMany('Tradeasociados', [
            'foreignKey' => 'tradeaccount_id',
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
            ->scalar('account')
            ->maxLength('account', 200)
            ->requirePresence('account', 'create')
            ->notEmptyString('account');

        $validator
            ->scalar('cuenta')
            ->maxLength('cuenta', 80)
            ->notEmptyString('cuenta');

        $validator
            ->scalar('net')
            ->maxLength('net', 20)
            ->notEmptyString('net');

        $validator
            ->scalar('notas')
            ->allowEmptyString('notas');

        return $validator;
    }
}
