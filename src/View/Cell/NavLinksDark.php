<?php
declare(strict_types=1);

namespace App\View\Cell;

use Cake\View\Cell;

/**
 * NavLinks cell
 */
class NavLinksDarkCell extends Cell
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
        $this->loadModel('Links');
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
        $links = $this->Links->find('all');
        $menu = [];
        
        if(!empty($_SESSION['status'])){
            foreach($links as $link){
                 $status = $_SESSION['status'];
                 if($status === 'Admin'){
                     if($link['admin'] === 'show'){
                          $link->url = '/admin' . $link->url;
                          $menu[] = $link;
                     }
                 }
                 elseif($status === 'Manager'){
                     if($link['manager'] === 'show'){
                          $link->url = '/admin' . $link->url;
                          $menu[] = $link;
                     }
                 }
                 elseif($status === 'Accountant'){
                     if($link['accountant'] === 'show'){
                          $link->url = '/admin' . $link->url;
                          $menu[] = $link;
                     }
                 }else{
                    if($link['employee'] === 'show'){
                     $link->url = $link->url;
                     $menu[] = $link;
                    }
                 }
            }   
        }else{
             foreach($links as $link){
                if($link['visitor'] === 'show'){
                    $link->url = $link->url;
                    $menu[] = $link;
                }
            }
        }
        $links = $menu;
        $this->set(compact('links'));
    }
}