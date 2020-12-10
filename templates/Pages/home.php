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


use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

$dir = new Folder('/webroot/assets/articles/');
$files = $dir->find('.*\.pdf');


//$this->disableAutoLayout();


$this->Html->css('style_home', ['block' => true]);
$this->Html->script('map.inc', ['block' => true]);

$titleHome = 'A propos de Nestlé';
$texteHome = 'Créée il y a plus de 150 ans, Nestlé est aujourd\'hui la première entreprise mondiale en termes d\'alimentation et de boissons.
Nous commercialisons plus de 2000 marques, allant des icônes mondiales aux marques favorites locales et sommes présents dans 190 pays.';
$titleHome2 = 'Notre raison d\'être';
$texteHome2 = 'Inspirés par la découverte scientifique capitale de notre fondateur, Henri Nestlé, guidés par nos valeurs et avec la nutrition au cœur de nos activités, nous travaillons avec nos partenaires pour améliorer la qualité de vie et contribuer à un avenir plus sain.';
$titleHome3 = 'Nos ambitions';
$texteHome3 = 'Nous avons défini trois ambitions globales qui guideront nos efforts pour atteindre nos engagements 2020 et pour soutenir la réalisation des Objectifs de développement durable des Nations-Unies.';
$titleHome4 = 'Notre histoire';
$texteHome4 = 'Nous voulons contribuer à construire un monde meilleur et plus sain. C\'est ainsi depuis l\'origine il y a plus de 150 ans lorsqu\'Henri Nestlé inventa la Farine Lactée qui sauva la vie d\'un enfant.
Pour lutter contre une mortalité infantile élevée, Henri Nestlé met au point et commercialise en Suisse dès 1867, la première farine lactée.
Il y a donc plus de 150 ans déjà, Henri Nestlé apportait une réponse à la nécessité de disposer d\'aliments sûrs et nutritifs pour remplacer le lait maternel si nécessaire et qui répondent aux besoins nutritionnels des enfants en bas âge.';
$titleHome5 = 'Nos valeurs';
$texteHome5 = 'Nos valeurs sont au  cœur de tout ce que nous entreprenons, nous agissons en toute légalité et honnêteté. Ces valeurs sont ancrées dans le respect, le respect pour nous-mêmes et pour toutes les personnes avec lequelles nous faisons des affaires.'
        
?>
<body>
    <main class="main">
        <section class="container-fluid pl-0 pr-0">
            <div>
                <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                        <?= $this->Html->image('entreprise.jpg', ['alt' => 'CakePHP','class' => 'd-block w-100',]); ?>
                    </div>
                    <div class="carousel-item">
                      <?= $this->Html->image('entreprise2.jpg', ['alt' => 'CakePHP','class' => 'd-block w-100',]); ?>
                    </div>
                  </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="content">
                    <div class="row">
                        <div class="col">
                            <h2 class="text-center"><?= $titleHome; ?></h2>
                            <?= $this->Text->autoParagraph($texteHome); ?>
                        </div>
                        <div class="col">
                            <?= $this->Html->image("logo.png", [
                                    "alt" => "logo de Nestlé sur un mur",
                                    'url' => ['action' => $this->Url->build('/')],
                                    'class' => 'img-fluid',
                            ]);?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h3><?= $titleHome2; ?></h3>
                            <?= $this->Text->autoParagraph($texteHome2); ?>
                        </div>
                        <div class="col">
                            <h3><?= $titleHome3; ?></h3>
                            <?= $this->Text->autoParagraph($texteHome3); ?>
                        </div>
                    </div>
                    
                    <div class="row">                        
                        <div class="col">
                            <h3><?= $titleHome4; ?></h3>
                            <?= $this->Text->autoParagraph($texteHome4); ?>
                        </div>                    
                        <div class="col">
                            <h3><?= $titleHome5; ?></h3>
                            <?= $this->Text->autoParagraph($texteHome5); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h3>On parle de nous dans la presse</h3>
                            <ul>
                                <li><?= $this->Html->link(__('article 1'),'/assets/report/article1.pdf',['target' => '_blank']); ?></li>
                                <li><?= $this->Html->link(__('article 2'),'/assets/report/article2.pdf',['target' => '_blank']); ?></li>
                                <li><?= $this->Html->link(__('article 3'),'/assets/report/article3.pdf',['target' => '_blank']); ?></li>
                            </ul>                        
                            <h3>Notre rapport annuel</h3>
                            <?= $this->Html->link(__('Télécharger'), '/assets/report/nestle_report.pdf', ['action' => 'home', 'download' => true ,'class' => 'btn btn-secondary']) ?>
                        </div>
                        <div class="col-6">
                            <div id="mapid"></div>
                        </div>
                        <div class="col">
                            <?= $this->Html->image("qrcode.png", [
                                    "alt" => "qrcode de Nestlé",
                                    'url' => ['action' => $this->Url->build('/')],
                                    'class' => 'img-fluid',
                            ]);?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
<!--leaflet-->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

</body>
</html>
