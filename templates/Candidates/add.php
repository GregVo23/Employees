<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Candidate $candidate
 */
define('FILE_ACCEPT_TYPES', 'application/vnd.oasis.opendocument.text,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document')
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Candidates'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="candidates form content">
            <?= $this->Form->create($candidate, ['type' => 'file']) ?>
            <fieldset>
                <legend><?= __('Add Candidate') ?></legend>
                <?php
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('last_name');
                    echo $this->Form->control('birth_date');
                    echo $this->Form->control('email');
                    echo $this->Form->label('resume', 'CV (max 2MB)');
                    echo $this->Form->file('resume', ['accept' => FILE_ACCEPT_TYPES]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
