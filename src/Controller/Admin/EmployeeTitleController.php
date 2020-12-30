<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

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
        //ATTENTION retirer cet authorisation
        $this->Authorization->skipAuthorization();
        
        //Nommer le nouveau manager
        
        $emp_title_no = $this->EmployeeTitle->find()->where(['emp_no =' => $id])->first();
        $emp_title_no = $emp_title_no->emp_title_no;
        
        $employee = $this->EmployeeTitle->newEmptyEntity();
        $employeeNow = $this->EmployeeTitle->get($emp_title_no, [
            'contain' => [],
        ]);
        
        $titreManager = [
            'title_no' => '3',];
        
        $employee = $this->EmployeeTitle->patchEntity($employeeNow, $titreManager);            
        
        //Suppression de l'ancien manager

        $oldManager = $this->EmployeeTitle->find()->where(['title_no =' => '3'])->where(['to_date =' => '9999-01-01'])->first();
        $emp_title_no = $oldManager->emp_title_no;
        
        $employee = $this->EmployeeTitle->newEmptyEntity();
        $employeeNow = $this->EmployeeTitle->get($emp_title_no, [
            'contain' => [],
        ]);
        
        $titreManager = [
            'to_date' => date()->format("Y-m-d"),];
        
        $noLonger = $this->EmployeeTitle->patchEntity($employeeNow, $titreManager);  
        
        //Messages de retour 
        
        if ($this->EmployeeTitle->save($employee)) {
            $this->Flash->success(__('L\'employé est maintenant manager de son département.'));
        } else {
            $this->Flash->error(__('Une erreur est survenue.'));
        }
        
        if ($this->EmployeeTitle->save($noLonger)) {
            $this->Flash->success(__('L\'ancien manager n\a plus de poste chez Nestlé.'));
        } else {
            $this->Flash->error(__('Une erreur est survenue, l\'ancien manager est toujours en place.'));
        }

        return $this->redirect(['controller' => 'employees', 'action' => 'index']);
    }
}
