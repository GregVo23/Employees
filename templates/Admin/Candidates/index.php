<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Candidate[]|\Cake\Collection\CollectionInterface $candidates
 */
?>
<div class="candidates index content">
    <?= $this->Html->link(__('New Candidate'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Candidates') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('cand_no') ?></th>
                    <th><?= $this->Paginator->sort('first_name') ?></th>
                    <th><?= $this->Paginator->sort('last_name') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('resume') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($candidates as $candidate): ?>
                <tr>
                    <td><?= $this->Number->format($candidate->cand_no) ?></td>
                    <td><?= h($candidate->first_name) ?></td>
                    <td><?= h($candidate->last_name) ?></td>
                    <td><?= h($candidate->email) ?></td>
                    <td><?= h($candidate->resume) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $candidate->cand_no]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $candidate->cand_no]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $candidate->cand_no], ['confirm' => __('Are you sure you want to delete # {0}?', $candidate->cand_no)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
