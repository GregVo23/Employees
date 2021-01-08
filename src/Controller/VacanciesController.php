<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Vacancies Controller
 *
 * @property \App\Model\Table\VacanciesTable $Vacancies
 * @method \App\Model\Entity\Vacancy[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VacanciesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['index']);
        $this->Authorization->skipAuthorization();
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $vacancies = $this->paginate($this->Vacancies, [
            'contain' => ['Titles', 'Departments'],
        ]);

        $this->set(compact('vacancies'));
    }

}
