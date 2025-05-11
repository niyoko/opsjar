<?php

use backend\models\Provinsi;
use backend\models\Tahun;
use yii\bootstrap5\BootstrapAsset;
use yii\helpers\Html;
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
    body{
    height: 100%;
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
</style>
<div class="provinsi-map shadow-sm p-3 mb-5 bg-body rounded">
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="row form-group">
                        <div class="text-center mt-3">
                            <div class="text-muted mb-1 col-md-12 text-sm text-muted">Menampilkan Data</div>
                            <?= Html::dropDownList('provinsi','',Provinsi::getOptionsMap(), ['class' => 'form-select form-select-sm d-inline-flex col-md-12', 'id' => 'provinsi', 'aria-label' => 'Provinsi', 'prompt' => 'Seluruh Indonesia']) ?>
                        </div>
                    </div>    
                    <div class="form-group row mt-3 mb-3">
                            <label for="tahun" class="col-sm-3 col-form-label text-center text-sm text-muted">Tahun</label>
                        <div class="col-sm-9">
                            <?= Html::dropDownList('tahun','',Tahun::optionsDropdown(), ['class' => 'form-select form-select-sm d-inline-flex', 'id' => 'tahun', 'aria-label' => 'Provinsi']) ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12 col-sm-4 mt-3">
                    <div class="row summary-lg" >
                        <div class="col-md-12 col-sm-4">
                            <div class="text-center">
                                <img src="/images/plane.svg" class="filter-green icon m-1"/><span class="font-bold"> Kasus Udara</span>
                                <div class="d-flex justify-content-center mt-1">
                                    <table>
                                        <tr>
                                            <td style="vertical-align: middle ;"><h1 class="text-danger">12</h1></td>
                                            <td style="vertical-align: middle ;" class="p-1"><small>Kasus</small></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="text-center">
                                <img src="/images/ship.svg" class="filter-green icon m-1"/><span class="font-bold"> Kasus Laut</span>
                                <div class="d-flex justify-content-center mt-1">
                                    <table>
                                        <tr>
                                            <td style="vertical-align: middle ;"><h1 class="text-primary">8</h1></td>
                                            <td style="vertical-align: middle ;" class="p-1"><small>Kasus</small></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="text-center">
                                <img src="/images/truck.svg" class="filter-green icon m-1"/><span class="font-bold"> Kasus Darat</span>
                                <div class="d-flex justify-content-center mt-1">
                                    <table>
                                        <tr>
                                            <td style="vertical-align: middle ;"><h1 class="text-success">4</h1></td>
                                            <td style="vertical-align: middle ;" class="p-1"><small>Kasus</small></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div></div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-md-9 col-sm-12">
            <div class="map-container p-0" style="max-width:100%; max-height: 100%; min-height:auto;">
                <div id="map-body"><div id="vmap" ></div>
            </div>
            <div id="keterangan"></div>
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <canvas id="myChart" style="max-width: 100%; max-height:200px"></canvas>
                </div>
                <div class="col-md-4 col-sm-12">
                    <canvas id="myChart2" style="max-width: 100%; max-height:200px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12 m-0 p-0">
            <div class="row summary-sm mt-5" >
                <div class="col-md-12 col-sm-4">
                    <div class="text-center">
                        <img src="/images/plane.svg" class="filter-green icon m-1"/><span class="font-bold"> Kasus Udara</span>
                        <div class="d-flex justify-content-center mt-1">
                            <table>
                                <tr>
                                    <td style="vertical-align: middle ;"><h1 class="text-danger">12</h1></td>
                                    <td style="vertical-align: middle ;" class="p-1"><small>Kasus</small></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="col-md-12 col-sm-4">
                    <div class="text-center">
                        <img src="/images/ship.svg" class="filter-green icon m-1"/><span class="font-bold"> Kasus Laut</span>
                        <div class="d-flex justify-content-center mt-1">
                            <table>
                                <tr>
                                    <td style="vertical-align: middle ;"><h1 class="text-primary">8</h1></td>
                                    <td style="vertical-align: middle ;" class="p-1"><small>Kasus</small></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="col-md-12 col-sm-4">
                    <div class="text-center">
                        <img src="/images/truck.svg" class="filter-green icon m-1"/><span class="font-bold"> Kasus Darat</span>
                        <div class="d-flex justify-content-center mt-1">
                            <table>
                                <tr>
                                    <td style="vertical-align: middle ;"><h1 class="text-success">4</h1></td>
                                    <td style="vertical-align: middle ;" class="p-1"><small>Kasus</small></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
$script = <<<JS

    jQuery(document).ready(function () {
        drawMap();
    
        $('#provinsi').on('change', function(){
            $('#vmap').remove();
            $('#map-body').html('<div id="vmap""></div>');
            drawMap($(this).val());
            $('#keterangan').html();
            if($(this).val()){
            $('#keterangan').html("Data Provinsi "+$(this).children("option:selected").text()+" " )
            }
            else{
            $('#keterangan').html("Data Seluruh Indonesia ")
            }
        
        });

        $(window).on("resize", sizeMap);

    });

    const sizeMap = () => {
        var containerWidth = $('.map-container').width(),
            containerHeight = (containerWidth / 2.4);

        $('#vmap').css({
            'width': containerWidth,
            'height': containerHeight
        });
    }

    
    const drawMap = (selectedRegions = null) => {
        sizeMap();
        jQuery('#vmap').vectorMap({
            map: 'indonesia_id',
            enableZoom: false,
            showTooltip: true,
            selectedColor: '#d8a854',
            scaleColors: ['#b6d6ff', '#005ace'],
            color: "#c3d3e3",
            selectedRegions: selectedRegions,
            hoverOpacity: null,
            borderColor: '#818181',
            borderOpacity: 0.25,
            borderWidth: 1,
            hoverColor: '#d8a854',
            backgroundColor: "#FFFFFF",
            pins: { "pk" : "\u003cimg src=\"images/no-pict.png\" /\u003e"},
            onRegionClick: function(event, code, region){
            $('#provinsi').val(code);
            $('#keterangan').html("Data Provinsi "+region+" "+code )
            }
        });
    }

    const ctx = document.getElementById('myChart');
    const ctx2 = document.getElementById('myChart2');
    const ctx3 = document.getElementById('myChart3');

    var dataFirst = {
        label: "METH",
        data: [0, 59, 75, 20],
        lineTension: 0,
        fill: false,
        borderColor: 'red'
    };

    var dataSecond = {
        label: "GANJA",
        data: [20, 15, 60, 60],
        lineTension: 0,
        fill: false,
    borderColor: 'blue'
    };

    var data3 = {
        label: "COCAINE",
        data: [11, 14, 17, 50],
        lineTension: 0,
        fill: false,
    borderColor: 'green'
    };

    var datalainnya = {
        label: "Lainnya",
        data: [13, 14, 7, 30],
        lineTension: 0,
        fill: false,
    borderColor: 'yellow'
    };

    var dataChart = {
    labels: ['2019', '2020', '2021', '2022'],
    datasets: [dataFirst, dataSecond, data3,datalainnya]
    };

    var chartOptions = {
    legend: {
        display: true,
        position: 'top',
        labels: {
        boxWidth: 80,
        fontColor: 'black'
        }
    }
    };
    const myChart = new Chart(ctx, {
        type: 'line',
        data: dataChart,
        layout:{
            autoPadding:true,
        },
        options: {
            animations: {
                tension: {
                    duration: 1000,
                    easing: 'easeInSine',
                    from: 1,
                    to: 0,
                }
            },
            plugins: {
                title: {
                    display: false,
                    text: 'Jenis Narkotika'
                },
                legend:{
                    display:true,
                    position:'right'
                }
            }
        }
    });


    
    const data2 = {
        labels: [
            'METH',
            'GANJA',
            'COCAINE',
            'LAINNYA'
        ],
        datasets: [{
            label: 'My First Dataset',
            data: [300, 50, 100, 30],
            backgroundColor: [
            'red',
            'blue',
            'green',
            'yellow'
            ],
            hoverOffset: 4
        }]
    };

    const myChart2 = new Chart(ctx2, {
        type: 'doughnut',
        data: data2,
        options: {
            animations: {
                tension: {
                    duration: 1000,
                    easing: 'easeInSine',
                    from: 1,
                    to: 0,
                }
            }
        }
    });
    
JS;
$this->registerJsFile(
    '@web/js/jquery.vmap.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
$this->registerJsFile(
    '@web/js/jquery.vmap.indonesia.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
$this->registerJs($script,\yii\web\View::POS_END);
?>