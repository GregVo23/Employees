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
        <li class="d-flex justify-content-end">
            <?= $this->Html->link('S\'inscrire', '/pages/sign_up', ['class' => 'btn btn-danger justify-content-end mr-2'] ); ?>
        </li>
        <li class="d-flex justify-content-end">
            <!-- Button trigger modal -->
            <a type="button" class="btn btn-secondary justify-content-end mr-5" data-bs-toggle="modal" data-bs-target="#connexion">
              Connexion
            </a>
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
        <form>
            <div class="mb-3">
              <label for="userName" class="form-label">Username</label>
              <input type="email" class="form-control" id="userName" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="password1" class="form-label">Password</label>
              <input type="password" class="form-control" id="password1">
            </div>
            <button type="submit" class="btn btn-danger">Connexion</button>
        </form>
      </div>
    </div>
  </div>
</div>