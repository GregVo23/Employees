<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Partner $partner
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Partner'), ['action' => 'edit', $partner->partner_no], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Partner'), ['action' => 'delete', $partner->partner_no], ['confirm' => __('Are you sure you want to delete # {0}?', $partner->partner_no), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Partners'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Partner'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>

        <div class="column-responsive column-80 ">
          <div class="partners view content">
            <h3 class="text-center"><?= h($partner->title) ?></h3>

                <div class="card mx-auto" style="width: 18rem;">
                     <?= $this->Html->image(h($partner->logo), [
                                 'url' => $partner->url,
                                 'alt' => 'logo du partenaire',
                                 'width'=> '50px',
                                 'class' => 'card-img-top',
                     ]);?>
                     <div class="card-body">
                       <h5 class="card-title text-center"><?= __('Partner No')  ." : ". $this->Number->format($partner->partner_no) ?></h5>
                     </div>
                </div>
          </div>
        </div>
</div>
