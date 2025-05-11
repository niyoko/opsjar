<?php

use backend\models\Bimtek;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Bimtek */
/* @var $form yii\widgets\ActiveForm */
use kartik\daterange\DateRangePicker;
?>

<style>
    .box-iku {
        box-sizing: border-box;
        /* Auto layout */

        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        padding: 10px 12px;
        gap: 10px;

        background: #FFFFFF;
        border: 2px solid rgba(63, 67, 92, 0.12);
        /* shadow 1 */

        box-shadow: 0px 3px 12px rgba(0, 0, 0, 0.12);
        border-radius: 10px 10px;
        margin-left: 20px;
        margin-top: 10px;
    }

    .square {
        /* Auto layout */

        align-items: center;
        text-align: center;
        padding: 0px;

        max-width: 20px;
        max-height: 20px;

        min-width: 14px;
        min-height: 14px;

        /* opsjar/merah */

        background: #FF3E3E;


    }

    .chartBox{
        max-width:200px;
        max-height: 250px;
        justify-content: center;
        margin-left: auto;
        margin-right: auto;
        align-items: center;
    }

    .chartBox-nko{
        max-width:500px;
        max-height: 500px;
        justify-content: center;
        margin-left: auto;
        margin-right: auto;
        align-items: center;
    }

    .chart-canvas-nko{
        max-width:400px;
        max-height: 400px;
    } 

    .chart-canvas{
        max-width:200px;
        max-height: 200px;
        min-width: 100px;
    } 
    .chart-title-sm{
        font-size: small;
        margin-bottom: 5px;
    }
</style>

<div class="capaian-form">
    <?= Yii::$app->session->getFlash('info'); ?>
    <h2 class="text-title m-3 font-bold">Capaian</h2>

    <div class="row">
        <div class="col-lg-6 col-md-9 col-sm-12">
            <div class="card card-warning shadow rounded ">
                <div class="card-body justify-content-center">
                    <div class="d-flex flex-row bd-highlight">
                        <div class="p-2 bd-highlight"><?= $this->render('@app/views/utilities/piala') ?></div>
                        <div class="p-2 bd-highlight"><span class="font-bold" style="font-size:20px ;"><?= $modelIku->getTotal() ?></span> <br> <span class="text-sm">Total IKU</span></div>
                        <div class="pl-2 bd-highlight">
                            <div class="d-flex pl-2">
                                <div class="box-iku">
                                    <span class="square"></span><span class="font-bold"><?= isset($modelIku->below) ? $modelIku->below : 0 ?> <span class="text-sm text-muted">IKU</span> </span>
                                </div>
                                <div class="box-iku">
                                    <span class="square oprjar-orange"></span><span class="font-bold"><?= isset($modelIku->meet) ? $modelIku->meet : 0 ?> <span class="text-sm text-muted">IKU</span> </span>
                                </div>
                                <div class="box-iku">
                                    <span class="square oprjar-hijau"></span><span class="font-bold"><?= isset($modelIku->exceed) ? $modelIku->exceed : 0 ?> <span class="text-sm text-muted">IKU</span> </span>
                                </div>
                                <div class="box-iku">
                                    <span class="square bg-secondary"></span><span class="font-bold"><?= isset($modelIku->grey) ? $modelIku->grey : 0 ?> <span class="text-sm text-muted">IKU</span> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-6">
            <div class="card card-warning shadow rounded ">
                <div class="card-body justify-content-center">
                    <h5 class="font-bold mt-1 mb-2">NILAI KERJA ORGANISASI (NKO)</h5>
                    <div class="row">
                        <div class="col-4 text-center">
                            <div class="mt-3 chartBox">
                                <span class="chart-title-sm font-bold">STAKEHOLDERS</span>
                                <canvas id="stakeholders" class="chart-canvas mt-2"></canvas>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="mt-3 chartBox">
                                <span class="chart-title-sm font-bold">INTERNAL BUSINESS PROCESS</span>
                                <canvas id="internal" class="chart-canvas mt-2"></canvas>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="mt-3 chartBox">
                                <span class="chart-title-sm font-bold">LEARNING & GROWTH</span>
                                <canvas id="learning" class="chart-canvas mt-2"></canvas>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-center" style="gap:30px ; margin-top:20px">
                                <div class="d-flex">
                                    <div class="p-2 bd-highlight"><?= $this->render('@app/views/utilities/piala-capaian-'. $nko_color) ?></div>
                                    <div class="text-xl p-2" style="vertical-align: middle ;"><span class="font-bold" style="font-size: 32px;margin-right:5px"><?= round($modelKinerja->nko,2) ?></span><span class="text-muted">NKO</span></div>
                                </div>
                                
                                <div class="p-2">
                                    <table width="100%" style="font-size: 12px;" class="text-muted">
                                        <tr>
                                            <td width="15px"><div style="height: 0; width:10px;padding-bottom:10px;background-color:green"></div></td>
                                            <td class="text-xs">100 &#8805; X  &#8804;   120 = memenuhi ekspetasi</td>
                                        </tr>
                                        <tr>
                                            <td width="15px"><div style="height: 0; width:10px;padding-bottom:10px;background-color:orange"></div></td>
                                            <td class="text-xs">80 &#8804; X  < 100 = belum memenuhi ekspetasi</td>
                                        </tr>
                                        <tr>
                                            <td width="15px"><div style="height: 0; width:10px;padding-bottom:10px;background-color:red"></div></td>
                                            <td class="text-xs">X < 80 = tidak memenuhi ekspetasi</td>
                                        </tr>
                                    </table>
                                </div>
                               
                            </div>
                            
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-warning shadow rounded ">
                <div class="card-body justify-content-center">
                    <h5 class="font-bold mt-1 mb-2">NILAI KERJA ORGANISASI (NKO)</h5>
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="mt-3 chartBox-nko">
                                <canvas id="nko" class="chart-canvas-nko"></canvas>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 justify-content-center">
            
        </div>
    </div>

