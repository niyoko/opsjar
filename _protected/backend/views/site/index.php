<?php

/* @var $this yii\web\View */

use yii\web\View;

\yii\web\YiiAsset::register($this);
?>

<div class="index-container">
    <div class="font-bold text-2xl">DASHBOARD DATA SUBDIREKTORAT OPERASI DAN PENGUNGKAPAN JARINGAN</div>
    <div id="main-map" class="mx-auto w-fit"></div>
</div>

<?php
$this->registerJs('window.dataProvinsi = ' . json_encode($dataProvinsi) . ';', View::POS_HEAD);
$this->registerJs('window.dataKanwil = ' . json_encode($dataKanwil) . ';', View::POS_HEAD);
$this->registerJs(file_get_contents(__DIR__ . '/_index.js'), View::POS_END);
