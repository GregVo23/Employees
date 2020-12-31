<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Demand[]|\Cake\Collection\CollectionInterface $demands
 */
?>
<div class="demands index content">
    <?= $this->Html->link(__('Introduire une demande'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Demandes') ?></h3>
    <h2>Vos demandes en attente d'approbation.</h2>
    <?php if(!empty($pendings)) { ?>
        <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= __('Type') ?></th>
                    <th><?= __('Pour') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pendings as $demand): ?>
                <tr>
                    <td><?= h($demand->type==='Reassignment'?'Réaffectation':'Augmentation') ?></td>
                    <td><?= h($demand->about) ?></td>
                    <td class="actions">
                        <?= $this->Form->postLink(__('Annuler'), ['action' => 'cancel', $demand->demand_no], ['confirm' => __('Annuler la demande définitivement?')]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php } else { ?>
        <p>Vous n'avez pas de demande en attente.</p>
    <?php } ?>
    
    <hr/>
    <h2>Vos demandes passées.</h2>
    <?php if(!empty($passed)) { ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                    <th><?= __('Type') ?></th>
                        <th><?= __('Pour') ?></th>
                        <th><?= __('Statut') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($passed as $demand): ?>
                    <tr>
                        <td><?= h($demand->type) ?></td>
                        <td><?= h($demand->about) ?></td>
                        <td><?= h($demand->status) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $demand->demand_no]) ?>
                            <?= $this->Form->postLink(__('Cancel'), ['action' => 'cancel', $demand->demand_no], ['confirm' => __('Annuler la demande définitivement?')]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <p>Vous n'avez pas encore de demandes.</p>
    <?php } ?>
    <hr/>
</div>
