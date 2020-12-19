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
 * 
 * @class Graphiques de la page "Women at work" du projet "Employees" réalisé dans le cadre du cours de Framework à l'EPFC
 * @author Grégory Van Ossel, Myriam Kadi, Simon Oldenhove
 * @version 1.0
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
    let nbWomen = <?= h($nbWomen); ?>;
    let nbMen = <?= h($nbMen) ?>;
    let nbMenManager = <?= h($nbMenManager->nbMenManager) ?>;
    let nbWomenManager = <?= h($nbWomenManager->nbWomenManager) ?>;
    <?php echo "let yearWomen = '".implode("<>", h($yearWomen))."'.split('<>')"; ?>;
    <?php echo "let nbHireWomen = '".implode("<>", h($nbHireWomen))."'.split('<>')"; ?>; 
    <?php echo "let nbDepMoreWomen = '".implode("<>", h($nbDepMoreWomen))."'.split('<>')"; ?>;
    <?php echo "let depNameMoreWomen = '".implode("<>", h($depNameMoreWomen))."'.split('<>')"; ?>;
    <?php echo "let nbDepLessWomen = '".implode("<>", h($nbDepLessWomen))."'.split('<>')"; ?>;
    <?php echo "let depNameLessWomen = '".implode("<>", h($depNameLessWomen))."'.split('<>')"; ?>;
</script>

<h1 class="pb-4 pt-3">Women at work</h1>
<di class="row">
    <div class="col-8 pb-3">
        <?= $this->Html->image("women.png", [
            "alt" => "women at work",
            'class' => 'img-fluid pb-4',
        ]);?>
        <h2 class="pb-5">La proportion par sexe ches Nestlé</h2>
        <p class="pb-3">La proportion de femmmes et hommes employée par Nestlé est presque semblable c'est à dire <?= h($cellMenWomenRatio) ?>, Nestlé tient à coeur à conserver cette proportion au sein de ses employés. Nestlé compte un total actuel de <?= h($cellNbWomen) ?> femmes au sein de l'entreprise. </p>
        <di class="row">
        <div class="col-6 pr-5 pt-5 pb-5">
            <h3 class="pb-3">Proportion de femmes et d’hommes au total</h3>
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>
        <div class="col-6 p-5">
            <h3 class="pb-3">Proportion de femmes et d’hommes manager</h3>
            <canvas id="myDoughnutChart" width="400" height="400"></canvas>
        </div>
        </di>
    </div>
    <div class="col-4 p-5">
        <h3 class="pb-4">Courbe annuelle du nombre de femmes au total</h3>
        <canvas id="myLineChart" width="400" height="400" class="pb-5 mb-5"></canvas>
        <asside class="p-5 mt-5">
            <h3 class="pb-4">Les femmes chez Nestlé</h3>
            <p>Les femmes sont importantes chez Nestlé, la société est d'ailleurs majoritairement dirigée par des femmes comme le prouve la proportion de manager h/f.</p>
            <?= $this->Html->image("femme.png", [
                "alt" => "logo",
                "class" => "ml-5 pl-5 pr-5 mr-5 pt-2",
                "width" => 400,
                "style" => "filter: opacity(90%)"                
            ]);?>
        </asside>
    </div>

</di>
<di class="row">
    <div class="col-5 pr-5 pt-5 pb-5">
        <h3 class="pb-5">Les 3 départements présentant le plus de femmes</h3>
        <canvas id="myBarChart" width="400" height="400"></canvas>
    </div>
    <div class="col-5 p-5">
        <h3 class="pb-5">Les 3 départements présentant le moins de femmes</h3>
        <canvas id="myBarChart2" width="400" height="400"></canvas>
    </div>
    <div class="col-2 p-5">
    </div>
</di>

<?php
$this->Html->script('chart.inc', ['block' => true]);
?>