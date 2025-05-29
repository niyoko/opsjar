<?php

use common\components\MyFormatter;
use backend\models\Bimtek;
use backend\models\Narkotika;
use backend\models\Provinsi;
use backend\models\Tahun;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Progress;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Provinsi */

\yii\web\YiiAsset::register($this);
$this->registerCssFile("@web/css/jqvmap.css", [
    'depends' => [BootstrapAsset::class],
]);
?>
<style>
    html,
    body {
        height: 100%;
        background-color: #252733 !important;
        color: white !important;
    }

    .progress {
        height: 15px;
        margin-top: 5px;
    }

    .text-lg {
        font-size: xx-large;
    }

    .text-md {
        font-size: medium;
    }

    .text-xxs {
        font-size: xx-small;
    }

    .text-xs {
        font-size: x-small;
    }

    .table-kasus {
        margin-top: 10px;

    }


    .table-kasus tr td {
        border-bottom: 1px solid white;
        padding: 5px;
    }

    .table-kasus tr th {
        padding-top: 5px;
    }

    .center {
        margin: auto;
        width: 50%;
        padding: 0 auto;
    }

    @media only screen and (max-height: 720px) {
        .box-opsjar .text-lg {
            font-size: large;
        }

        .box-opsjar-header {
            font-size: x-small;
        }

        .box-opsjar .text-md {
            font-size: small;
        }


        .form-select {
            height: auto;
            line-height: 14px;
            font-size: small;
        }

        .table-kasus {
            margin-top: 5px;
        }

    }

    @media only screen and (max-width: 767px) {
        .summary-lg {
            display: none;
        }
    }

    @media only screen and (min-width: 767px) {
        .summary-sm {
            display: none;
        }
    }

    @media only screen and (max-width:1500px) {

        .text-sm {
            font-size: 10px;
        }

        .tbl-box {
            font-size: 12px !important;
            width: fit-content;
            gap: 15px;
        }

        .case-summary {
            min-width: 11 nmjknm0px !important;
            max-width: 110px !important;
            gap: 5px;
        }

        .tbl-item {
            min-width: 60px !important;
            max-width: 60px !important;
        }

        .tbl-item-total {
            min-width: 70px !important;
            max-width: 70px !important;
        }

        .tbl-item-surat {
            min-width: 80px !important;
        }
    }

    #tbl-penangkapan {
        text-align: center;
        align-items: center;
        align-content: center;
        color: black;
    }

    #tbl-penangkapan .material-icons-outlined {
        font-size: 18px;
        color: #FBB03B;
        padding-top: 2px;
    }

    #tbl-penangkapan .material-icons {
        font-size: 18px;
        color: #FBB03B;
        padding-top: 3px;
    }

    .tbl-box {
        box-sizing: border-box;

        /* Auto layout */
        align-items: center;
        gap: 25px;

        height: 50px;
        margin-bottom: 10px;

        background: #FFFFFF;
        /* opsjar/abu muda */

        border-bottom: 1px solid #C4C4C4;

        /* Inside auto layout */

        flex: none;
        order: 0;
        flex-grow: 0;
        font-size: 16px;
        width: fit-content;
    }

    .tbl-box .btn {
        width: max-content;
        height: fit-content;
        padding: 2px;
        font-size: smaller;
    }

    .tbl-no {

        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 0px 5px;
        margin-right: 5px;
        gap: 10px;

        width: 28px;
        height: 28px;

        /* opsjar/orange */

        background: #FBB03B;
        border-radius: 0px 4px 4px 0px;

        /* Inside auto layout */

        flex: none;
        order: 0;
        flex-grow: 0;
    }

    .div-material {
        display: inline-flex;
        vertical-align: bottom;
        gap: 5px;
    }

    .case-summary {
        min-width: 150px;
        max-width: 150px;
        gap: 15px;
    }

    .tbl-item {
        min-width: 80px;
        max-width: 80px;
    }

    .tbl-item-total {
        min-width: 70px;
        max-width: 100px;
    }

    .tbl-base {
        min-width: fit-content;
    }

    .tbl-item-surat {
        min-width: 150px;
    }

    .modal-xl {
        max-width: 90% !important;
    }

    #modalDetail {
        margin-top: 20px;
    }

    #modalDetail .modal-content {
        min-height: 500px;
        max-height: fit-content;
    }

    .text-sm {
        font-size: 14px;
    }

    .modal-header {
        border-bottom: 0 none;
    }

    .tbl-no-red {

        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 0px 5px;
        margin-right: 5px;
        gap: 10px;

        width: 28px;
        height: 28px;

        /* opsjar/orange */

        background: #FF3E3E;
        border-radius: 0px 4px 4px 0px;

        /* Inside auto layout */

        flex: none;
        order: 0;
        flex-grow: 0;
    }

    .info-anggaran {
        /* background: #4F5472; */
        /* border-radius: 4px; */
        /* width: fit-content; */
        /* font-style: italic; */
        font-size: xx-small;
        /* opacity: 0.5; */
    }

    .square {
        height: 10px;
        width: 10px;
        border: 1px solid white;
        margin-left: 5px;
        margin-right: 5px;
    }

    .table-tooltip .text-tooltip {
        font-size: x-small;
    }

    .table-tooltip .text-tooltip-header {
        font-size: medium;
    }

    .table-tooltip tr td {
        background-color: #f8f9fa;
        padding: 3px;
        vertical-align: middle !important;
    }

    a {
        text-decoration: none !important;
        color: white;
    }

    a:hover {
        text-decoration: none !important;
        color: white;
    }

    .text-md-dashboard {
        font-size: x-large;
    }

    ul.no-bullets {
        list-style-type: none;
        margin: 0;
        padding: 1;
    }
