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
                <legend><?= __('Add Demand') ?></legend>
                <?php
                    echo $this->Form->control('about', ['label'=>__('Montant du salaire'), 'maxlength'=>15, 'class' => 'mb-4']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Envoyer'), ['class' => 'btn btn-danger']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
