<?php
declare(strict_types=1);

namespace App\Controller\Admin;
use Cake\I18n\FrozenTime;
use App\Controller\AppController;

/**
 * Demands Controller
 *
 * @property \App\Model\Table\DemandsTable $Demands
 * @method \App\Model\Entity\Demand[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DemandsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        $this->Authorization->skipAuthorization();
        parent::beforeFilter($event);
    }
    /**
     * Index method
     * @var $raises raises demands.
     * @var $incomers demands from people outside our department and want to come in.
     * @var $leaving demands from people inside our department and want to leave for another one.
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $raises = $incomers = $leaving = [];

        $this->loadModel('Employees');
        
        $user=$this->Authentication->getIdentity();
        $user = $this->Employees->get($user->get('emp_no'), [
            'contain' => ['departments']
        ]);
        $userDept = $user->departments[0]->dept_no;
        $demands = $this->Demands->find()->toArray();

        foreach($demands as $demand){

            if($demand->status === 'pending'){

                if($demand->type === 'Raise'){
                    
                    $demandEmployee = $this->Employees->get($demand->emp_no, ['contain' => ['departments', 'titles']]);
                    if($_SESSION['status'] === 'Admin'
                        || ($_SESSION['status'] === 'Accountant' && $demand->validated_once)
                        || ($_SESSION['status'] === 'Manager' && $userDept === $demandEmployee->departments[0]->dept_no && !$demand->validated_once)){

                        $demandEmployeeSalary = $this->Employees->get($demand->emp_no, ['contain' => ['salaries']])->salaries[0]->salary;
                        $demand->about = $demand->about;
                        $demand->currentSalary = $demandEmployeeSalary;
                        $demand->employee = $demandEmployee->first_name . ' ' . $demandEmployee->last_name;
                        $demand->employeeDepartment = $demandEmployee->departments[0]->dept_name;
                        $demand->employeeTitle = $demandEmployee->titles[0]->title;

                        $raises[] = $demand;
                    }
                }
                else {
                    $demandEmployee = $this->Employees->get($demand->emp_no, ['contain' => ['departments', 'titles']]);
                    $demandDept = $this->Employees->departments->get($demand->about);
                    $demand->employee = $demandEmployee->first_name . ' ' . $demandEmployee->last_name;
                    $demand->employeeTitle = $demandEmployee->titles[0]->title;

                    if($demand->about === $userDept && $demand->validated_once){
                        $demand->employeeDepartment = $demandEmployee->departments[0]->dept_name;
                        $incomers[] = $demand;
                    }else{
                        $demand->department = $demandDept->dept_name;
                        $demandEmployeeDept = $demandEmployee->departments[0]->dept_no;
                        if(($userDept===$demandEmployeeDept && !$demand->validated_once) || $_SESSION['status'] === 'Admin'){
                            $leaving[] = $demand;
                        }
                    }
                }
            }
        }
        $this->set(compact('incomers', 'raises', 'leaving'));
    }

    /**
     * View method
     *
     * @param string|null $id Demand id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $demand = $this->Demands->get($id, [
            'contain' => [],
        ]);
        $this->set(compact('demand'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function validate($id)
    {
        $demand = $this->Demands->get($id, [
            'contain' => [],
        ]);
        $this->loadModel('Salaries');
        $this->loadModel('Employees');
        
            $this->Authorization->skipAuthorization();
            if ($this->request->is(['patch', 'post', 'put'])) {
                $modifiedDemand = $this->Demands->findByDemandNo($id)->first()->toArray();
                if($_SESSION['status']==='Accountant'){
                    $modifiedDemand['status']='validated';
                    $emp = $this->Employees->get($modifiedDemand['emp_no'], [
                        'contain'=>['salariesToday']
                    ]);
                    $emp->salaries_today[0]->to_date=new FrozenTime();
                    $salary = $emp->salaries_today[0];
                }
                else if ($_SESSION['status']==='Manager'){
                    if($demand->validated_once){
                        $modifiedDemand['status']='validated';
                    }
                    else{
                        $modifiedDemand['validated_once'] = 1;
                    }
                }
                else if($_SESSION['status']==='Admin'){
                    $modifiedDemand['status']='validated';
                }
                $demand = $this->Demands->patchEntity($demand, $modifiedDemand);
                if ($this->Demands->save($demand)) {
                    $this->Flash->success(__('The demand has been saved.'));
                    if($modifiedDemand['status']==='validated'){
                        if($modifiedDemand['type']==='Raise'){
                            $newSalary = $this->Salaries->newEmptyEntity();
                            $newSalary->set('emp_no', $modifiedDemand['emp_no']);
                            $newSalary->set('salary', $modifiedDemand['about']);
                            $newSalary->set('from_date', new FrozenTime());
                            $newSalary->set('to_date', new FrozenTime('9999-01-01'));
                            if($this->Salaries->save($salary) && $this->Salaries->save($newSalary)){
                                $this->Flash->success(__('The salary has been updated.'));
                            }
                        }else{
                            //reaffectation
                        }
                    }
    
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The demand could not be saved. Please, try again.'));
            }
            $this->set(compact('demand'));
        
            return $this->redirect(['action' => 'index']);

       
        // $demand = $this->Demands->newEmptyEntity();
        // if ($this->request->is('post')) {
        //     $demand = $this->Demands->patchEntity($demand, $this->request->getData());
        //     if ($this->Demands->save($demand)) {
        //         $this->Flash->success(__('The demand has been saved.'));

        //         return $this->redirect(['action' => 'index']);
        //     }
        //     $this->Flash->error(__('The demand could not be saved. Please, try again.'));
        // }
        // $this->set(compact('demand'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Demand id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $demand = $this->Demands->get($id, [
            'contain' => [],
        ]);
        try{
            $this->Authorization->authorize($demand);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $demand = $this->Demands->patchEntity($demand, $this->request->getData());
                if ($this->Demands->save($demand)) {
                    $this->Flash->success(__('The demand has been saved.'));
    
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The demand could not be saved. Please, try again.'));
            }
            $this->set(compact('demand'));
        }catch(\Exception $e){
            $this->Flash->error(__($e->getResult()->getReason()));
            return $this->redirect(['action' => 'index']);
        };
       
    }

    /**
     * Cancel method
     *
     * @param string|null $id Demand id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function cancel($id = null)
    {
        $demand =$this->Demands->get($id);
        $this->Authorization->authorize($demand);
        $modifiedDemand = $this->Demands->findByDemandNo($id)->first()->toArray();
        $modifiedDemand['status']='cancelled';
        $adminRoles= ['Accountant', 'Admin', 'Manager'];

        if ($this->request->is(['patch', 'post', 'put'])) {
            $demand = $this->Demands->patchEntity($demand, $modifiedDemand);
            if ($this->Demands->save($demand)) {
                $this->Flash->success(__('La demande a été annulée.'));
                return $this->redirect(['action' => 'index']);
                
            }
            $this->Flash->error(__('The demand could not be cancelled. Please, try again.'));
        }
        $this->set(compact('demand'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Demand id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $demand = $this->Demands->get($id);
        if ($this->Demands->delete($demand)) {
            $this->Flash->success(__('The demand has been deleted.'));
        } else {
            $this->Flash->error(__('The demand could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
