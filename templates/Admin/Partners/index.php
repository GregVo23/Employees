<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Partner[]|\Cake\Collection\CollectionInterface $partners
 */
?>
<div class="partners index content">
        <?php if(isset($_SESSION['status'])){
            if($_SESSION['status'] === "Admin"){ ?>
                <?= $this->Html->link(__('New Partner'), ['action' => 'add'], ['class' => 'button float-right']) ?>
            <?php }
        } ?>
    <h3><?= __('Partners') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('title') ?></th>
                   
                    <th><?= $this->Paginator->sort('partner_no') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($partners as $partner): ?>
                <tr>
                    <td><?= h($partner->title) ?></td>
                  
                   
                    <td><?= $this->Number->format($partner->partner_no) ?></td>
                    <td class="actions">
                        <?= $this->Html->image("view.png", [
                            "alt" => "view",
                            'url' => ['action' => 'view', $partner->partner_no],
                            'width' => 50                          
                        ]);?>
                        <?php if(isset($_SESSION['status'])){
                            if($_SESSION['status'] === "Admin"){ ?>
                            <?= $this->Html->image("edit.png", [
                                "alt" => "view",
                                'url' => ['action' => 'edit', $partner->partner_no],
                                'width' => 50                           
                            ]);?>

                            <?= $this->Form->postLink(
                                $this->Html->image("delete.png", [
                                "alt" => "view",
                                'width' => 50,
                                ]),
                                ['action' => 'delete', $partner->partner_no], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $partner->partner_no)],

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
