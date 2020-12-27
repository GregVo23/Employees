<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Demand $demand
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $demand->demand_no],
                ['confirm' => __('Are you sure you want to delete # {0}?', $demand->demand_no), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Demands'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="demands form content">
            <?= $this->Form->create($demand) ?>
            <fieldset>
                <legend><?= __('Edit Demand') ?></legend>
                <?php
                    echo $this->Form->control('emp_no');
                    echo $this->Form->control('type');
                    echo $this->Form->control('about');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
