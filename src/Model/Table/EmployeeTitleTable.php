<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmployeeTitle Model
 *
 * @method \App\Model\Entity\EmployeeTitle newEmptyEntity()
 * @method \App\Model\Entity\EmployeeTitle newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeTitle[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeTitle get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmployeeTitle findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\EmployeeTitle patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeTitle[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeTitle|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeTitle saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeTitle[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmployeeTitle[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmployeeTitle[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\EmployeeTitle[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class EmployeeTitleTable extends Table
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

        $this->setTable('employee_title');
        $this->setDisplayField('emp_title_no');
        $this->setPrimaryKey('emp_title_no');
        
        $this->hasOne('employees', [
            'foreignKey' => 'emp_no',
            'targetForeignKey' => 'emp_no'
        ]);
        $this->hasMany('departments', [
            'foreignKey' => 'emp_no',
            'targetForeignKey' => 'emp_no'
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
            ->integer('emp_title_no')
            ->allowEmptyString('emp_title_no', null, 'create');

        $validator
            ->integer('emp_no')
            ->requirePresence('emp_no', 'create')
            ->notEmptyString('emp_no');

        $validator
            ->integer('title_no')
            ->requirePresence('title_no', 'create')
            ->notEmptyString('title_no');

        $validator
            ->date('from_date')
            ->requirePresence('from_date', 'create')
            ->notEmptyDate('from_date');

        $validator
            ->date('to_date')
            ->allowEmptyDate('to_date');

        return $validator;
    }
    
    
        /**
        * Fonction qui renvoit Les 3 départements présentant le plus de femmes
        * @param Query $query
        * @param array $options
        * @return array
        * req SQL = SELECT departments.dept_name, COUNT(employees.emp_no)FROM dept_emp,employees,departments WHERE dept_emp.dept_no = departments.dept_no AND dept_emp.emp_no = employees.emp_no AND employees.gender = 'F' GROUP BY departments.dept_no ORDER BY COUNT(employees.emp_no) desc LIMIT 3
        */

    
       public function findMannager($id = null){
       $query = $this->findByTitle_no('3');   
       $query->innerJoinWith('employees')
       ->innerJoinWith('departments')
        ->where(['departments.dept_no =' => 'id']);
       $result = $query->toArray();
       return $result;
       }
}
