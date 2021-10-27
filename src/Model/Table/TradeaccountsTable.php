<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tradeaccounts Model
 *
 * @property \App\Model\Table\TradeasociadosTable&\Cake\ORM\Association\HasMany $Tradeasociados
 * @property \App\Model\Table\TradetransactionsTable&\Cake\ORM\Association\HasMany $Tradetransactions
 *
 * @method \App\Model\Entity\Tradeaccount newEmptyEntity()
 * @method \App\Model\Entity\Tradeaccount newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Tradeaccount[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tradeaccount get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tradeaccount findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Tradeaccount patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tradeaccount[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tradeaccount|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tradeaccount saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tradeaccount[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Tradeaccount[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Tradeaccount[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Tradeaccount[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
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
        $this->hasMany('Tradetransactions', [
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
