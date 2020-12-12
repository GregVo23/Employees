<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Vacancy[]|\Cake\Collection\CollectionInterface $vacancies
 */
?>
<div class="vacancies index content">
    <?= $this->Html->link(__('New Vacancy'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Vacancies') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('vac_no') ?></th>
                    <th><?= $this->Paginator->sort('dept_no') ?></th>
                    <th><?= $this->Paginator->sort('title_no') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vacancies as $vacancy): ?>
                <tr>
                    <td><?= $this->Number->format($vacancy->vac_no) ?></td>
                    <td><?= $vacancy->has('department') ? $this->Html->link($vacancy->department->dept_no, ['controller' => 'Departments', 'action' => 'view', $vacancy->department->dept_no]) : '' ?></td>
                    <td><?= $this->Number->format($vacancy->title_no) ?></td>
                    <td><?= $this->Number->format($vacancy->quantity) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $vacancy->vac_no]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $vacancy->vac_no]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $vacancy->vac_no], ['confirm' => __('Are you sure you want to delete # {0}?', $vacancy->vac_no)]) ?>
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
