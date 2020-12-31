<?php
declare(strict_types=1);

namespace App\Controller;

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
        parent::beforeFilter($event);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $pendings=[];
        $passed=[];
        $this->Authorization->skipAuthorization();
        $emp = $this->Authentication->getIdentity()->get('emp_no');
        $employee = $this->getTableLocator()->get('Employees')->
        get($emp, [
            'contain' => ['demands'],
            ]); 
        $demands = $employee->demands;
        $this->loadModel('Departments');
        foreach($demands as $demand){
            if($demand->type==="Reassignment"){
                $demand->about=$this->Departments->findByDeptNo($demand->about)->first()->dept_name;
            }else{
                $demand->about=$demand->about. ' €';
            }
            if($demand->status==="pending"){
                $pendings[]=$demand;
            }else {
                $passed[]=$demand;
            }
        }
        $this->set(compact('pendings', 'passed'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->Authorization->skipAuthorization();
    }

    /**
     * AddRaise method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addRaise()
    {
        $this->Authorization->skipAuthorization();
        $demand = $this->Demands->newEmptyEntity();
        if ($this->request->is('post')) {
            $error='';
            if(!preg_match('/^[1-9]\d+([,.]\d{1,2})?$/',$this->request->getData('about'))){
                $error='Veuillez entrez un montant valide.';
            }else{
                $demand = $this->Demands->patchEntity($demand, $this->request->getData());
                $demand->set('emp_no', $this->Authentication->getIdentity()->get('emp_no'));
                $demand->set('type', 'Raise');
                if ($this->Demands->save($demand)) {
                    $this->Flash->success(__('The demand has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }else {
                    $error='The demand could not be saved. Please, try again.';
                }
            }
            $this->Flash->error(__($error));
        }
        $this->set(compact('demand'));
    }

    /**
     * Add reassignment method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addReassignment()
    {
        $this->Authorization->skipAuthorization();
        $demand = $this->Demands->newEmptyEntity();
        $departments = $this->loadModel('Departments')->find('list', ['keyfield' => 'id', 'valueField' => 'dept_name']);
        if ($this->request->is('post')) {
            $error='';
            $this->loadModel('Departments');
            $dept = $this->Departments->findByDeptName($this->request->getData('department'))->first();
            if(!$dept){
                $error='Veuillez entrer un département valide.';
            }else{
                $demand->set('type', 'reassignment');
                $demand->set('about', $this->request->getData('department'));
                $demand->set('emp_no', $this->Authentication->getIdentity()->get('emp_no'));
                if ($this->Demands->save($demand)) {
                    $this->Flash->success(__('The demand has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }else {
                $error='The demand could not be saved. Please, try again.';
                }
            }
            $this->Flash->error(__($error));
        }
        $this->set(compact('demand', 'departments'));
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

        if ($this->request->is(['patch', 'post', 'put'])) {
            $demand = $this->Demands->patchEntity($demand, $modifiedDemand);
            if ($this->Demands->save($demand)) {
                $this->Flash->success(__('The demand has been cancelled.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The demand could not be cancelled. Please, try again.'));
        }
        $this->set(compact('demand'));
    }
}
