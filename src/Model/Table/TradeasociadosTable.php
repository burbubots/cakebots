<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class TradeasociadosTable extends Table
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

        $this->setTable('tradeasociados');
        $this->setDisplayField('tradecoin_id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tradecoins', [
            'foreignKey' => 'tradecoin_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Tradeaccounts', [
            'foreignKey' => 'tradeaccount_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Tradedelegates', [
            'foreignKey' => 'tradeasociado_id',
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
            ->scalar('associatedAccount')
            ->maxLength('associatedAccount', 200)
            ->requirePresence('associatedAccount', 'create')
            ->notEmptyString('associatedAccount')
            ->add('associatedAccount', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->numeric('balance')
            ->notEmptyString('balance');

        $validator
            ->numeric('acumusd')
            ->notEmptyString('acumusd');

        $validator
            ->scalar('delegate')
            ->allowEmptyString('delegate');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['associatedAccount']), ['errorField' => 'associatedAccount']);
        $rules->add($rules->existsIn('tradecoin_id', 'Tradecoins'), ['errorField' => 'tradecoin_id']);
        $rules->add($rules->existsIn('tradeaccount_id', 'Tradeaccounts'), ['errorField' => 'tradeaccount_id']);

        return $rules;
    }
}
