<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->Html->script('moment.min', ['block' => true]);
$this->Html->script('Chart.min', ['block' => true]);
$this->Html->css('Chart.min', ['block' => true]);

?>
<script>
    let nbWomen = <?= h($nbWomen) ?>;
    let nbMen = <?= h($nbMen) ?>;
    <?php echo "let yearWomen = '".implode("<>", $yearWomen)."'.split('<>');"; ?>
    <?php echo "let nbHireWomen = '".implode("<>", $nbHireWomen)."'.split('<>');"; ?>
</script>




<h1>Women at work</h1>
<di class="row">
    <div class="col-6">
        <?= $this->Html->image("women.png", [
            "alt" => "women at work",
            'class' => 'img-fluid',
        ]);?>
        <h2>La proportion par sexe ches Nestlé</h2>
        <p>La proportion de femmmes et hommes employée par Nestlé est presque semblable c'est à dire <?= $cellMenWomenRatio ?>, Nestlé tient à coeur à conserver cette proportion au sein de ses employés. Nestlé compte un total actuel de <?= $cellNbWomen ?> femmes au sein de l'entreprise. </p>
    </div>
    <div class="col-6 p-5">
        <h3>Courbe annuelle du nombre de femmes au total</h3>
        <canvas id="myLineChart" width="400" height="400"></canvas>
    </div>
</di>
<di class="row">
    <div class="col-6 p-5">
        <h3>Proportion de femmes et d’hommes au total</h3>
        <canvas id="myChart" width="400" height="400"></canvas>
    </div>
    <div class="col-6 p-5">
        <h3>Proportion de femmes et d’hommes manager</h3>
        <canvas id="myDoughnutChart" width="400" height="400"></canvas>
    </div>
</di>
<di class="row">
    <div class="col-6 p-5">
        <h3>Les 3 départements présentant le plus de femmes</h3>
        <canvas id="myBarChart" width="400" height="400"></canvas>
    </div>
    <div class="col-6 p-5">
        <h3>Les 3 départements présentant le moins de femmes</h3>
        <canvas id=myBarChart2" width="400" height="400"></canvas>
    </div>
</di>




<?php
$this->Html->script('chart.inc', ['block' => true]);
?>