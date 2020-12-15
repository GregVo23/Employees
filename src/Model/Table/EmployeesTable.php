<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Behavior\InitialisableBehavior;

/**
 * Employees Model
 *
 * @method \App\Model\Entity\Employee newEmptyEntity()
 * @method \App\Model\Entity\Employee newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Employee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Employee get($primaryKey, $options = [])
 * @method \App\Model\Entity\Employee findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Employee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Employee[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Employee|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employee saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employee[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Employee[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Employee[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Employee[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class EmployeesTable extends Table
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
        
        $this->addBehavior('Initialisable');    //Permet de générer les initiales

        $this->setTable('employees');
        $this->setDisplayField('emp_no');
        $this->setPrimaryKey('emp_no');
        
        $this->hasMany('salaries', [
            'foreignKey' => 'emp_no',
            'targetForeignKey' => 'emp_no',
        ]);

        $this->hasMany('employeeTitle', [
            
            'foreignKey' => 'emp_no',
           
        ]);

        $this->belongsToMany('titles', [
            'joinTable' => 'employee_title',
            'targetForeignKey' => 'title_no',
            'foreignKey' => 'emp_no',
            'bindingKey' => 'emp_no',
        ]);
        
        $this->belongsToMany('departments',[
            'joinTable' => 'dept_emp',
            'targetForeignKey' => 'dept_no',
            'foreignKey' => 'emp_no',
            'bindingKey' => 'emp_no',
        ]);

        $this->belongsToMany('managers',[
            'classname' => 'departments',
            'joinTable' => 'dept_manager',
            'targetForeignKey' => 'dept_no',
            'foreignKey' => 'emp_no',
            'bindingKey' => 'emp_no',
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
            ->integer('emp_no')
            ->allowEmptyString('emp_no', null, 'create');

        $validator
            ->date('birth_date')
            ->requirePresence('birth_date', 'create')
            ->notEmptyDate('birth_date');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 14)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 16)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator
            ->scalar('gender')
            ->requirePresence('gender', 'create')
            ->notEmptyString('gender')
            ->add('gender', 'validValue',[
                'rule' => ['inlist',['F','M']],
                'message' => 'This value must be either F or M',
            ]);

        $validator
            ->date('hire_date')
            ->requirePresence('hire_date', 'create')
            ->notEmptyDate('hire_date');

        return $validator;
    }
    /**
     * Fonction qui renvoit le nombre de femmes par année
     * @param Query $query
     * @param array $options
     * @return type
     */
    function findWomenHire() {
        //Déclaration des tableaux pour le graphique myLineChart
        $nbHire = [];
        $years = [];

        $query = $this->findByGender('F');
        //$query->select(['hire_date','nbWomen' => $query->func()->count('employees.emp_no')])->group('year(employees.hire_date)');
        
        $query->select(['hire_date' => 'salaries.to_date','nbWomen' => $query->func()->count('employees.emp_no')])->innerJoinWith('salaries')->group('year(salaries.to_date)');
        
        $result = $query->all();

        foreach($result as $employee):
            if(!in_array($employee->hire_date->format('Y'),$years)):
                $years[] = $employee->hire_date->format('Y');
                $nbHire[] = $employee->nbWomen;
            endif;
        endforeach;
        
        return ['years' => $years,'nbHire' =>$nbHire];
    }
    
    /**
     * Fonction qui renvoit le nombre de femmes mannager
     * @param Query $query
     * @param array $options
     * @return type
     */
    function findWomenManager() {}
    
}