</style>
<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'id' => 'search-form'
]); ?>
<div class="main-site">
    <div class="row p-0">
        <div class="col-md-3 p-0"></div>
        <div class="col-md-9 p-0 text-center">
            <span class="font-bold" style="text-transform: uppercase; font-size:larger;">DASHBOARD DATA SUBDIREKTORAT OPERASI DAN PENGUNGKAPAN JARINGAN NARKOTIKA</span>
        </div>
    </div>
    <div class="row align-items-end">
        <div class="col-md-3 col-sm-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center box-opsjar box-1">
                        <div class="box-opsjar-header">
                            <span class="font-bold"> Manajemen Data</span>
                        </div>

                        <div class="box-body mt-1 text-start">
                            <div class="row">
                                <div class="col-md-12 pl-3 pr-3">
                                    <div class="mb-1 ml-auto">Menampilkan Data</div>
                                </div>
                                <div class="col-md-12">
                                    <?= Html::dropDownList('provinsi', $provinsi, Provinsi::getOptionsMap(), ['class' => 'form-select form-select-sm search-btn', 'id' => 'provinsi', 'aria-label' => 'Provinsi', 'prompt' => 'Seluruh Indonesia']) ?>

                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for="tahun" class="mb-1">Tahun</label>
                                    <?= Html::dropDownList('tahun', $tahun, Bimtek::optionsTahun(), ['class' => 'form-select form-select-sm d-inline-flex search-btn', 'id' => 'tahun', 'aria-label' => 'Tahun']) ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="tahun" class="mb-1">Bulan</label>
                                    <?= Html::dropDownList('bulan', $bulan, Bimtek::optionsBulan(), ['class' => 'form-select form-select-sm d-inline-flex search-btn', 'id' => 'bulan', 'aria-label' => 'Bulan', 'prompt' => 'Semua']) ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-12 ">
                    <div class="row align-items-end">
                        <div class="col-md-5" style="padding-right: 7px;">
                            <a href="/capaian">
                                <div class="text-center box-opsjar-double box-1 text-center">
                                    <div class="box-opsjar-header">
                                        <span class="font-bold"> Data NKO</span>
                                    </div>

                                    <div class="box-body text-center justify-content-center">
                                        <div class="box-opsjar-horizontal-wrap">
                                            <div class="d-flex  align-items-center justify-content-center vertical-center" style="max-width:fit-content ;">
                                                <div class="align-items-center">
                                                    <div class=" bd-highlight"><?= $this->render('@app/views/utilities/piala-dashboard-' . $nko_color) ?></div>
                                                    <div class="text-md p-2 text-warning text-nko" style="vertical-align: middle ;"><span class="font-bold text-md-dashboard <?= $text_nko ?>" style="margin-right:5px"><?= round($nko) ?></span><span class="text-muted">NKO</span></div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-7" style="padding-left: 8px;">
                            <a href="/anggota">
                                <div class="text-center box-opsjar-double box-1">
                                    <div class="box-opsjar-header">
                                        <span class="font-bold"> Status Anggota</span>
                                    </div>

                                    <div class="box-body text-start">
                                        <div class="box-opsjar-horizontal-wrap">
                                            <div class="vertical-center" style="gap: auto;">
                                                <div class="p-1">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <?= $this->render('@app/views/utilities/member') ?>
                                                            </td>
                                                            <td class="text-xs" style="padding-left:5px;">
                                                                Standby
                                                                <div><span class="text-md text-warning"><?= $member['standby'] ?></span></div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="p-1">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <?= $this->render('@app/views/utilities/member-orange') ?>
                                                            </td>
                                                            <td class="text-xs" style="padding-left:5px; ">
                                                                Dalam Tugas
                                                                <div><span class="text-md text-warning"><?= $member['tugas'] ?></span></div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="col-md-12 col-sm-12">
                    <div class="row summary-lg">
                        <div class="col-md-12 col-sm-4">
                            <div class="text-center box-opsjar box-2">
                                <div class="box-opsjar-header">
                                    <span class="font-bold"> 5 Kasus Tertinggi</span>
                                </div>

                                <div class="mt-1">
                                    <table class="table-kasus">
                                        <?php for ($i = 0; $i < 5; $i++) : ?>
                                            <tr>
                                                <td>
                                                    <span class="tbl-no-red"><?= ($i + 1) ?></span>
                                                </td>
                                                <td class="text-light text-sm text-start"><span class=""><?= isset($case[$i]) ? ($case[$i]['name']) : '<i>Data belum tersedia</i>' ?></span></td>
                                                <td class="text-light text-sm text-end"><?= isset($case[$i]) ? round($case[$i]['total']) . ' Kasus' : '' ?></td>
                                            </tr>
                                        <?php endfor ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-sm-12 text-center">
            <div class="row">
                <div class="col-md-12">
                    <div class="map-container p-0" style="max-width:100%;">
                        <div id="map-body">
                            <div id="vmap"></div>
                        </div>
                    </div>

                </div>
                <div class="row align-items-end">
                    <div class="col-md-6">
                        <div class="text-center box-opsjar-horizontal box-1">
                            <div class="box-opsjar-header">
                                <span class="font-bold"> Kasus</span>
                            </div>

                            <div class="box-body mt-1 text-center justify-content-center">
                                <?php if ($total <= 0) : ?>
                                    <span class="text-sm text-muted">Data belum tersedia</span>
                                <?php else : ?>
                                    <div class="" style="max-height: 200px ;">
                                        <canvas id="kasus" class="chart-canvas" style="padding:0px;margin:0px"></canvas>
                                    </div>
                                    <div class="d-flex mt-2 justify-content-center" style="gap: 5px;">
                                        <div class="d-flex">
                                            <div class="square opsjar-biru-muda" style="margin-top: 2px ;"></div>
                                            <div style="font-size:x-small;"> Total BB dalam ribu </div>

                                        </div>
                                        <div class="d-flex">
                                            <div class="square bg-warning" style="margin-top: 2px ;"></div>
                                            <div style="font-size:x-small;"> Total Kasus </div>

                                        </div>
                                    </div>
                                <?php endif ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center box-opsjar-horizontal box-1">
                            <div class="box-opsjar-header">
                                <span class="font-bold"> Jenis NPP</span>
                            </div>

                            <div class="box-body-chart mt-1 text-start ">
                                <div class="d-flex p-1 align-middle" style="gap:auto;max-width:fit-content;height:max-content;margin-top: 20px;">
                                    <div class="" style="max-width: 100px ;">
                                        <?php if ($total <= 0) : ?>
                                            <span class="text-sm text-muted">Data belum tersedia</span>
                                        <?php else : ?>
                                            <canvas id="jnpp" class="chart-canvas" style="padding:0px;margin:0px"></canvas>
                                        <?php endif ?>

                                    </div>
                                    <div class="text-sm" style="min-width: fit-content ;">
                                        <ul class="no-bullets">
                                            <?php foreach ($detail as $d) : ?>
                                                <li>
                                                    <div class="d-flex ">
                                                        <div class="square <?= $d['color'] ?>"></div>
                                                        <div class="text-xxs"><?= $d['label'] ?></div>
                                                        <div class="text-end"></div>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                            <li>
                                                <div class="text-sm p-2" style="width: max-content ;">TOTAL <span class="text-warning"><?= MyFormatter::applyNumberFormat($total) . 'gr' ?></span></div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a href="/anggaran">
                            <div class="text-center box-opsjar-horizontal box-1">
                                <div class="box-opsjar-header">
                                    <span class="font-bold"> Sisa Anggaran</span>
                                </div>

                                <div class="box-body text-start">
                                    <div class="box-opsjar-horizontal-anggaran text-md">
                                        <table class="table-kasus" width="90%">
                                            <tr>
                                                <th>DIPA</th>

                                            </tr>
                                            <tr>
                                                <td class="text-warning text-start"><?= $dipa ?  Yii::$app->formatter->asCurrency(round($dipa)) : '-' ?></td>
                                            </tr>
                                            <tr>
                                                <th>DOKPPN</th>

                                            </tr>
                                            <tr>
                                                <td class="text-warning text-start"><?= Yii::$app->formatter->asCurrency(round($dokppn)) ?></td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="Modal Detail" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h5 class="modal-title font-bold text-dark" id="modalDetailLabel">Provinsi</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div id="prov-map" style="width: 650px; height: 650px; padding: 25px;"></div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php

    $dataJnpp = json_encode([$detail[Narkotika::TYPE_METH]['total'], $detail[Narkotika::TYPE_COCAINE]['total'], $detail[Narkotika::TYPE_GANJA]['total'], $detail[Narkotika::TYPE_MDMA]['total'], $detail[Narkotika::TYPE_LAINNYA]['total']]);
    $colorJnpp = json_encode(['#ffc107', '#25B0FF', '#198754', '#dc3545', '#f8f9fa']);
    $labelJnpp = json_encode([$detail[Narkotika::TYPE_METH]['label'], $detail[Narkotika::TYPE_COCAINE]['label'], $detail[Narkotika::TYPE_GANJA]['label'], $detail[Narkotika::TYPE_MDMA]['label'], $detail[Narkotika::TYPE_LAINNYA]['label']]);
    $dtNko = round($nko);
    $path = Url::to(['site/get-detail-provinsi']);
    $selectedReg = json_encode($provinsi);
    $script = <<<JS
      window.processIndex({
       dataJnpp: $dataJnpp,
       colorJnpp: $colorJnpp,
       labelJnpp: $labelJnpp,
       dataCase: $jnpp,
       mapColor: $caseBulan,
       selectedReg: $selectedReg,
       tooltipsData:  $locations
    });
    JS;
    $this->registerJsFile(
        '@web/js/jquery.vmap.js',
        ['depends' => [\yii\web\JqueryAsset::class]]
    );
    $this->registerJsFile(
        '@web/js/jquery.vmap.indonesia-2.js',
        ['depends' => [\yii\web\JqueryAsset::class]]
    );
    $this->registerJsFile(
        '@web/js/index.js',
        ['depends' => [\yii\web\JqueryAsset::class]]
    );

    $this->registerJsFile(
        'https://cdn.jsdelivr.net/npm/@svgdotjs/svg.js@3.2.4/dist/svg.min.js',

    );

    $this->registerJs(file_get_contents(__DIR__ . '/_index.js'), \yii\web\View::POS_END);
    $this->registerJs($script, \yii\web\View::POS_END);
    ?>
