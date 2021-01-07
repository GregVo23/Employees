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
                            <?= $this->Form->postLink(__('Valider'), ['action' => 'validate', $raise->demand_no], ['confirm' => __('Valider la demande ?'), 'class'=>'btn btn-secondary' , 'style'=>'color:white'], ) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $raise->demand_no], ['class'=>'btn btn-secondary' , 'style'=>'color:white']) ?>
                            <?= $this->Form->postLink(__('Annuler'), ['action' => 'cancel', $raise->demand_no, 'class'=>'btn btn-primary'], ['confirm' => __('Annuler la demande définitivement?'), 'class'=>'btn btn-danger' , 'style'=>'color:white']) ?>
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
                    <?= $this->Form->postLink(__('Valider'), ['action' => 'validate', $incomer->demand_no, 'class'=>'btn btn-primary'], ['confirm' => __('Valider la demande ?'), 'class'=>'btn btn-secondary' , 'style'=>'color:white']) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $incomer->demand_no], ['class'=>'btn btn-secondary' , 'style'=>'color:white']) ?>
                        <?= $this->Form->postLink(__('Annuler'), ['action' => 'cancel', $incomer->demand_no, 'class'=>'btn btn-primary'], ['confirm' => __('Annuler la demande définitivement?'), 'class'=>'btn btn-secondary' , 'style'=>'color:white']) ?>
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
                        <?= $this->Form->postLink(__('Valider'), ['action' => 'validate', $leaver->demand_no, 'class'=>'btn btn-primary'], ['confirm' => __('Valider la demande ?'), 'class'=>'btn btn-secondary' , 'style'=>'color:white']) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $leaver->demand_no], ['class'=>'btn btn-secondary' , 'style'=>'color:white']) ?>
                        <?= $this->Form->postLink(__('Annuler'), ['action' => 'cancel',  $leaver->demand_no, 'class'=>'btn btn-primary'], ['confirm' => __('Annuler la demande définitivement?'), 'class'=>'btn btn-secondary' , 'style'=>'color:white']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
</div>
