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
        
        //Partie manager(nom + picture):
        $managers =$department->managers;
        $department->manager = $managers[0]->picture;
        
        
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
                ->where(['dept_no' => $department->dept_no])
                ->group('dept_no');
     
       $nbVacancies = $query->all();
       //dd($nbVacancies);
        
        foreach($nbVacancies as $nbVacancie):
          $department->vacancie = $nbVacancie->quantity;
            
        endforeach;
            //dd($department->vacancie);
      
               
          //Autorisations : 
        $this->Authorization->authorize($department);
        
        //$this->set(compact('department'));
        $this->set(compact('department', 'result', 'rules', 'description'));
 
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
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
        $department = $this->Departments->get($id, [
            'contain' => ['Employees', 'Managers'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
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
