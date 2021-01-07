<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

?>



<body style="background: url('<?php echo $this->Url->image('entreprise.jpg')?>' ); max-width: 100%; height: auto; background-repeat: no-repeat; background-size: cover;">
    <section class="container-fluid pl-0 pr-0">
        <h1 class="text-center pt-5 mt-5">Demande d'inscription au groupe Nestlé</h1>
        <div class="row justify-content-center">
            <div class="p-5 m-5 column-responsive column-50">
                <div class="users form content">
                    <?= $this->Form->create(null, ['url' => [
                        'controller' => 'Users',
                        'action' => 'register'
                        ]
                    ]); ?>
                    <?php
                    ?>
                    <fieldset>
                        <?php
                            echo $this->Form->control('username');
                            echo $this->Form->control('password');
                            echo $this->Form->control('email');
                        ?>
                    </fieldset>
                    <?= $this->Form->button(__('Submit'), ['class' => 'bouton']) ?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </section>
</body>
