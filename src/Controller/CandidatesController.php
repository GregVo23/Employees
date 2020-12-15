<?php

namespace App\Controller;
use Cake\Mailer\Email;
use Cake\Mailer\TransportFactory;
define('ALLOWED_TYPES', ["application/vnd.oasis.opendocument.text","application/pdf","application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document"]);
/**
 * Candidates Controller
 *
 * @property \App\Model\Table\CandidatesTable $Candidates
 * @method \App\Model\Entity\Candidate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CandidatesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $candidates = $this->paginate($this->Candidates);

        $this->set(compact('candidates'));
    }

    /**
     * Add method, adds a candidate in database and links it to its vavancy job offer. 
     * Also stores file on local server and sends an email with resume.
     * 
     * @param int $vac_no the id of the corresponding vacancy
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($vac_no)
    {
        $candidate = $this->Candidates->newEmptyEntity();
       
        if ($this->request->is('post')) {
            //Get file informations and set unique file localFileName for storage
            $attachment = $this->request->getUploadedFile('resume');
            $fileType = $attachment->getClientMediaType();
            $fileSize = $attachment->getSize(); 
            $clientFileName = $attachment->getClientFilename();
            $localFileName= uniqid(strval(rand()), true) . $clientFileName;

            if(in_array($fileType, ALLOWED_TYPES) && $fileSize<2000000){

                $candidateInfo = $this->request->getData();
                $candidateInfo['resume'] =  $localFileName;
                $candidateInfo['vac_no'] = $vac_no;
                $candidate = $this->Candidates->patchEntity($candidate, $candidateInfo);

                if ( $this->Candidates->save($candidate)) {
                    $vacancy = $this->Candidates->Vacancies->get($vac_no, [
                        'contain' => ['Departments', 'Titles']
                    ]);
                    //Link candidate with right vacancy
                    $this->Candidates->Vacancies->link($candidate,[$vacancy]);
                    //Store file in right folder
                    $targetPath = WWW_ROOT . 'assets' . DS . 'resumes' . DS .  $localFileName;
                    $attachment->moveTo($targetPath);

                    //Vacancy title & department name
                    $title = $vacancy->title->title;
                    $dept_name = $vacancy->department->dept_name;
                    //Manager informations
                    $dept_no = $vacancy->department->dept_no;
                    $managerInfo = $this->Candidates->Vacancies->Departments->get($dept_no, [
                        'contain' => ['Managers']
                    ]);
                    $managerEmail = $managerInfo->managers[0]->email;
                    $managerFirstName = $managerInfo->managers[0]->first_name;
                    $managerLastName = $managerInfo->managers[0]->last_name;
                    
                    //Email setup
                    TransportFactory::setConfig('mailtrap', [
                        'host' => 'smtp.mailtrap.io',
                        'port' => 2525,
                        'username' => '34c719b7b4c440',
                        'password' => '44641fccecd291',
                        'className' => 'Smtp'
                    ]);
                    $email = new Email();
                    $email->setTransport('mailtrap');
                    $email->setEmailFormat('html');
                    $email->viewBuilder()
                        ->setTemplate('default')
                        ->setLayout('default');
                    $email
                        ->setFrom([ $candidateInfo['email'] => $candidateInfo['first_name'] . ' ' . $candidateInfo['last_name']])
                        ->setTo([$managerEmail => $managerFirstName . ' ' . $managerLastName])
                        ->setSubject($dept_name . ': Candidate for ' . $title)
                        ->setAttachments([$clientFileName => $targetPath]);

                    $email->send('<body style="font-family:arial;">Hello ' . $managerFirstName . ', <br/> <br/>' . 
                                'This email has been sent to you because a candidate applied for a job offer in your department:<br/>' . 
                                 $candidateInfo['first_name'] . ' ' . $candidateInfo['last_name'] . ' applies for the ' .
                                 $title . ' vacancy and is born '. $candidateInfo['birth_date'] . '.<br/> <br/>' . 
                                'You will find his resume attached to this email. <br/> <br/> <br/>' . 
                                '<hr><p style="font-size:0.8em;">this email has been sent to you automatically, please do not reply.</p></body>');

                    $this->Flash->success(__('The candidate has been saved.'));

                    return $this->redirect(['controller' => 'Vacancies','action' => 'index']);
                }
                $this->Flash->error(__('The candidate could not be saved. Please, try again.'));
            }else {
                $this->Flash->error(__('The file given is too big or not of an acceptable fileType (must be .doc, .docx, .odt or .pdf)'));
            }
        }
        $vacancies = $this->Candidates->Vacancies->find('list', ['limit' => 200]);
        $this->set(compact('candidate', 'vacancies'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Candidate id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $candidate = $this->Candidates->get($id);
        if ($this->Candidates->delete($candidate)) {
            $this->Flash->success(__('The candidate has been deleted.'));
        } else {
            $this->Flash->error(__('The candidate could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