</div>

<?php

$script = <<<JS

    const dataStakeHolders = [ Number("{$stakeHolders['value']}"), Number("{$stakeHolders['sisa']}")];
    const percentageStakeHolders = Number("{$stakeHolders['percentage']}");
    const colorStakeHolders = "{$stakeHolders['color']}";
    const drawChartStakeHolders = (datapoints, percentage) => {
        const bgc = [colorStakeHolders,'#252733'];
        const data = {
            labels: ['Value', ''],
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
                const yCenter = top + (height/1.8);
                ctx.textAlign = 'center';
                var fs = options.fontSize;
                if(width < 156){
                    fs = '18';
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
                        position:false
                    }
                },
                animation: {
                    duration: 2000,
                },

            },
            plugins : [counter],
            
        }

        const chartStakeHolders = new Chart(document.getElementById('stakeholders'), config);
    }

    drawChartStakeHolders(dataStakeHolders, percentageStakeHolders);


    const dataInternalBussiness = [ Number("{$internalBussiness['value']}"), Number("{$internalBussiness['sisa']}")];
    const percentageInternalBussiness = Number("{$internalBussiness['percentage']}");
    const colorInternalBussiness = "{$internalBussiness['color']}";
    const drawChartInternalBussiness = (datapoints, percentage) => {
        const bgc = [colorInternalBussiness,'#252733'];
        const data = {
            labels: ['Value', ''],
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
                const yCenter = top + (height/1.8);
                ctx.textAlign = 'center';
                var fs = options.fontSize;
                if(width < 156){
                    fs = '18';
                }
                ctx.font =  fs + 'px ' + options.fontFamily;
                ctx.fillText(percentage + "%", (width/2), yCenter)
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
                        position:false
                    }
                },
                animation: {
                    duration: 2000,
                },

            },
            plugins : [counter],
            
        }

        const chartInternalBussiness= new Chart(document.getElementById('internal'), config);
    }

    drawChartInternalBussiness(dataInternalBussiness, percentageInternalBussiness);

    const dataLearningGrowth = [ Number("{$learningGrowth['value']}"), Number("{$learningGrowth['sisa']}")];
    const percentageLearningGrowth = Number("{$learningGrowth['percentage']}");
    const colorLearningGrowth = "{$learningGrowth['color']}";
    const drawChartLearningGrowth = (datapoints, percentage) => {
        const bgc = [colorLearningGrowth,'#252733'];
        const data = {
            labels: ['Value', ''],
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
                const yCenter = top + (height/1.8);
                ctx.textAlign = 'center';
                var fs = options.fontSize;
                if(width < 156){
                    fs = '18';
                }
                ctx.font =  fs + 'px ' + options.fontFamily;
                ctx.fillText(percentage + "%", (width/2), yCenter)
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
                        fontSize : '40',
                        fontFamily: 'arial black'
                        
                    },
                    legend : {
                        position:false
                    }
                },
                animation: {
                    duration: 2000,
                },

            },
            plugins : [counter],
            
        }

        const chartLearningGrowth= new Chart(document.getElementById('learning'), config);
    }

    drawChartLearningGrowth(dataLearningGrowth, percentageLearningGrowth);

    const ctx = document.getElementById('nko');

    const toArrayMonth = (obj)  => {
        var res = [];
        for(var i in obj)
            res.push(parseInt(obj[i]));

        return res;
    }
    const bulan = JSON.parse('{$month}');
    const dataNko = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [{
            label: 'NKO',
            data: toArrayMonth(bulan),
            fill: false,
            borderColor: '#FBB03B',
            tension: 0.1,
            backgroundColor: '#FBB03B',
            pointRadius:5
        }]
    };
    const configNko = {
        type: 'line',
        data: dataNko,
        options:{plugins:{legend:false}}
    };
    
    const myChart = new Chart(ctx,configNko);
JS;

$this->registerJs($script,\yii\web\View::POS_END);
?>