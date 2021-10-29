<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class TradedelegatesTable extends Table
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

        $this->setTable('tradedelegates');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tradeaccounts', [
            'foreignKey' => 'tradeaccount_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Tradeasociados', [
            'foreignKey' => 'tradeasociado_id',
            'joinType' => 'INNER',
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
            ->scalar('delegate')
            ->maxLength('delegate', 100)
            ->requirePresence('delegate', 'create')
            ->notEmptyString('delegate');

        $validator
            ->numeric('cantidad')
            ->notEmptyString('cantidad');

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
        $rules->add($rules->existsIn('tradeaccount_id', 'Tradeaccounts'), ['errorField' => 'tradeaccount_id']);
        $rules->add($rules->existsIn('tradeasociado_id', 'Tradeasociados'), ['errorField' => 'tradeasociado_id']);

        return $rules;
    }
}
