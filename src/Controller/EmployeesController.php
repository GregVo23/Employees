<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\View\CellTrait;
use \DateTime;

/**
 * Employees Controller
 *
 * @property \App\Model\Table\EmployeesTable $Employees
 * @method \App\Model\Entity\Employee[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeesController extends AppController
{
    use CellTrait;
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        //Récupérer les données de la base de données
        $employees = $this->Employees;
       
        //Préparer, modifier ces données
        $employees = $this->paginate($employees);
        
        //Il faut l'enlever par la suite car aucun user ne doit avoir l'autorisation de voir la liste des employées et tout ce qui s'y rapporte sauf l'admin
       $this->Authorization->skipAuthorization();

        //Envoyer vers la vue
        $this->set('employees',$employees);
    }

    /**
     * View method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => ['salaries','titles'],
        ]);
        $titles =$employee->titles;
        $today = new DateTime();
        foreach($titles as $title) {
            $date = new DateTime($title['_joinData']->to_date->format('Y-m-d'));
            
            if($date > $today) {
                $employee->function = $title->title;
                break;
            }
        }
       
        //$this->Authorization->skipAuthorization();

        $this->set(compact('employee'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        //Récupérer => Créer
        $employee = $this->Employees->newEmptyEntity();
        
        $employee->password = hash($pass);
        //Traitement
        //Rien faire en GET
        //Persister en POST
        if ($this->request->is('post')) {
            $employee = $this->Employees->patchEntity($employee, $this->request->getData());
            if ($this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        
        //Envoyer vers la vue
        $this->set(compact('employee'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employee = $this->Employees->patchEntity($employee, $this->request->getData());
            if ($this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        $this->set(compact('employee'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        //Sécurité
        $this->request->allowMethod(['post', 'delete']);
        
        //Récupérer
        $employee = $this->Employees->get($id);
        
        //Traitement
        if ($this->Employees->delete($employee)) {
            $this->Flash->success(__('The employee has been deleted.'));
        } else {
            $this->Flash->error(__('The employee could not be deleted. Please, try again.'));
        }

        //Envoyer vers la vue: NON => Redirection
        return $this->redirect(['action' => 'index']);
    }
    
    public function getAllByGender(string $gender = 'f')
    {
        $this->Authorization->skipAuthorization();

        //Récupérer les données
        $employees = $this->Employees->findByGender($gender)->limit(10);
        
        //Transformer
        $employees = $this->paginate($employees);
        
        //Envoyer à la vue
        $this->set('employees',$employees);
        $this->render('index'); //Définit un template spécifique
    }

    
    //----------------------|*| WOMEN AT WORK PAGE VIEW |*|------------------------//

    /**
     * indexWomen method
     * @version 1.0
     */    
    public function indexWomen()
    {
        $this->Authorization->skipAuthorization();
        //Récupérer les données de la base de données
        $employees = $this->Employees;
        
        //Préparation des Cells
        $cellMenWomenRatio = $this->cell('Inbox');
       
        //Préparer, modifier ces données
        $employees = $this->paginate($employees);
        $women = $this->Employees->findByGender('F')->count();
        $men = $this->Employees->findByGender('M')->count();
        
        $result = $this->Employees->findWomenHire();
        foreach($result['years'] as $year):
            $yearWomen[] = $year;
        endforeach;
        foreach($result['nbHire'] as $nbHire):
            $nbHireWomen[] = $nbHire;
        endforeach;

        //$result = $this->Employees->findLessWomenDep();
        //foreach($result as $depLess):
        //    $depNameLessWomen[] = $depLess->depName;
        //    $nbDepLessWomen[] = $depLess->nbWomenDep;
        //endforeach;

        $result = $this->Employees->findMoreWomenDep();
        foreach($result as $depMore):
            $depNameMoreWomen[] = $depMore->depName;
            $nbDepMoreWomen[] = $depMore->nbWomenDep;
        endforeach;

        $nbWomenManager = $this->Employees->findWomenManager();
        $nbMenManager = $this->Employees->findMenManager();
        
        //Envoyer vers la vue
        $this->set('employee',$employees);
        $this->set('nbWomen',$women);
        $this->set('nbMen',$men);
        $this->set('cellMenWomenRatio',$cellMenWomenRatio);
        $this->set('yearWomen',$yearWomen);
        $this->set('nbHireWomen',$nbHireWomen);
        $this->set('nbWomenManager',$nbWomenManager);
        $this->set('nbMenManager',$nbMenManager);
        //$this->set('depNameLessWomen',$depNameLessWomen);
        //$this->set('nbDepLessWomen',$nbDepLessWomen);
        $this->set('depNameMoreWomen',$depNameMoreWomen);
        $this->set('nbDepMoreWomen',$nbDepMoreWomen);
        
        //Envoyer vers la vue spécifié
        $this->render('/women_at_work/indexWomen');
    }
    
    //---------myriam avg test

    public function departments(){
        $this->Authorization->skipAuthorization();
        $test = $this->Employees->findAvg();
    }


}
