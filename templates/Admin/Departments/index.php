<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Department[]|\Cake\Collection\CollectionInterface $departments
 */
?>
<div class="departments index content">
    <?php if(isset($_SESSION['status'])){
            if($_SESSION['status'] === "Admin"){ ?>
                <?= $this->Html->link(__('New Department'), ['action' => 'add'], ['class' => 'button float-right']) ?>
            <?php }
        } ?>
    <h3><?= __('Departments') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('dept_no') ?></th>
                    <th><?= $this->Paginator->sort('dept_name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departments as $department): ?>
                <tr>
                    <td><?= h($department->dept_no) ?></td>
                    <td><?= h($department->dept_name) ?></td>
                    <td class="actions">
                        <?= $this->Html->image("view.png", [
                            "alt" => "view",
                            'url' => ['action' => 'view', $department->dept_no],
                            'width' => 50                          
                        ]);?>

                        <?php if(isset($_SESSION['status'])){
                            if($_SESSION['status'] === "Admin" || $department->dept_no === $managerDept){ ?>
                            
                            <?= $this->Html->image("edit.png", [
                                "alt" => "view",
                                'url' => ['action' => 'edit', $department->dept_no],
                                'width' => 50                           
                            ]);?>

                        <?= $this->Html->image("delete.png", [
                            "alt" => "view",
                            'url' => ['action' => 'delete', $department->dept_no], ['confirm' => __('Are you sure you want to delete # {0}?', $department->dept_no)],
                            'width' => 50                           
                        ]);?>
                        
                        <?php }
                        } ?>
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
