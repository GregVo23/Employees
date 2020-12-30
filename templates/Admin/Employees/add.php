<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Liste des employé(e)s'), ['action' => 'index'], ['class' => 'btn btn-secondary', 'style' => 'color:white;']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="employees form content">
            <?= $this->Form->create($employee) ?>
            <fieldset>
                <legend><?= __('Ajouter un(e) employé(e)') ?></legend>
                <div class="row">
                    <div class ="col-6">
                      <?= $this->Form->control('department', ['options' => $departments, 'class' => 'select', 'label' => __('Département')]) ?>
                    </div>
                    <div class ="col-6">
                      <?= $this->Form->control('email', ['label' => __('Email'), 'class' => 'email']); ?>
                    </div>
                    <div class ="col-6">
                      <?= $this->Form->control('first_name', ['label' => __('Prénom')]); ?>
                    </div>
                    <div class ="col-6">
                      <?= $this->Form->control('last_name', ['label' => __('Nom de famille')]); ?>
                    </div>
                    <div class ="col-6">
                      <?= $this->Form->control('birth_date', ['label' => __('Date de naissance')]); ?>
                    </div>
                    <div class ="col-6">
                      <?= $this->Form->control('gender', ['options' => $gender, 'class' => 'select', 'label' => __('Sexe')]) ?>
                    </div>
                    <div class ="col-6">
                      <?= $this->Form->control('hire_date', ['label' => __('Date d\'embauche')]); ?>
                    </div>
                </div>
            </fieldset>
            <!--'controller' => ??????? -->
            <?= $this->Form->postButton(__('Ajouter'), ['action' => 'submit']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
