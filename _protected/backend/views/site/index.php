<?php

/* @var $this yii\web\View */

use yii\web\View;

\yii\web\YiiAsset::register($this);
?>


<div>
    <div id="main-map"></div>
</div>

<?php
$this->registerJsFile('https://cdn.jsdelivr.net/npm/@svgdotjs/svg.js@3.2.4/dist/svg.min.js');
$this->registerCss(file_get_contents(__DIR__ . '/_index.css'));
$this->registerJs('window.dataProvinsi = ' . json_encode($dataProvinsi) . ';', View::POS_HEAD);
$this->registerJs('window.dataKanwil = ' . json_encode($dataKanwil) . ';', View::POS_HEAD);
$this->registerJs(file_get_contents(__DIR__ . '/_index.js'), View::POS_END);
