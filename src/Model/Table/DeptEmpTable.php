<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DeptEmp Model
 *
 * @method \App\Model\Entity\DeptEmp newEmptyEntity()
 * @method \App\Model\Entity\DeptEmp newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\DeptEmp[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DeptEmp get($primaryKey, $options = [])
 * @method \App\Model\Entity\DeptEmp findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\DeptEmp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DeptEmp[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DeptEmp|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DeptEmp saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DeptEmp[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DeptEmp[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\DeptEmp[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\DeptEmp[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DeptEmpTable extends Table
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

        $this->setTable('dept_emp');
        $this->setDisplayField('emp_no');
        $this->setPrimaryKey(['emp_no', 'dept_no']);
                
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
            ->integer('emp_no')
            ->allowEmptyString('emp_no', null, 'create');

        $validator
            ->scalar('dept_no')
            ->maxLength('dept_no', 4)
            ->allowEmptyString('dept_no', null, 'create');

        $validator
            ->date('from_date')
            ->requirePresence('from_date', 'create')
            ->notEmptyDate('from_date');

        $validator
            ->date('to_date')
            ->requirePresence('to_date', 'create')
            ->notEmptyDate('to_date');

        return $validator;
    }
}
