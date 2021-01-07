<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Demand;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
use Cake\ORM\TableRegistry;

/**
 * Demand policy
 */
class DemandPolicy
{
    /**
     * Check if $user can edit Demand
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Demand $demand
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Demand $demand)
    {
        //Utilisateur connecté avec son titre et département
        $user = TableRegistry::getTableLocator()->get('Employees')->get($user->get('emp_no'), ["contain" => ['titles', 'departments']]);
        //Employé qui a introduit la demande et son département
        $employee = TableRegistry::getTableLocator()->get('Employees')->get($demand->emp_no, ["contain" => ['departments']]);
        /**
         * Possibilité de modifier la demande uniquement si (admin,) manager ou comptable,.
         * l'admin a tous les droits.
         * Le comptable lui seulement en cas de demande d'augmentation de salaire.
         * Si c'est pour une demande d'affectation seuls les managers du département de l'employé 
         * ou du département de la réaffectation son autorisés à modifier la demande.
         */
        if ($user->titles[0]->title==='Admin'){
            return true;
        }
        $authorizedRoles = ['Manager', 'Accountant'];
        if(!in_array( $user->titles[0]->title, $authorizedRoles)){
            return new Result(false, 'No permission to edit demands.');
        }elseif($user->titles[0]->title === 'Accountant' && $demand->type==="reassignment"){
            return new Result(false, 'Doesn\'t concern accounting.');
        }elseif($user->titles[0]->title === 'Accountant'){
            return new Result(true);
        }elseif($demand->type==="Raise" && $employee->departments[0]->dept_no===$user->departments[0]->dept_no){
            return new Result(true);
        }
        elseif($demand->type==="Reassignment"){
            if ($user->departments[0]->dept_no === $demand->about || $user->departments[0]->dept_no === $employee->departments[0]->dept_no){
                return new Result(true);
            }else{
                return new Result(false, 'This demand does not concern your department');
            };
        }
        return new Result(false, 'You do not have permission to modify this demand');
       
    }

    /**
     * Check if $user can delete Demand
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Demand $demand
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Demand $demand)
    {
        return false;
    }

    /**
     * Check if $user can cancel Demand
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Demand $demand
     * @return bool
     */
    public function canCancel(IdentityInterface $user, Demand $demand)
    {
        //Utilisateur connecté avec son titre et département
        $user = TableRegistry::getTableLocator()->get('Employees')->get($user->get('emp_no'), ["contain" => ['titles', 'departments']]);
        //Employé qui a introduit la demande et son département
        $employee = TableRegistry::getTableLocator()->get('Employees')->get($demand->emp_no, ["contain" => ['departments']]);
        
        /**
         * Possibilité de modifier la demande uniquement si (admin,) manager ou comptable,.
         * l'admin a tous les droits.
         * Le comptable lui seulement en cas de demande d'augmentation de salaire.
         * Si c'est pour une demande d'affectation seuls les managers du département de l'employé 
         * ou du département de la réaffectation son autorisés à modifier la demande.
         */
        if ($user->titles[0]->title==='Admin'){
            return true;
        }
        if($demand->emp_no === $user->get('emp_no')){
            return new Result(true);
        }
        if($demand->type==="Raise"){
            if($user->titles[0]->title === 'Accountant'){
                return new Result(true);
            } 
            elseif($user->titles[0]->title === 'Manager'){
                if ($user->departments[0]->dept_no === $employee->departments[0]->dept_no){
                    return new Result(true);
                }else{
                    return new Result(false, 'This demand does not concern your department');
                }; 
            }else{
                return new Result(false, 'You do not have permission to do this action.');
            }
        }
        if($demand->type==="Reassignment"){
            if($user->titles[0]->title === 'Accountant'){
                return new Result(false, 'Does not concern accounting.');
            } 
            elseif($user->titles[0]->title === 'Manager'){
                if ($user->departments[0]->dept_no === $employee->departments[0]->dept_no || $user->departments[0]->dept_no === $demand->about){
                    return new Result(true);
                }else{
                    return new Result(false, 'This demand does not concern your department');
                }; 
            }else{
                return new Result(false, 'You do not have permission to do this action.');
            }
        }
    }

    /**
     * Check if $user can view Demand
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Demand $demand
     * @return bool
     */
    public function canView(IdentityInterface $user, Demand $demand)
    {
        return true;
    }
}
