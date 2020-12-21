<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <?= $this->Html->image("logo.png", [
      "alt" => "logo",
      "class" => "logo ml-5 pl-5 pr-5 mr-5",
      'width' => 150,
      'url' => '/'                            
  ]);?>
  <div>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  </div>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
      <?php foreach ($links as $link): ?>
        <li class="nav-item active">
          <a class="nav-link" href="<?= $this->Url->build($link->url);?>"><?= $link->name ?> <span class="sr-only">(current)</span></a>
        </li>
      <?php endforeach; ?>
      </ul>
        <?php if(!isset($_SESSION['Auth'])){ ?>
        <li class="d-flex justify-content-end">
            <?= $this->Html->link('S\'inscrire', '/users/register', ['class' => 'btn btn-secondary justify-content-end mr-2'] ); ?>
        </li>
        <li class="d-flex justify-content-end">
            <!-- Button trigger modal
            <a type="button" class="btn btn-secondary justify-content-end mr-5" data-bs-toggle="modal" data-bs-target="#connexion">
              Connexion
            </a> -->
            <li class="d-flex justify-content-end">
                <?= $this->Html->link('Connexion', '/users/login', ['class' => 'btn btn-danger justify-content-end mr-2'] ); ?>
            </li>
            <?php } else { ?>
            <li class="d-flex justify-content-end">
                <?= $this->Html->link('Deconnexion', '/users/logout', ['class' => 'btn btn-danger justify-content-end mr-2'] ); ?>
            </li>
            <?php } ?>
        </li>
  </div>
</nav>



<!-- Modal Connexion -->
<div class="modal fade" id="connexion" tabindex="-1" aria-labelledby="connexionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="connexionLabel">Accéder à mon compte</h3>
        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
      </div>
      <div class="modal-body">
        <div class="users form content">
            <?= $this->Form->create() ?>
            <fieldset>
                <legend><?= __('Please enter your email and password') ?></legend>
                <?= $this->Form->control('email') ?>
                <?= $this->Form->control('password') ?>
            </fieldset>
            <?= $this->Form->button(__('Login')); ?>
            <?= $this->Form->end() ?>
        </div>
      </div>
    </div>
  </div>
</div>