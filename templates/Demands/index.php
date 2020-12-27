<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Demand[]|\Cake\Collection\CollectionInterface $demands
 */
?>
<div class="demands index content">
    <?= $this->Html->link(__('New Demand'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Demands') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('demand_no') ?></th>
                    <th><?= $this->Paginator->sort('emp_no') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('about') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demands as $demand): ?>
                <tr>
                    <td><?= $this->Number->format($demand->demand_no) ?></td>
                    <td><?= $this->Number->format($demand->emp_no) ?></td>
                    <td><?= h($demand->type) ?></td>
                    <td><?= h($demand->about) ?></td>
                    <td><?= h($demand->status) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $demand->demand_no]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $demand->demand_no]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $demand->demand_no], ['confirm' => __('Are you sure you want to delete # {0}?', $demand->demand_no)]) ?>
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
