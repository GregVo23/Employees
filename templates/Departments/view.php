<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Department $department
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Department'), ['action' => 'edit', $department->dept_no], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Department'), ['action' => 'delete', $department->dept_no], ['confirm' => __('Are you sure you want to delete # {0}?', $department->dept_no), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Departments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Department'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="departments view content">
            <h3><?= h($department->dept_no) ?></h3>
            <table>
                <tr>
                    <td><?= $this->Html->image(h("/img".$department->manager), [
                        "alt" => "manager picture",
                        'class' => 'img-fluid emp_pict',
                    ]);?>
                    </td>
                </tr>
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
                <tr>
                    <th><?= __('Internal rules and regulations ') ?></th>
                    <td><?= $this->Html->link(__('CLICK HERE TO READ IT'), $rules ,['target' => '_blank']); ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity of vacancies') ?></th>
                     
                     <?php  if(!empty($nbVacancies->quantity)){ ?>
                              <td><?php  foreach($nbVacancies as $nbVacancie):
                                            echo $nbVacancie->quantity;
                                            endforeach;
                                   ?>
                              </td>
        
                            <td><?= $this->Html->link(__('Postuler'),['controller'=>'Vacancies'],['action' => 'view'], ['class' => 'btn btn-secondary']) ?></td>
                        <?php } else{ ?>
                            <td><?= "No vacancies at the moment" ?></td>
                        <?php } ?>
                </tr>
            </table>
        </div>
    </div>
</div>
