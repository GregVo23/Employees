<?php
declare(strict_types=1);

namespace App\Controller;
use \DateTime;

/**
 * Departments Controller
 *
 * @property \App\Model\Table\DepartmentsTable $Departments
 * @method \App\Model\Entity\Department[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DepartmentsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['index', 'view']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {   
        $this->Authorization->skipAuthorization();

        $departments = $this->paginate($this->Departments);

        $this->set(compact('departments'));

    }

    /**
     * View method
     *
     * @param int|null $id Department id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();
       
        $showRoi=false;
        $showManager = false;

        if($this->Authentication->getResult()->isValid()){
            $showManager = true;

            $emp = $this->Authentication->getIdentity()->get('emp_no');
            $employees = $this->getTableLocator()->get('Employees')->
                 get($emp, [
                'contain' => ['departments'],
            ]); 
            $dept_no = $employees->departments[0]->dept_no;
            
            $showRoi = $dept_no === $id; 
        }

        $department = $this->Departments->get($id, [
            'contain' => ['Managers', 'Vacancies'],
        ]);

        $managers =$department->managers;
        $department->manager = $managers[0]->picture;
        
        $result = $this->Departments->find('count', ['id' => $id])->first()->count;
        
        //Récupérer les RULES de la BDD
        $rules = $department->rules;
        
        //Récupérer la description de la BDD
        $description = $department->description;
        
        //Nombre de postes vacants pour chaque département
         $vacancies = $this->getTableLocator()->get('Vacancies');
   
        $query = $vacancies->find();
        $query->select(['quantity' => $query -> func()->sum('quantity'), 'deptNo' => 'dept_no'])
                ->where(['dept_no' => $department->dept_no])
                ->group('dept_no');
        
        $nbVacancies = $query->all();

        foreach($nbVacancies as $nbVacancie):
            $department->vacancie = $nbVacancie->quantity;
        endforeach;
          
        //Envoyer à la vue
        $this->set(compact('department', 'result', 'rules', 'description', 'showRoi', 'showManager'));
    }
}
