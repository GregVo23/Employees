<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function register()
    {
        $user = $this->Users->newEmptyEntity();
        
        if ($this->request->is('post')) {
            
            $employee = $this->loadModel('employees');   
            $email = $employee->findByEmail($this->request->getData('email'))->first();
            if($email)
            {
                $empNo = $email->emp_no;
                $form = $this->request->getData();
                $form['emp_no'] = $empNo;
                $user = $this->Users->patchEntity($user, $form);
                //dd($user);
                if ($this->Users->save($user))
                {
                    $this->Flash->success(__('Vous avez été enregistrer, bienvenue !'));
                    return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
                }
                $this->Flash->error(__('Un problème est survenu lors de l\'enregistrement.'));
            }else{
                $this->Flash->error(__('Votre email n\'est pas correct.'));
            }
        }
        $this->set(compact('user'));
    }
    
    // in src/Controller/UsersController.php
    public function login()
    {
        $result = $this->Authentication->getResult();
        // If the user is logged in send them away.
        if ($result->isValid())
        {
            //Ecrire dans la session le status du user connecté
            $status = $this->loadModel('Employees')->get($this->Authentication->getIdentity()->get('emp_no'), ['contain' => ['titles']]);
            if(!empty($status->titles[0]->title)){
                $_SESSION['status'] = $status->titles[0]->title;
            }
            //Redirection vers la page admin si administrateur
            $target = $this->Authentication->getLoginRedirect() ?? '/';
            $target_admin = $this->Authentication->getLoginRedirect() ?? '/admin';
            
            if(!empty($_SESSION['status'])){
                $_SESSION['status'] === 'Admin';
                return $this->redirect($target_admin);
            }else{
               return $this->redirect($target);
            }
                   
        }
        if ($this->request->is('post') && !$result->isValid())
        {
            $this->Flash->error('Username ou password incorrect !');
        }
    }
    
    // in src/Controller/UsersController.php
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['register','login','indexWomen']);
        $this->Authorization->skipAuthorization();
    }
    
    // in src/Controller/UsersController.php
    public function logout()
    {
        $this->Authentication->logout();
        unset($_SESSION['status']);
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
}
