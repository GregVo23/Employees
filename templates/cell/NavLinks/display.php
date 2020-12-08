<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <?= $this->Html->image("logo.png", [
      "alt" => "logo",
      "class" => "ml-5 pl-5 pr-5 mr-5",
      'width' => 150                            
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
  </div>
</nav>