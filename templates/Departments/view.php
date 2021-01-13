<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Department $department
 */
?>
<div class="row">
    <div class="column-responsive">
        <div class="departments view content">
            <h3><?= h($department->dept_no) ?></h3>
            
            <table>
            <?php if($showManager) { ?>
                <tr>
                    <td><?= $this->Html->image(h($department->manager), [
                                    "alt" => "manager picture",
                                    'class' => 'img-fluid emp_pict',
                            ]);?>
                    </td>
                </tr>
            <?php } ?>
                <tr>
                    <th><?= __('Dept No') ?></th>
                    <td><?= h($department->dept_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dept Name') ?></th>
                    <td><?= h($department->dept_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Number of employees') ?></th>
                    <td><?= h($result) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= $this->Text->autoParagraph($description); ?></td>
                </tr>
                <?php if($showRoi){ ?>
                <tr>
                    <th><?= __('Internal rules and regulations ') ?></th>
                    <td><?= $this->Html->link(__('CLICK HERE TO READ IT'), $rules ,['target' => '_blank']); ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <th><?= __('Quantity of vacancies') ?></th>
                     
                     <?php if(!empty($department->vacancie)){ ?>
                            <td>
                             <?= $department->vacancie; ?>
                            </td>
                            
                            <td><?= $this->Html->link(__('Postuler'),['controller'=>'Vacancies','action' => 'index'], ['class' => 'btn btn-secondary']) ?></td>
                     <?php } else { ?>
                            <td><?= "No vacancies at the moment" ?></td>
                     <?php } ?>
                </tr>
            </table>
        </div>
    </div>
</div>
