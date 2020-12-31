<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Demand[]|\Cake\Collection\CollectionInterface $raises
 */
?>
<div class="demands index content">
    <h3><?= __('Demandes d\'augmentation') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= __('Employé') ?></th>
                    <th><?= __('Département') ?></th>
                    <th><?= __('Titre') ?></th>
                    <th><?= __('Salaire actuel') ?></th>
                    <th><?= __('Salaire demandé') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($raises as $raise): ?>
                <tr>
                    <td><?= h($raise->employee) ?></td>
                    <td><?= h($raise->employeeDepartment) ?></td>
                    <td><?= h($raise->employeeTitle) ?></td>
                    <td><?= $this->Number->currency($raise->currentSalary, 'EUR') ?></td>
                    <td><?= $this->Number->currency($raise->about, 'EUR') ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $raise->demand_no]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $raise->demand_no]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $raise->demand_no], ['confirm' => __('Are you sure you want to delete # {0}?', $raise->demand_no)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <br />
    <hr />
    <?php if($_SESSION['status']!=='Accountant') { ?>
    <h3><?= __('Demandes de réaffectation vers votre département') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= __('Employé') ?></th>
                    <th><?= __('Département actuel') ?></th>
                    <th><?= __('Titre') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($incomers as $incomer): ?>
                <tr>
                    <td><?= h($incomer->employee) ?></td>
                    <td><?= h($incomer->employeeDepartment) ?></td>
                    <td><?= h($incomer->employeeTitle) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $incomer->demand_no]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $incomer->demand_no]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $incomer->demand_no], ['confirm' => __('Are you sure you want to delete # {0}?', $raise->demand_no)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <br />
    <hr />
    <h3><?= __('Demandes de réaffectation dans un autre département') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= __('Employé') ?></th>
                    <th><?= __('Département demandé') ?></th>
                    <th><?= __('Titre') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaving as $leaver): ?>
                <tr>
                    <td><?= h($leaver->employee) ?></td>
                    <td><?= h($leaver->department) ?></td>
                    <td><?= h($leaver->employeeTitle) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $leaver->demand_no]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $leaver->demand_no]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $leaver->demand_no], ['confirm' => __('Are you sure you want to delete # {0}?', $raise->demand_no)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
</div>
