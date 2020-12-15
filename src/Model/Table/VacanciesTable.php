<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Vacancies Model
 *
 * @method \App\Model\Entity\Vacancy newEmptyEntity()
 * @method \App\Model\Entity\Vacancy newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Vacancy[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Vacancy get($primaryKey, $options = [])
 * @method \App\Model\Entity\Vacancy findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Vacancy patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Vacancy[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Vacancy|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Vacancy saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Vacancy[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Vacancy[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Vacancy[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Vacancy[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class VacanciesTable extends Table
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

        $this->setTable('vacancies');
        $this->setDisplayField('vac_no');
        $this->setPrimaryKey('vac_no');

        $this->hasOne('Titles', [
            'foreignKey' => 'title_no',
            'bindingKey' => 'title_no'
        ]);
        $this->hasOne('Departments', [
            'foreignKey' => 'dept_no',
            'bindingKey' => 'dept_no'
        ]);

        $this->belongsToMany('Candidates',[
            'joinTable' => 'vac_cand',
            'targetForeignKey' => 'cand_no',
            'foreignKey' => 'vac_no',
            'bindingKey' => 'vac_no',
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
            ->integer('vac_no')
            ->allowEmptyString('vac_no', null, 'create');

        $validator
            ->scalar('dept_no')
            ->maxLength('dept_no', 4)
            ->requirePresence('dept_no', 'create')
            ->notEmptyString('dept_no');

        $validator
            ->integer('title_no')
            ->requirePresence('title_no', 'create')
            ->notEmptyString('title_no');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity');

        return $validator;
    }
}
