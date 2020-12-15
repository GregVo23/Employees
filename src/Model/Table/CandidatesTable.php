<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Candidates Model
 *
 * @method \App\Model\Entity\Candidate newEmptyEntity()
 * @method \App\Model\Entity\Candidate newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Candidate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Candidate get($primaryKey, $options = [])
 * @method \App\Model\Entity\Candidate findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Candidate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Candidate[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Candidate|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Candidate saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Candidate[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Candidate[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Candidate[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Candidate[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CandidatesTable extends Table
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

        $this->setTable('candidates');
        $this->setDisplayField('cand_no');
        $this->setPrimaryKey('cand_no');

        $this->belongsToMany('Vacancies',[
            'joinTable' => 'vac_cand',
            'targetForeignKey' => 'vac_no',
            'foreignKey' => 'cand_no',
            'bindingKey' => 'cand_no',
        ]);

        $this->hasMany('VacCand',[
            'targetForeignKey' => 'vac_no',
            'foreignKey' => 'cand_no',
            'bindingKey' => 'cand_no',
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
            ->integer('cand_no')
            ->allowEmptyString('cand_no', null, 'create');

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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('resume')
            ->maxLength('resume', 100)
            ->requirePresence('resume', 'create')
            ->notEmptyString('resume');

        $validator
            ->date('birth_date')
            ->requirePresence('birth_date', 'create')
            ->notEmptyDate('birth_date');

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
        $rules->add($rules->isUnique(['email', 'vac_no']), 'This email has already been used for this vacancy');
        return $rules;
    }
}
