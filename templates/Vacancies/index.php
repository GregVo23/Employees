<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Vacancy[]|\Cake\Collection\CollectionInterface $vacancies
 */
?>
<div class="vacancies index content">
    <h3><?= __('Vacancies') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>

                    <th><?= $this->Paginator->sort('department') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>

                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vacancies as $vacancy): ?>
                <tr>
                    <td><?= h($vacancy->department->dept_name) ?></td>
                    <td><?= h($vacancy->title->title) ?></td>
                    <td><?= $this->Number->format($vacancy->quantity) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Postuler'), ['controller'=>'candidates', 'action' => 'add', $vacancy->vac_no], ['class' => 'btn btn-secondary float-right', 'style' => "color:white;"]) ?>
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
