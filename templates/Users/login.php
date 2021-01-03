<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>


<body style="background: url('<?php echo $this->Url->image('entreprise3.jpeg')?>' ); max-width: 100%; height: auto; background-repeat: no-repeat; background-size: cover;">
    <section class="container-fluid pl-0 pr-0">
        <h1 class="text-center pt-5 mt-5">Se connecter</h1>
        <div class="row justify-content-center">
            <div class="p-5 m-5 column-responsive column-50">
                <div class="users form content">
                    <?= $this->Form->create() ?>
                    <fieldset>
                        <legend><?= __('Connectez-vous, rentrez votre email & password') ?></legend>
                        <?= $this->Form->control('email') ?>
                        <?= $this->Form->control('password') ?>
                    </fieldset>
                    <?= $this->Form->button(__('Login'), ['class' => 'bouton']); ?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </section>
</body>
