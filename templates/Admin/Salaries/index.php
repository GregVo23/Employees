<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Salary[]|\Cake\Collection\CollectionInterface $salaries
 */
?>
<div class="salaries index content">
        <?php if(isset($_SESSION['status'])){
            if($_SESSION['status'] === "Admin"){ ?>
                <?= $this->Html->link(__('New Salary'), ['action' => 'add'], ['class' => 'button float-right']) ?>
            <?php }
        } ?>
    <h3><?= __('Salaries') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('emp_no') ?></th>
                    <th><?= $this->Paginator->sort('salary') ?></th>
                    <th><?= $this->Paginator->sort('from_date') ?></th>
                    <th><?= $this->Paginator->sort('to_date') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($salaries as $salary): ?>
                <tr>
                    <td><?= $this->Number->format($salary->emp_no) ?></td>
                    <td><?= $this->Number->format($salary->salary) ?></td>
                    <td><?= h($salary->from_date) ?></td>
                    <td><?= h($salary->to_date) ?></td>
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
