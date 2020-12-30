<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Departments Model
 *
 * @method \App\Model\Entity\Department newEmptyEntity()
 * @method \App\Model\Entity\Department newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Department[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Department get($primaryKey, $options = [])
 * @method \App\Model\Entity\Department findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Department patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Department[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Department|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Department saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Department[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Department[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Department[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Department[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DepartmentsTable extends Table
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

        $this->setTable('departments');
        $this->setDisplayField('dept_no');
        $this->setPrimaryKey('dept_no');

        $this->belongsToMany('Employees',[
            'joinTable' => 'dept_emp',
            'targetForeignKey' => 'emp_no',
            'foreignKey' => 'dept_no',
            'bindingKey' => 'dept_no',
        ]);

        $this->belongsToMany('Managers',[
            'className' => 'Employees',
            'joinTable' => 'dept_manager',
            'targetForeignKey' => 'emp_no',
            'foreignKey' => 'dept_no',
            'bindingKey' => 'dept_no',
            'conditions' => ['DeptManager.to_date' => '9999-01-01']
        ]);
         
          $this->hasMany('Vacancies', [
            'foreignKey' => 'dept_no',
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
            ->scalar('dept_no')
            ->maxLength('dept_no', 4)
            ->allowEmptyString('dept_no', null, 'create');

        $validator
            ->scalar('dept_name')
            ->maxLength('dept_name', 40)
            ->requirePresence('dept_name', 'create')
            ->notEmptyString('dept_name')
            ->add('dept_name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['dept_name']), ['errorField' => 'dept_name']);

        return $rules;
    }

    public function findCount(Query $query, array $options)
    {   
        //dd($query);
        $query->select([
            'Employees.emp_no',
            'count' => $query->func()->count('*')]);
        $query->innerJoinWith('Employees')
        ->where(['departments.dept_no =' => $options['id']]);
        
       return $query;
    }
    
   /*     public function findAvg(Query $query, array $options)
    {
        $query->select(['salary' => $query->func()->avg('salaries.salary'), 'deptNo' => 'dept_emp.dept_no']);
        $query->innerJoinWith('salaries, employee_title, dept_emp, employees')
      //  ->where(['departments.dept_no =' => $options['id']]);
        ->where(['dept_emp.to_date =' => '9999-01-01', 'employee_title.title_no !=' => '3', 'dept_emp.dept_no =' => $options['id']])
        ->group('dept_emp.dept_no');
        return $query;
    }*/
}
