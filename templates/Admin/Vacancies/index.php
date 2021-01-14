<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Vacancy[]|\Cake\Collection\CollectionInterface $vacancies
 */
?>
<div class="vacancies index content">
            <?php if(isset($_SESSION['status'])){
            if($_SESSION['status'] === "Admin" || $managerDept){ ?>
                <?= $this->Html->link(__('New Vacancy'), ['action' => 'add'], ['class' => 'button float-right']) ?>
            <?php }
        } ?>
    <h3><?= __('Vacancies') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('department') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>

                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <?php if(isset($_SESSION['status'])){
                         if($_SESSION['status'] === "Admin"){ ?>
                            <th class="actions"><?= __('Actions') ?></th>                             
                    <?php }
                    } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vacancies as $vacancy): ?>
                <tr>
                    <td><?= h($vacancy->department->dept_name) ?></td>
                    <td><?= h($vacancy->title->title) ?></td>
                    <td><?= $this->Number->format($vacancy->quantity) ?></td>
                    <td class="actions">
                        
                        <?php if(isset($_SESSION['status'])){
                            if($_SESSION['status'] === "Admin" || $vacancy->dept_no === $managerDept){ ?>
                            <?= $this->Html->image("edit.png", [
                                "alt" => "view",
                                'url' => ['action' => 'edit', $vacancy->vac_no],
                                'width' => 50                           
                            ]);?>
                        
                            <?= $this->Form->postLink(
                                $this->Html->image("delete.png", [
                                "alt" => "view",
                                'width' => 50,
                                ]),
                                ['action' => 'delete', $vacancy->vac_no], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $vacancy->vac_no)],
                            );?>   
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
