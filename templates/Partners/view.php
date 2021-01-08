<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Partner $partner
 */
?>
<div class="row">
    <div class="column-responsive">
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
