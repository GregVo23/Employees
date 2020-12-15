<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Vacancy $vacancy
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>

            <?= $this->Html->link(__('Edit Vacancy'), ['action' => 'edit', $vacancy->vac_no], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Vacancy'), ['action' => 'delete', $vacancy->vac_no], ['confirm' => __('Are you sure you want to delete # {0}?', $vacancy->vac_no), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Vacancies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Vacancy'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="vacancies view content">
            <h3><?= h($vacancy->vacancy_no) ?></h3>
            <table>
                <tr>
                    <th><?= __('Department') ?></th>
                    <td><?= $vacancy->has('department') ? $this->Html->link($vacancy->department->dept_no, ['controller' => 'Departments', 'action' => 'view', $vacancy->department->dept_no]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Vac No') ?></th>
                    <td><?= $this->Number->format($vacancy->vac_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title No') ?></th>
                    <td><?= $this->Number->format($vacancy->title_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($vacancy->quantity) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
