<?php

/* @var $this yii\web\View */

use yii\web\View;

\yii\web\YiiAsset::register($this);
?>

<div class="index-container">
    <div class="font-bold text-2xl">DASHBOARD DATA SUBDIREKTORAT OPERASI DAN PENGUNGKAPAN JARINGAN</div>
    <div id="main-map" class="mx-auto w-fit"></div>
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="Modal Detail" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h5 class="modal-title font-bold text-dark" id="modalDetailLabel">Provinsi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-c p-2"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs('window.dataProvinsi = ' . json_encode($dataProvinsi) . ';', View::POS_HEAD);
$this->registerJs('window.dataKanwil = ' . json_encode($dataKanwil) . ';', View::POS_HEAD);
$this->registerJs(file_get_contents(__DIR__ . '/_index.js'), View::POS_END);
