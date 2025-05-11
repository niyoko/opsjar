<?php

use backend\models\Anggaran;
use backend\models\Bimtek;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Bimtek */
/* @var $form yii\widgets\ActiveForm */
use kartik\daterange\DateRangePicker;
?>
<style>
    table tr td{
        padding-top: 8px;
        padding-right: 8px;
        padding-bottom: 8px;
    }
    table tr th{
        padding-left: 3px;
    }
    .chartBox{
        max-width:400px;
        max-height: 400px;
        justify-content: center;
        margin-left: auto;
        margin-right: auto;
    }

    .chartBox-bimtek{
        max-width:400px;
        max-height: 400px;
        justify-content: center;
        margin-left: auto;
        margin-right: auto;
    }

    .chartBox-bulan{
        max-width:700px;
        max-height:700px;
        justify-content: center !important;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
        margin-top: 30px;
    }
    .chart-canvas{
        max-width:400px;
        max-height: 400px;
        min-width: 100px;
    } 


</style>

<div class="bimtek-form">
    <?= Yii::$app->session->getFlash('info'); ?>
    <h2 class="text-title m-3 font-bold">Anggaran</h2>
    <input type="hidden" value="true" name="submitted">
    <div class="p-2">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card card-secondary shadow rounded pb-5">
                    <div class="card-body justify-content-center" > 
                        <h5 class="font-bold text-center">
                            DATA DAFTAR ISIAN PELAKSANAAN ANGGARAN (DIPA) SUBDIREKTORAT OPERASI DAN PENGUNGKAPAN JARINGAN NARKOTIKA TAHUN 2022
                        </h5>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-6 text-center" >
                                <div class="mt-3 chartBox ">
                                    <h5 class="text-md font-bold mt-5 mb-3">Operasional</h5>
                                    <canvas id="anggaranOperasi" class="chart-canvas"></canvas>
                                </div>
                            </div>
                            <div class=" col-md-6 col-sm-6 col-lg-6 text-center">
                                <div class="mt-3 chartBox">
                                        <h5 class="text-md font-bold mt-5 mb-3">Bimbingan Teknis</h5>
                                        <canvas id="anggaranBimtek" class="chart-canvas"></canvas>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 pb-5">
                <div class="card card-secondary shadow rounded pb-5">
                    <div class="card-body  justify-content-center">
                            <h5 class="font-bold text-center">
                                DATA DANA OPERASIONAL KHUSUS PENGAMANAN PENERIMAAN (DOKPPN) SUBDIREKTORAT OPERASI DAN PENGUNGKAPAN JARINGAN NARKOTIKA TAHUN 2022
                            </h5>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-lg-12 text-center" >
                                    <div class="chartBox-bulan">
                                        <canvas id="anggaranBulan" class="chart-canvas-bulan" ></canvas>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    
    ?>

    

   

</div>

<?php

