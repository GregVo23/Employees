<?php
declare(strict_types=1);

namespace App\View\Cell;

use Cake\View\Cell;

/**
 * NavLinks cell
 */
class NavLinksCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
        $this->loadModel('Links');

        $links = $this->Links->find('all');
        
       if($_SESSION['Auth']){
           $status = $_SESSION['status']; 
           $menu = [];
           
           foreach($links as $link){
               if($status === 'Admin'){
                   $link->url = '/admin' . $link->url;
                    $menu[] = $link;
                }
               elseif($status === 'Manager' && $link->manager === 'admin'){
                   $link->url = '/admin'. $link->url;
                   $menu[] = $link;
                }
               elseif($status === 'Manager' && $link->manager === 'show'){
                   $menu[] = $link;
                }
               elseif($status === 'Accountant' && $link->accountant === 'admin'){
                   $link->url = '/admin'. $link->url;
                   $menu[] = $link;
                }
               elseif($status === 'Accountant' && $link->accountant === 'show'){
                  $menu[] = $link;
                }
                
                elseif($link->all === 'show'){
                    $menu[] = $link;
                }
            }
            $links = $menu;
       }
        $this->set(compact('links'));
    }
}