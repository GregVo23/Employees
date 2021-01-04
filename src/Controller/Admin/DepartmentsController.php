<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Departments Controller
 *
 * @property \App\Model\Table\DepartmentsTable $Departments
 * @method \App\Model\Entity\Department[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DepartmentsController extends AppController
{
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
     * @param string|null $id Department id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {   
        $department = $this->Departments->get($id, [
            'contain' => ['Managers', 'Vacancies'],
        ]);
        
        //Partie manager(picture + name + hire date):
        $managers =$department->managers;
       // dd($managers);
        $department->manager = $managers[0]->picture;
        $department->first_n = $managers[0]->first_name;
        $department->last_n = $managers[0]->last_name;
        $department->hire = $managers[0]->hire_date;
        
        
        //Nombre d'employees par département:
        $result = $this->Departments->find('count', ['id' => $id])->first()->count;

        //Récupérer les RULES de la BDD             
        $rules = $department->rules;
        
         //Récupérer la description de la BDD
        $description = $department->description;
        
        //Nombre de postes vacants pour chaque département
       $vacancies = $this->getTableLocator()->get('Vacancies');
     
        //dd($vacancies);
   
        $query = $vacancies->find();
        $query->select(['quantity' => $query -> func()->sum('quantity'), 'deptNo' => 'dept_no'])
                ->where(['dept_no' => $department->dept_no]);
               // ->group('dept_no');
     
       //$nbVacancies = $query->all();
       $department->vacancie = $query->first()->quantity;
       //dd($nbVacancies);
     /*   
        foreach($nbVacancies as $nbVacancie):
          $department->vacancie = $nbVacancie->quantity;
            
        endforeach;
     */
      
        //Moyenne des salaires par départments
        $managerQuery = $this->getTableLocator()->get('dept_manager')->find()
            ->select(['dept_manager.emp_no'])
            ->where(['dept_manager.dept_no' => $id])
            ->where(['dept_manager.to_date ' => '9999-01-01']);
               
        $query = $this->getTableLocator()->get('salaries')->find()
            ->select(['avg' => $query->func()->avg('salary')])
            ->join([
            'dept_emp' => [
                'table' => 'dept_emp',
                'conditions' => 'salaries.emp_no = dept_emp.emp_no'
            ]
            ])
            ->where(['dept_emp.dept_no' => $id])
            ->where(['dept_emp.emp_no NOT IN' => $managerQuery]);
        
        $avgSalary = $query->first()->avg;
       // dd($avgSalary);
          //Autorisations : 
        $this->Authorization->authorize($department);
        
        //$this->set(compact('department'));
        $this->set(compact('department', 'result', 'rules', 'description', 'avgSalary'));
 
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->Authorization->skipAuthorization();

        $department = $this->Departments->newEmptyEntity();
        if ($this->request->is('post')) {
            $department = $this->Departments->patchEntity($department, $this->request->getData());
            if ($this->Departments->save($department)) {
                $this->Flash->success(__('The department has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The department could not be saved. Please, try again.'));
        }
        $employees = $this->Departments->Employees->find('list', ['limit' => 200]);
        $managers = $this->Departments->Managers->find('list', ['limit' => 200]);
        $this->set(compact('department', 'employees', 'managers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Department id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->Authorization->skipAuthorization();
        
        //Récupérer l'id du département
        $department = $this->Departments->get($id, [
            'contain' => ['Employees', 'Managers'],
        ]);
        //dd($department);
                  
        if ($this->request->is(['patch', 'post', 'put'])) {
            $departmentInfo = $this->Departments->patchEntity($department, $this->request->getData());
           
            //Récupérer l'id de l'employée
            $emp_no = $this->request->getData('employee');
            //dd($emp_no);
            
            if ($this->Departments->save($departmentInfo)) {
                $this->Flash->success(__('The department has been saved.'));
                
       
                $employee = $this->Departments->Employees->get($emp_no, [
                    'contain' => []
                ]);
                dd($employee);
               //Lier les employées à leur dép
               $this->Departments->Employees->link($department,[$employee]);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The department could not be saved. Please, try again.'));
        }
       //$employees = $this->Departments->Employees->find('list',['limit' => 200]);  
        
        //Récupération de la liste des departements
        
            /*$employees = $this->loadModel('Employees')
             ->find('list', ['keyfield' => 'id', 'valueField' => 'last_name', 'limit' => 10])->all();
              dd($employees);*/

         $query = $this->getTableLocator()->get('employees')->find();  
         $query->select(['name' => $query->func()->concat(['last_name' => 'identifier', ' ', 'first_name' => 'identifier'])])
            ->join([
            'dept_emp' => [
                'table' => 'dept_emp',
                'conditions' => 'dept_emp.emp_no = employees.emp_no', 
            ]
            ])
            ->where(['dept_emp.dept_no' => $id])->limit(15);
         //Conversion de l'objet itérable en tableau   
         $employees = $query->toArray();
        //dd($employees);
       
         $employeeNameSelect = [];
         foreach($employees as $employeeName):
            $employeeNameSelect[] = $employeeName->name;
         endforeach;
        // dd($employeeNameSelect);

         $managers = $this->Departments->Managers->find('list', ['limit' => 200]);

         $this->set(compact('managers', 'department','employeeNameSelect'));     
 
    }

    /**
     * Delete method
     *
     * @param string|null $id Department id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $department = $this->Departments->get($id);
        if ($this->Departments->delete($department)) {
            $this->Flash->success(__('The department has been deleted.'));
        } else {
            $this->Flash->error(__('The department could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
