<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Partners Controller
 *
 * @method \App\Model\Entity\Partner[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PartnersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['index', 'view']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();

        $partners = $this->paginate($this->Partners);

        $this->set(compact('partners'));
    }

    /**
     * View method
     *
     * @param string|null $id Partner id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();

        $partner = $this->Partners->get($id, [
            'contain' => [],
        ]);

                
        $this->set(compact('partner'));
    }
}
