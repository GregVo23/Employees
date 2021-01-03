<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Salary[]|\Cake\Collection\CollectionInterface $salaries
 */
?>
<div class="salaries index content">
    <?= $this->Html->link(__('New Salary'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Salaries') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('emp_no') ?></th>
                    <th><?= $this->Paginator->sort('salary') ?></th>
                    <th><?= $this->Paginator->sort('from_date') ?></th>
                    <th><?= $this->Paginator->sort('to_date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($salaries as $salary): ?>
                <tr>
                    <td><?= $this->Number->format($salary->emp_no) ?></td>
                    <td><?= $this->Number->format($salary->salary) ?></td>
                    <td><?= h($salary->from_date) ?></td>
                    <td><?= h($salary->to_date) ?></td>
                    <td class="actions">
                        <?= $this->Html->image("view.png", [
                            "alt" => "view",
                            'url' => ['action' => 'view', $salary->emp_no],
                            'width' => 50                          
                        ]);?>
                        
                        <?= $this->Html->image("edit.png", [
                            "alt" => "view",
                            'url' => ['action' => 'edit', $salary->emp_no],
                            'width' => 50                           
                        ]);?>
                        
                        <?= $this->Html->image("delete.png", [
                            "alt" => "view",
                            'url' => ['action' => 'delete', $salary->emp_no], ['confirm' => __('Are you sure you want to delete # {0}?', $salary->emp_no)],
                            'width' => 50                           
                        ]);?>
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