$script = <<<JS
    //setup block
    const toArrayMonth = (obj)  => {
        var res = [];
        for(var i in obj)
            res.push(parseInt(obj[i]));

        return res;
    }
    
    const datapointsBimtek = [ Number("{$bimtek['penggunaan']}"), Number("{$bimtek['anggaran']}")];
    const percentageBimtek = Number("{$bimtek['percentage']}");

    const datapointsOperasional = [ Number("{$operasional['penggunaan']}"), Number("{$operasional['anggaran']}")];
    const percentageOperasional = Number("{$operasional['percentage']}");
    const bulan = JSON.parse('{$month}');
    const dataAnggaranBulanan = toArrayMonth(bulan.anggaran);
    const dataPenggunaanBulanan = toArrayMonth(bulan.penggunaan);
    console.log(dataPenggunaanBulanan); 
    
    const drawChartOps = (datapoints, percentage) => {
        const bgc = ['#FBB03B','#252733'];
        const data = {
            labels: ['Penggunaan', 'Sisa Anggaran'],
                datasets: [{
                    data: datapoints,
                    backgroundColor: bgc,
                    borderColor: [
                        'transparent',
                        'transparent',
                    ],
                    borderWidth: 1,
                    cutout: '70%',
                    borderRadius:2
                }]
        };
        const counter = {
            id: 'counter',
            beforeDraw( chart, args, options ){
                const { ctx, chartArea: { top , right, bottom, left, width, height} } = chart;
                ctx.save();
                ctx.fillStyle = options.fontColor;
                const yCenter = top + (height/2);
                ctx.textAlign = 'center';
                var fs = options.fontSize;
                if(width < 206){
                    fs = '25';
                }
                ctx.font =  fs + 'px ' + options.fontFamily;
                ctx.fillText(percentage + "%", width/2, yCenter)
                //x0 starting point on the horizontal level l/r
                //yo starting point on the vertical level t/b
                //x1 length of the shape in pixel
                //y1 length of the shape in pixel vertical level
            }
        };

        const config = {
            type: 'doughnut',
            data,
            options: {
                plugins:{
                    counter:{
                        fontColor:'black',
                        fontSize : '45',
                        fontFamily: 'arial black'
                        
                    },
                    legend : {
                        position:'bottom'
                    }
                },
                animation: {
                    duration: 2000,
                },

            },
            plugins : [counter],
            
        }

        const ChartOperasional = new Chart(document.getElementById('anggaranOperasi'), config);
    }
    

    const drawChartBimtek = (datapoints, percentageBimtek) => {
        const bgc = ['#FBB03B','#252733'];
        const data = {
            labels: ['Penggunaan', 'Sisa Anggaran'],
                datasets: [{
                    data: datapoints,
                    backgroundColor: bgc,
                    borderColor: [
                        'transparent',
                        'transparent',
                    ],
                    borderWidth: 1,
                    cutout: '70%',
                    borderRadius:2
                }]
        };
        const counter = {
            id: 'counter',
            beforeDraw( chart, args, options ){
                const { ctx, chartArea: { top , right, bottom, left, width, height} } = chart;
                ctx.save();
                ctx.fillStyle = options.fontColor;
                const yCenter = top + (height/2);
                ctx.textAlign = 'center';
                fs = options.fontSize;
                if(width < 206){
                    fs = '25';
                }
                ctx.font =  fs + 'px ' + options.fontFamily;
                ctx.fillText(percentageBimtek + "%", width/2, yCenter)
                //x0 starting point on the horizontal level l/r
                //yo starting point on the vertical level t/b
                //x1 length of the shape in pixel
                //y1 length of the shape in pixel vertical level
            }
        };

        const config = {
            type: 'doughnut',
            data,
            options: {
                plugins:{
                    counter:{
                        fontColor:'black',
                        fontSize : '45',
                        fontFamily: 'arial black'
                        
                    },
                    legend : {
                        position:'bottom'
                    }
                },
                animation: {
                    duration: 2000,
                },
            },
            plugins : [counter]
        }

        const ChartOperasional = new Chart(document.getElementById('anggaranBimtek'), config);
    }


    
    const drawMonth = (dataAnggaranBulanan, dataPenggunaanBulanan) => {
        var ctx = document.getElementById("anggaranBulan").getContext("2d");

        var data = {
        labels: ["Januari", "Febuari", "Maret", 'April', "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        datasets: [
        {
            label: "Anggaran",
            backgroundColor: "#252733",
            data: dataAnggaranBulanan,
            borderWidth: 2,
            borderRadius: 5,
        },
        {
            label: "Penggunaan",
            backgroundColor: "#FBB03B",
            data: dataPenggunaanBulanan,
            borderWidth: 2,
            borderRadius: 5,
        }
        ]
        };

        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                },
                animation: {
                    duration: 2000,
                },
            }
        });
    }

    $( document ).ready(function() {
        drawChartOps(datapointsOperasional, percentageOperasional);
        drawChartBimtek(datapointsBimtek, percentageBimtek);
        drawMonth(dataAnggaranBulanan, dataPenggunaanBulanan);
    });
 
    //plugin

    


    const counterBimtek = {
        id: 'counterBimtek',
        beforeDraw( chart, args, options ){
            const { ctx, chartArea: { top , right, bottom, left, width, height} } = chart;
            ctx.save();
            ctx.fillStyle = options.fontColor;
            const yCenter = top + (height/2);
            ctx.textAlign = 'center';
            ctx.font = options.fontSize + 'px ' + options.fontFamily;
            ctx.fillText(datapoints[0] + "%", width/2, yCenter)
            //x0 starting point on the horizontal level l/r
            //yo starting point on the vertical level t/b
            //x1 length of the shape in pixel
            //y1 length of the shape in pixel vertical level
        }
    };

JS;
$this->registerJs($script,\yii\web\View::POS_END);
?>