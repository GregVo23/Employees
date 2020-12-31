<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Demand $demand
 */
?>
<div class="row">
    <div class="column-responsive column-80 mx-auto">
        <div class="demands form content text-center mt-5">
            <?= $this->Html->link(__('Augmentation de salaire'), ['action' => 'addRaise'], ['class' => 'btn btn-secondary']) ?>
            <?= $this->Html->link(__('Réaffectation vers un autre département'), ['action' => 'addReassignment'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>
</div>