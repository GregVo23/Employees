<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Demands Model
 *
 * @method \App\Model\Entity\Demand newEmptyEntity()
 * @method \App\Model\Entity\Demand newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Demand[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Demand get($primaryKey, $options = [])
 * @method \App\Model\Entity\Demand findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Demand patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Demand[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Demand|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Demand saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Demand[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Demand[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Demand[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Demand[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DemandsTable extends Table
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

        $this->setTable('demands');
        $this->setDisplayField('demand_no');
        $this->setPrimaryKey('demand_no');
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
            ->integer('demand_no')
            ->allowEmptyString('demand_no', null, 'create');

        $validator
            ->integer('emp_no')
            ->requirePresence('emp_no', 'create')
            ->notEmptyString('emp_no');

        $validator
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('about')
            ->maxLength('about', 10)
            ->requirePresence('about', 'create')
            ->notEmptyString('about');

        $validator
            ->boolean('validated_once')
            ->notEmptyString('validated_once');

        $validator
            ->scalar('status')
            ->notEmptyString('status');

        return $validator;
    }
}
