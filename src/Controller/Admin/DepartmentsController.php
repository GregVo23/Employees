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
          $managerId = $department->managers[0]->emp_no;
        // dd($managersId);
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
              
        $employees = $query->all();
       //dd($employees);
       
        $employeeNameSelect = [];
        //$idEmp = [];
         foreach($employees as $employeeName):
              $employeeNameSelect[] = $employeeName->last_name;
           //$idEmp[] = $employeeName->empNo;       
         endforeach;       
         $departmentCurrentName =  $department->dept_name;
         $departmentDeptNo =  $department->dept_no;
         
         
        if ($this->request->is(['patch', 'post', 'put'])) {
            $departmentInfo = $this->Departments->patchEntity($department, $this->request->getData());
            
          //Pour nommer l'employée sélectionné manager
           //Récupérer les infos du formulaire (input de type select), ici on récupère le last_name de l'employée selectionné
          if($_POST['employee'] !== ''){
            $nameEmp = $employeeNameSelect[$this->request->getData('employee')];
           //dd($nameEmp);
          
           //Trouver les emp_no des employées du département (de l'employée sélectionné)
           $queryEmp = $this->getTableLocator()->get('employees')->find();  
           $queryEmp->select(['empNo' => 'employees.emp_no'])
            
                 ->where(['last_name like' => '%'.$nameEmp.'%'])->limit(1);
  
           $emp_no = $queryEmp->first()->empNo;
           //dd($emp_no);   
           
           //Assigner le titre de manager à l'employée sélectionné
                //Récupérer emp_title_no de l'employée sélectionné pour pouvoir changer sa to_date à aujourd'hui (mettre fin à sa fonction actuelle)
           $queryTitle = $this->getTableLocator()->get('employees')->find();  
           $queryTitle->select(['titleEmp'=>'employee_title.emp_title_no'])
                 ->join([
                'employee_title' => [
                'table' => 'employee_title',
                'conditions' => 'employee_title.emp_no = employees.emp_no',
            ]
            ])
            ->where(['employee_title.emp_no' => $emp_no]);
           $employeeTitleNow = $queryTitle->first()->titleEmp;
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
           
               //Ajout des données dans la nouvelle entitée dans la table employee_title
            $employeeNewFunction = $this->Departments->Employees->employee_title->newEmptyEntity();
            $employeeNewFunction->set('emp_no', $emp_no);
            $employeeNewFunction->set('to_date', $to_date);
            $employeeNewFunction->set('from_date', $today);
            $employeeNewFunction->set('emp_title_no', $last_emp_title_no);
            $employeeNewFunction->set('title_no', '3');
            
            
            
           $manDeptModel = $this->LoadModel('dept_manager');

           $managerRevok = $manDeptModel 
                          ->find()
                          ->where(['emp_no' => $managerId])
                          ->where(['to_date' => '9999-01-01'])
                          ->first();

           $managerRevok->set('to_date', $today);
           
           
           //Création de la nouvelle entité dans dept_manager pour le nouveau manager (sélectionné parmi les employées du department)
           $managerModel = $this->LoadModel('dept_manager');
           $newManager = $managerModel->newEmptyEntity();
           $newManager->set('emp_no',$emp_no);
           $newManager->set('dept_no',$departmentDeptNo);
           $newManager->set('from_date',$today);
           $newManager->set('to_date',$to_date);

           
           //Mettre fin au salaire du manager actuel lorsque l'on en désigne un nouveau 
            //Modifier la date to_date du manager qui sera remplacé
           
           $managerModel = $this->LoadModel('salaries');

           $managerSalary = $managerModel 
                          ->find()
                          ->where(['emp_no' => $managerId])
                          ->where(['to_date' => '9999-01-01'])
                          ->first();

           $managerSalary->set('to_date', $today);
           


           
           
           
           
           
        }
          
          if($departmentCurrentName != $_POST['dept_name']){
                if ($this->Departments->save($departmentInfo)) {
                    $this->Flash->success(__('Le nom du départment a été sauvé.'));
                    //dd($departmentInfo);

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
           }
           
           if($_POST['employee'] !== ''){
                if($this->Departments->Employees->employee_title->save($employeeTitleInfo)){
                   $this->Flash->success(__('L\'employée sélectionné à cessé sa fonction actuelle.'));
                     //dd($_POST['employee']);

                    if($manDeptModel->save($managerRevok)){
                         $this->Flash->success(__('Le manager actuelle a été révoqué (fin de sa fonction).'));
                                if($this->Departments->Employees->dept_manager->save($newManager)){
                                    $this->Flash->success(__('Création de la nouvelle entité dans la table dept_manager pour l\'employée devenu manager.'));
                                        if($managerModel->save($managerSalary)){
                                            $this->Flash->error(__('Le salaire du manager a cessé !'));

                                        } else {
                                             $this->Flash->error(__('Un problème est survenu lors de la mise en arrêt du salaire!'));
                                        }
                                }else{
                                   $this->Flash->error(__('Problème lors de la création de l\'entité dans la table dept_manager !'));
                                }   
                     } else {
                         $this->Flash->error(__('Le manager actuelle n\'a pas été révoqué ! Veuillez réessayer !'));
                     }

                     if($this->Departments->Employees->employee_title->save($employeeNewFunction)){
                        $this->Flash->error(__('L\'employée n\' a pu devenir manager. Un problème est survenu !'));

                        return $this->redirect(['action' => 'index']);
                        
                     } else { 
                        $this->Flash->error(__('L\'employée n\' a pu devenir manager. Un problème est survenu !'));
                     } 
                } else {
                    $this->Flash->error(__('L\'employée n\' a pas cesser sa fonction actuelle. Un problème est survenu !'));
                }
           }
           
        }
     
         
         $managers = $this->Departments->Managers->find('list', ['limit' => 200]);

      $this->set(compact('managers', 'department','employeeNameSelect','managersFirstName','managersLastName'));     
 
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
