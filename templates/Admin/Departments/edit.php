<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Department $department
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $department->dept_no],
                ['confirm' => __('Are you sure you want to delete # {0}?', $department->dept_no), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Departments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="departments form content">
            <?= $this->Form->create($department) ?>
            <fieldset>
                <legend><?= __('Edit Department') ?></legend>
                <?php
                    echo $this->Form->control('dept_name');
                /*    echo $this->Form->select(
                         'employee',
                         $employees
                        // [$this->Departments->Employees->first_name],
                        // ['empty' => 'Choisir un nouveau manager']
                     );*/
                   // dd($managersFirstName);
                   //dd($employeeNameSelect[0]);
                    //dd($idEmp);
                   
                    echo $this->Form->control(
                            'managerName', ['label' => __('Nom du manager'), 'value'=>$managersFirstName.' '.$managersLastName, 'readonly' => true]);
                    echo $this->Form->control(
                            'employee', ['options' => $employeeNameSelect , 'class' => 'select', 'label' => __('Employées du département'), 'empty'=> 'Choisir un nouveau manager' ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Enregistrer les modifications')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
