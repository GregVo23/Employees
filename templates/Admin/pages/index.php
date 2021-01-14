<h1 class="text-center p-5">Bienvenue <strong><?= h($you->first_name)." ".h($you->last_name)." " ?></strong>!</h1>

<p class="text-center">Vous êtes dans le back-office de Nestlé !</p>

<?php if(!empty($_SESSION['status'])){ ?>
<h2 class="text-center mb-5">Votre status est : <strong><?= $_SESSION['status'] ?></strong></h2>
<?php } ?>
