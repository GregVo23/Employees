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
     * indexWomen method
     * 
     * @return \Cake\Http\Response|null|void Renders view
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
        
        //Les femmes employées par années
        $result = $this->Employees->findWomenHire();
        foreach($result['years'] as $year):
            $yearWomen[] = $year;
        endforeach;
        foreach($result['nbHire'] as $nbHire):
            $nbHireWomen[] = $nbHire;
        endforeach;

        //Les 3 départements contenant "le plus"/"le moins" d'employées femmes
        $result = $this->Employees->findMoreWomenDep();
        $cpt = 0;
        foreach($result as $depMore):
            $cpt++;
            if($cpt < 4):
                $depNameMoreWomen[] = $depMore->depName;
                $nbDepMoreWomen[] = $depMore->nbWomenDep;                            
            endif;
            if($cpt > 6):
                $depNameLessWomen[] = $depMore->depName;
                $nbDepLessWomen[] = $depMore->nbWomenDep;                
            endif;
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
        $this->set('depNameLessWomen',$depNameLessWomen);
        $this->set('nbDepLessWomen',$nbDepLessWomen);
        $this->set('depNameMoreWomen',$depNameMoreWomen);
        $this->set('nbDepMoreWomen',$nbDepMoreWomen);
        
        //Envoyer vers la vue spécifié
        $this->render('/women_at_work/indexWomen');
    }
}
