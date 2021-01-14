<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\I18n\FrozenTime;

/**
 * EmployeeTitle Controller
 *
 * @property \App\Model\Table\EmployeeTitleTable $EmployeeTitle
 * @method \App\Model\Entity\EmployeeTitle[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeeTitleController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $employeeTitle = $this->paginate($this->EmployeeTitle);

        $this->set(compact('employeeTitle'));
    }

    /**
     * View method
     *
     * @param string|null $id Employee Title id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employeeTitle = $this->EmployeeTitle->get($id, [
            'contain' => ['employees'],
        ]);

        $this->set(compact('employeeTitle'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employeeTitle = $this->EmployeeTitle->newEmptyEntity();
        if ($this->request->is('post')) {
            $employeeTitle = $this->EmployeeTitle->patchEntity($employeeTitle, $this->request->getData());
            if ($this->EmployeeTitle->save($employeeTitle)) {
                $this->Flash->success(__('The employee title has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee title could not be saved. Please, try again.'));
        }
        $this->set(compact('employeeTitle'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee Title id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employeeTitle = $this->EmployeeTitle->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employeeTitle = $this->EmployeeTitle->patchEntity($employeeTitle, $this->request->getData());
            if ($this->EmployeeTitle->save($employeeTitle)) {
                $this->Flash->success(__('The employee title has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee title could not be saved. Please, try again.'));
        }
        $this->set(compact('employeeTitle'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee Title id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employeeTitle = $this->EmployeeTitle->get($id);
        if ($this->EmployeeTitle->delete($employeeTitle)) {
            $this->Flash->success(__('The employee title has been deleted.'));
        } else {
            $this->Flash->error(__('The employee title could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * newMannager method
     *
     * @param string|null $id Employee Title id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function newMannager($id = null) {

        //$this->Authorization->skipAuthorization();
        
        //Récupérer l'id et l'incrémenter
        $query = $this->EmployeeTitle->find('all', ['order' => ['emp_title_no' => 'DESC']])->limit(1)->first();
        $last_emp_title_no = $query->emp_title_no +1;

        //Variables date du jour + variable date continue
        $today = new FrozenTime(date('Y-m-d'));
        $to_date = new FrozenTime('9999-01-01');

        //Assignation des nouvelles données pour le nouveau poste de manager
        $employee = $this->EmployeeTitle->newEmptyEntity();        
        $employee->set('emp_no', $id);
        $employee->set('to_date', $to_date);
        $employee->set('from_date', $today);
        $employee->set('emp_title_no', $last_emp_title_no);
        $employee->set('title_no', '3');
        
        //Rechercher l'employé
        $emp_title_no = $this->EmployeeTitle->find()->where(['emp_no =' => $id])->first();
        $emp_title_no = $emp_title_no->emp_title_no;
        $titleNow = $this->EmployeeTitle->get($emp_title_no);

        //Definir la date de fin du poste actuel de l'employé a la date d'aujourd'hui.
        $titleNow->set('to_date', $today);

        if ($this->EmployeeTitle->save($titleNow)) {
                $this->Flash->success(__('L\'employé a stoppé sa fonction actuelle.'));
        } else {
            $this->Flash->error(__('Une erreur est survenue.'));
        }
        
        if ($this->EmployeeTitle->save($employee)) {
                $this->Flash->success(__('L\'employé est désormais manager.'));
        } else {
            $this->Flash->error(__('Une erreur est survenue lors de la réception du nouveau titre.'));
        }
                        
        //Rechercher le numéro de departement actuel de l'employé
        $query = $this->getTableLocator()->get('dept_emp')->find();
        $query->select('dept_emp.dept_no')
        ->where(['dept_emp.emp_no =' => $id]);
        $result = $query->toArray();
        $deptNo = $deptNo = $result[0]->dept_no;
        
        //recuperer l' "emp_title_no" du manager du departement de l'employé
        $query = $this->getTableLocator()->get('employees')->find();
        $query->select('employee_title.emp_title_no')
        ->innerJoinWith('employee_title')
        ->innerJoinWith('dept_manager')
        ->where(['dept_manager.dept_no =' => $deptNo, 'employee_title.title_no =' => '3']);
        $result = $query->toArray();
        $emp_title_no_manager = $idManager = $result[0]->_matchingData["employee_title"]->emp_title_no;
        
        //récuperer l' "emp_title_no" du manager du departement du manager
        $manNow = $this->EmployeeTitle->get($emp_title_no_manager);
        
        //Mise a jour -> Definir la date de fin du poste actuel a la date d'aujourd'hui.
        $manNow->set('to_date', $today);
        $empMan = $manNow->emp_no;
        
        //Recherche du dept_no du manager
        $query = $this->getTableLocator()->get('dept_emp')->find();
        $query->select('dept_emp.dept_no')
        ->where(['dept_emp.emp_no =' => $empMan]);
        $result = $query->toArray();
        $deptNoMan = $deptNo = $result[0]->dept_no;

        //Ajout du nouveaux manager dans la table dept_manager
        $DeptManager = $this->loadModel('dept_manager');
        $entDeptManager = $DeptManager->newEmptyEntity();
        $entDeptManager->emp_no = $id;
        $entDeptManager->dept_no = $deptNoMan;
        $entDeptManager->from_date = $today;
        $entDeptManager->to_date = '9999-01-01';
        if ($DeptManager->save($entDeptManager)) {
            $this->Flash->success(__('Le nouveau manager commence sa fonction actuelle.'));
        }else{
            $this->Flash->error(__('Une erreur est survenue.'));            
        }
        
        if ($this->EmployeeTitle->save($manNow)) {
                $employee = $this->EmployeeTitle->employees->get($empMan);
                $department = $this->EmployeeTitle->employees->departments->get($deptNoMan);
                
                $department->_joinData = ['to_date' => '9999-01-01', 'from_date' => $today];
                $this->EmployeeTitle->employees->departments->link($employee,[$department]);
                $this->Flash->success(__('L\'ancien manager a stoppé sa fonction actuelle.'));
        } else {
            $this->Flash->error(__('Une erreur est survenue.'));
        }

        //FIn de l'association departement et de l'ancien manager
        $dept_emp = $this->loadModel('dept_emp');
        $deptEmp = $dept_emp->find()
        ->where(['emp_no' => $manNow->emp_no])
        ->where(['to_date' => '9999-01-01'])
        ->first();
        $deptEmp->set('to_date', $today);
        
        //Fin de versement de salaire ancien mannager.
        $manSalaries = $this->loadModel('salaries');
        
        $salaryMan = $manSalaries
        ->find()
        ->where(['emp_no' => $id])
        ->first();
        $salaryDate = $salaryMan->from_date;
        $salary = $salaryMan->salary;

        $manSalary = [
            'to_date' => $today,
            'from_date' => $salaryDate,
            'salary' => $salary,
            'emp_no' => $id
        ];

        $dataSalary = $manSalaries->patchEntity($salaryMan, $manSalary);

        if ($manSalaries->save($dataSalary)) {
                $this->Flash->success(__('Stop du salaire de l\'ancien manager.'));
        } else {
            $this->Flash->error(__('l\'ancien manager recoit toujours son salaire.'));
        }        
        
        if ($dept_emp->save($deptEmp)) {
                $this->Flash->success(__('Fin d\'association entre l\'ancien manager et son département.'));
        } else {
            $this->Flash->error(__('l\'ancien manager est toujours associé à son département.'));
        }    
        
        return $this->redirect(['controller' => 'employees', 'action' => 'index']);
    }
}
