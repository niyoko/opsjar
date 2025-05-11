<?php

use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Jaringan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jaringan-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Nama Jaringan') ?>
        </div>
        <div class="col-md-6">
            <label class="control-label" for="report-udara">Diperbarui Pada<span class="text-danger"></span></label>
                <?= DateRangePicker::widget([
                    'model'=>$model,
                    'attribute'=>'created_at',
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'locale'=>['format'=>'Y-m-d'],
                        'singleDatePicker'=>true,
                        'startDate' => date('Y-m-d')
                    ]
                ]); ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'dokumen')->textInput()->label('Link Dokumen') ?>
        </div>
    </div>
   

    <div class="form-group text-right">
        <?= Html::a('Batalkan','/jaringan', ['class' => 'btn btn-secondary mr-1']) ?>
        <?= Html::submitButton('<i class="material-icons-round">save</i> Simpan', ['class' => 'btn btn-success']) ?>
       
    </div>

    <?php ActiveForm::end(); ?>

</div>
