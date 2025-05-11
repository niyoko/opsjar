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
    table tr td{
        padding-top: 8px;
        padding-right: 8px;
        padding-bottom: 8px;
    }
    table tr th{
        padding-left: 3px;
    }
</style>

<div class="capaian-form">
<?= Yii::$app->session->getFlash('info'); ?>
    <?php $form = ActiveForm::begin(['id' => 'update-form']); ?>
    <input type="hidden" value="true" name="submitted">
    <div class="card card-warning">
        
        <div class="card-body">
            <p>
                <h2 class="text-title">Capaian</h2>
                <div class="form-group">
                    <?= Html::submitButton('<i class="material-icons-round">save</i> Perbarui Data', ['class' => 'btn btn-outline-success']) ?>
                </div>
            </p>
            <p>
                <div class="row">
                    <div class="col-md-5 col-sm-12">
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h3 class="card-title">IKU</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table width="100%">
                                            <tr>
                                                <td width="40px"><div style="height: 0; width:25px;padding-bottom:25px;background-color:red"></div></td>
                                                <td><input type="text" name="CapaianIku[below]" class="form-control form-control-sm number-format" value="<?= $modelIku->below ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><div style="height: 0; width:25px;padding-bottom:25px;background-color:orange"></div></td>
                                                <td><input type="text" name="CapaianIku[meet]" class="form-control form-control-sm number-format" value="<?= $modelIku->meet ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><div style="height: 0; width:25px;padding-bottom:25px;background-color:green"></div></td>
                                                <td><input type="text" name="CapaianIku[exceed]" class="form-control form-control-sm number-format" value="<?= $modelIku->exceed ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><div style="height: 0; width:25px;padding-bottom:25px;background-color:grey"></div></td>
                                                <td><input type="text" name="CapaianIku[grey]" class="form-control form-control-sm number-format" value="<?= $modelIku->grey ?>" ></td>
                                            </tr>
                                        </table>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Nilai Kerja Organisasi</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table width="100%">
                                            <tr>
                                                <th colspan="2" class="text-sm">Perspektives</th>
                                                <th class="text-sm">Stakeholders</th>
                                            </tr>
                                            <tr>
                                                <td width="40px" class="text-center"><span class="fas fa-portrait fa-2x" ></span></td>
                                                <td width="60%">
                                                    <input type="text" name="CapaianKinerja[stakeholders_value]" class="form-control form-control-sm number-format" value="<?= $modelKinerja->stakeholders_value ?>">
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" name="CapaianKinerja[stakeholders_percentage]" class="form-control form-control-sm number-format " value="<?= $modelKinerja->stakeholders_percentage ?>">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text form-control-sm">%</span>
                                                            </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="2"></th>
                                                <th class="text-sm" colspan="">Internal Business Process</th>
                                            </tr>
                                            <tr>
                                                <td width="40px"><span class="fas fa-archive fa-2x"></span></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control form-control-sm number-format" name="CapaianKinerja[internal_business_process_value]" value="<?= $modelKinerja->internal_business_process_value ?>">
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm number-format" name="CapaianKinerja[internal_business_process_percentage]" value="<?= $modelKinerja->internal_business_process_percentage ?>">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text form-control-sm">%</span>
                                                            </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="2"></th>
                                                <th class="text-sm">Learning and Growth</th>
                                            </tr>
                                            <tr>
                                                <td width="40px"><span class="fas fa-bolt fa-2x"></span></td>
                                                <td width="60%">
                                                    <input type="text" class="form-control form-control-sm number-format" name="CapaianKinerja[learning_growth_value]" value="<?= $modelKinerja->learning_growth_value ?>">
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm number-format" name="CapaianKinerja[learning_growth_percentage]" value="<?= $modelKinerja->learning_growth_percentage ?>">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text form-control-sm">%</span>
                                                            </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <hr>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label for="nko-input text-sm">NKO</label>
                                                    <input id="nko-input" type="text" class="form-control form-control-sm number-format" name="CapaianKinerja[nko]" value="<?= $modelKinerja->nko ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-12">
                                                <label for="" class="text-sm">Keterangan</label>
                                                <table width="100%">
                                                    <tr>
                                                        <td width="15px"><div style="height: 0; width:10px;padding-bottom:10px;background-color:green"></div></td>
                                                        <td class="text-xs">100 &#8804; X  &#8805; 120 = memenuhi ekspetasi</td>
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
                    <div class="col-md-7 col-sm-12">
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Tren Nilai Kerja Organisasi</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php foreach (Bimtek::optionsBulan() as $key => $value):?>
                                        <div class="col-md-4 col-sm-12 ">
                                            <div class="form-group">
                                                <label for="bulan-<?= $key ?>"><?= $value ?></label>
                                                <input type="text" name="values[]" id="bulan-<?= $key ?>" class="form-control form-control-sm number-format" value="<?= isset($modelTren[$key]) ? $modelTren[$key] : 0 ?>">
                                                <input type="hidden" name="months[]" id="id-<?= $key ?>" class="form-control form-control-sm number-format" value="<?= $key ?>">
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </p>
        </div>
    </div>
    <?php
    
    ?>

    

    <?php ActiveForm::end(); ?>

</div>
