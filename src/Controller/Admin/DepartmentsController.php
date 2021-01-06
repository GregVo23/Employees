<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use \DateTime;
use Cake\I18n\FrozenTime;

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
       //dd($department->managers);
     
        //Partie manager(name + hire date):
          $managersFirstName = $department->managers[0]->first_name;
          $managersLastName = $department->managers[0]->last_name;
 
               //Trouver les employees du département
         $query = $this->getTableLocator()->get('employees')->find();  
         $query->select(['empNo' => 'employees.emp_no' ,'last_name'])  //Le emp_no n'est pas vraiment nécessaire ici mais bon...
            ->join([
            'dept_emp' => [
                'table' => 'dept_emp',
                'conditions' => 'dept_emp.emp_no = employees.emp_no',
            ]
            ])
            ->where(['dept_emp.dept_no' => $id])->limit(15)
            ->where(['dept_emp.to_date =' => '9999-01-01']);
            
         //Conversion de l'objet itérable en tableau   
        $employees = $query->all();
       //dd($employees);
       
        $employeeNameSelect = [];
        //$idEmp = [];
         foreach($employees as $employeeName):
              $employeeNameSelect[] = $employeeName->last_name;
           //$idEmp[] = $employeeName->empNo;       
         endforeach;
         
        if ($this->request->is(['patch', 'post', 'put'])) {
            $departmentInfo = $this->Departments->patchEntity($department, $this->request->getData());
          
           //Récupérer les infos du formulaire (input de type select), ici on récupère le last_name de l'employée selectionné
           $nameEmp = $employeeNameSelect[$this->request->getData('employee')];
           //dd($nameEmp);

           //Trouver les emp_no des employées du département (de l'employée sélectionné)
           $query = $this->getTableLocator()->get('employees')->find();  
           $query->select(['empNo' => 'employees.emp_no'])
            
                 ->where(['last_name like' => '%'.$nameEmp.'%'])->limit(1);
  
           $emp_no = $query->first()->empNo;
           //dd($emp_no);   
           
           //Assigner le titre de manager à l'employée sélectionné
                //Récupérer emp_title_no de l'employée sélectionné pour pouvoir changer sa to_date à aujourd'hui (mettre fin à sa fonction actuelle)
           $query = $this->getTableLocator()->get('employees')->find();  
           $query->select(['titleEmp'=>'employee_title.emp_title_no'])
                 ->join([
                'employee_title' => [
                'table' => 'employee_title',
                'conditions' => 'employee_title.emp_no = employees.emp_no',
            ]
            ])
            ->where(['employee_title.emp_no' => $emp_no]);
           $employeeTitleNow = $query->first()->titleEmp;
           //dd($employeeTitleNow);
           
           $employeeTitleInfo = $this->Departments->Employees->employee_title->get($employeeTitleNow, [
                    'contain' => []
                    ]);
           //dd($employeeTitleInfo);
           $employeeTitleInfo->to_date = new FrozenTime();
           
               //Créer une nouvelle entitée(une nouvelle ligne dans la table employee_title)
                    //récupérer le dernier emp_title_no pour pouvoir l'incrémenter de 1
               $query = $this->getTableLocator()->get('employees')->find();  
               $query->select(['titleEmp'=>'employee_title.emp_title_no'])
                 ->join([
                'employee_title' => [
                'table' => 'employee_title',
                'conditions' => 'employee_title.emp_no = employees.emp_no',
            ]
            ])
            ->order(['titleEmp' => 'DESC'])
            ->limit(1);
               
            $queryEmpTitle = $query->first();
            //dd($queryEmpTitle->titleEmp);
            $last_emp_title_no = $queryEmpTitle->titleEmp +1;
           //dd($last_emp_title_no);
            $today = new FrozenTime();
            $to_date = new FrozenTime('9999-01-01');
           
               //Ajout des données dans la nouvelle entitée
            $employeeNewFunction = $this->Departments->Employees->employee_title->newEmptyEntity();
            $employeeNewFunction->set('emp_no', $emp_no);
            $employeeNewFunction->set('to_date', $to_date);
            $employeeNewFunction->set('from_date', $today);
            $employeeNewFunction->set('emp_title_no', $last_emp_title_no);
            $employeeNewFunction->set('title_no', '3');
            
            
            //Révoquer le manager actuel
           $managerId = $department->managers[0]->emp_no;
            //dd($managerId);
            ///Changer la to_date du manager actuelle------------------------
       /*    $managerInfo = $department->managers[0]->get($managerId, [  -->$managerId => est un int et pas une chaine de caractère donc get ne fct pas !
                    'contain' => []
                    ]);
           //dd($managerInfo);
           $managerRevok->to_date = new FrozenTime();  */
           
           /*$managerInfo = $this->LoadModel('dept_manager')->find()->select(['to_date'])->where(['emp_no' =>$managerId]);
           dd($managerInfo->first()->to_date);*/
           //TODO//
           $deptManager = $this->LoadModel('Managers');
          
           $newManager = $deptManager->newEmptyEntity();
           $newManager->set('from_date', $today);
           //dd($endManager);
           
           
            if ($this->Departments->save($departmentInfo)) {
                $this->Flash->success(__('Le nom du départment a été sauvé.'));
                
             
                //$employeeTitleInfo->to_date = new FrozenTime();
                //dd($employeeTitleInfo->to_date);
                
                $employee = $this->Departments->Employees->get($emp_no, [
                    'contain' => []
                ]);
                //dd($employee);
                
               //Lier les employées à leur départment
               $this->Departments->Employees->link($department,[$employee]);

                //return $this->redirect(['action' => 'index']);
            } else {
              $this->Flash->error(__('Le nom du départment n\'a pas pu être sauvé. Veuillez réessayer svp !'));
            }
            if($this->Departments->Employees->employee_title->save($employeeTitleInfo)){
                $this->Flash->success(__('L\'employée sélectionné à cessé sa fonction actuelle.'));
                
              
            } else {
               $this->Flash->error(__('L\'employée n\' a pas cesser sa fonction actuelle. Un problème est survenu !'));
            }
         /*   if($this->Departments->Employees->  ->save($employeeTitleInfo)){
                
            } else {
                  $this->Flash->error(__('Le manager actuelle n\'a pas été révoqué ! Veuillez réessayer !'));
            }*/
            if($this->Departments->Employees->employee_title->save($employeeNewFunction)){
                 $this->Flash->success(__('L\'employée est devenu manager de son départment.'));

                 return $this->redirect(['action' => 'index']);
            } else { 
                $this->Flash->error(__('L\'employée n\' a pu devenir manager. Un problème est survenu !'));

            }
        }
     
         
         $managers = $this->Departments->Managers->find('list', ['limit' => 200]);

      $this->set(compact('managers', 'department','employeeNameSelect','managersFirstName','managersLastName'));     
        //$this->set(compact('managers', 'department','managersFirstName','managersLastName', 'employees'));     
 
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
