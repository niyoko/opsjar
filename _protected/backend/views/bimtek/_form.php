<?php

use backend\models\Bimtek;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Bimtek */
/* @var $form yii\widgets\ActiveForm */
use kartik\daterange\DateRangePicker;
?>

<div class="bimtek-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Nama Kegiatan') ?>

    <?= $form->field($model, 'status')->dropDownList(Bimtek::optionsStatus())->label('Status Kegiatan') ?>
    <div class="form-group field-bimtek-date_start has-success">
        <label class="control-label" for="bimtek-date_start">Tanggal Pelaksanaan</label>
        <?php 
            echo DateRangePicker::widget([
                'model'=>$model,
                'attribute'=>'date_start',
                'convertFormat'=>true,
                'readonly' => true,
                'pluginOptions'=>[
                    'locale'=>['format'=>'Y-m-d']
                ]
            ]);
        ?>

        <div class="help-block"></div>
    </div>
    <?php
    
    ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'nomor_surat')->textInput()->label('Nomor Surat') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'surat_tugas')->textInput()->label('Surat Tugas')->hint('<span class="text-sm">Link WD Drive</span>') ?>
        </div>
    </div>

    <?= $form->field($model, 'report')->textInput()->label('Laporan')->hint('<span class="text-sm">Link WD Drive</span>') ?>

    <div class="form-group text-right">
        <?= Html::a('Batalkan','/bimtek', ['class' => 'btn btn-secondary mr-1']) ?>
        <?= Html::submitButton('<i class="material-icons-round">save</i> Simpan', ['class' => 'btn btn-success']) ?>
       
    </div>

    <?php ActiveForm::end(); ?>

</div>


