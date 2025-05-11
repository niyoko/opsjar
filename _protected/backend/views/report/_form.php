<?php

use backend\models\Kantor;
use backend\models\Provinsi;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\report */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group field-report-udara has-success">
                <label class="control-label" for="report-udara">Tanggal Laporan <span class="text-danger">*</span></label>
                <?= DateRangePicker::widget([
                    'model'=>$model,
                    'attribute'=>'date',
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'locale'=>['format'=>'Y-m-d'],
                        'singleDatePicker'=>true,
                    ]
                ]); ?>

                <div class="help-block"></div>
            </div>            
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'id_office')->dropDownList(Kantor::optionsAll(true), ['prompt' => 'Pilih Lokasi', 'class' => 'select2 form-control'])->label('Lokasi Barang Bukti <span class="text-danger">*</span>') ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?= $form->field($model, 'udara')->textInput(['maxlength' => true])->label('Kasus Udara') ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'laut')->textInput(['maxlength' => true])->label('Kasus Laut') ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'darat')->textInput(['maxlength' => true])->label('Kasus Darat') ?>
        </div>
    </div>
    
    <div class="row">
        <?php foreach ($narkotika as $key => $value) : ?>
            <?php $defaultVal = isset($modelDetail[$key]) ? round($modelDetail[$key]) :0; ?>
            <div class="col">
                <?= Html::input('hidden', 'jenis[]',$key,['class' => 'form-control']) ?>
                <label class="control-label" for="report-udara"><?= $value ?></label>
                <div class="input-group mb-3">
                    <?= Html::input('text', 'narkotika[]',$defaultVal,['class' => 'form-control number-format narkotika']) ?>
                    <div class="input-group-append">
                        <span class="input-group-text">gr</span>
                    </div>
                </div>
                
            </div>
        <?php endforeach ?>
    </div>

    <div class="row">
        <div class="col-md-12 p-2">
            <span class="text-md font-bold"> Total Tangkapan <span class="total-tangkapan ml-3"><?= $model->getTotalgr(false); ?></span> gr </span> 
            <?= Html::input('hidden', 'Report[total]',0,['id' => 'report-total']); ?>
        </div>
    </div>
        
    
    <div class="row mt-3 mb-3">
        <div class="col-md-6">
            <?= $form->field($model, 'nomor_surat')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'surat_tugas')->textInput() ?>
        </div>
    </div>
    <div class="row mt-3 mb-3">
        <div class="col-md-12">
            <?= $form->field($model, 'laporan')->textInput() ?>
        </div>
    </div>

    <div class="form-group text-right">
        <?= Html::a('Batalkan','/report', ['class' => 'btn btn-secondary mr-1']) ?>
        <?= Html::submitButton('<i class="material-icons-round">save</i> Simpan', ['class' => 'btn btn-success']) ?>
       
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<<JS

 $('.narkotika').on('change', function(){
    let total = 0;
    coutTotal(total);
 });

 const coutTotal =  (total) => {
    $('.narkotika').each(function(i, obj) {
        if(obj.value){
            total = total + parseInt(obj.value.replace('.', ''));
        }   
        
    });
    $('#report-total').val(total);
    $('.total-tangkapan').html(total.toLocaleString('IN'));
 }

JS;
$this->registerJs($script,\yii\web\View::POS_END);
?>