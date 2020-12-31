<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Demand $demand
 */
?>
<div class="row">
    <div class="column-responsive column-80 mx-auto mt-5">
        <div class="demands form content">
            <?= $this->Form->create($demand) ?>
            <fieldset>
                <legend><?= __('Ajouter une demande') ?></legend>
                   <?= $this->Form->control('department', ['options' => $departments, 'class' => 'select mb-4', 'label' => __('Département')]) ?>
            </fieldset>
            <?= $this->Form->button(__('Envoyer'), ['class' => 'btn btn-danger']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
