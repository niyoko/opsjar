<?php

use backend\models\Kantor;
use backend\models\Member;
use backend\models\Provinsi;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Member */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Nama') ?>

    <?= $form->field($model, 'id_provinsi')->dropDownList(Provinsi::getOptions(), ['prompt' => 'Pilih Lokasi', 'class' => 'select2 form-control'])->label('Lokasi') ?>
    <?= $form->field($model, 'location')->textInput(['maxlength' => true])->label('Deskripsi') ?>
    <div><label>Foto</label></div>
    <div>
        <?= $form->field($model, 'file')->fileInput(['accept' => 'image/*', 'onchange' => 'previewFile(event)'])->label(false) ?>
        <img id="output" width="100px" height="100px" class="" src="/<?= $model->getPhotoUrl() ?>"/>
    </div>
    

    <?= $form->field($model, 'created_by')->hiddenInput(['maxlength' => true, 'value' => Yii::$app->user->identity->username])->label(false); ?>

    <?= $form->field($model, 'status')->dropDownList(Member::optionsStatus()) ?>

    <div class="row">
            <div class="col-md-12 text-right">
                <div class="form-group text-end">
                <?= Html::a('Batalkan','/anggota', ['class' => 'btn btn-secondary mr-1']) ?>
                <?= Html::submitButton('<i class="material-icons-round">save</i> Simpan', ['class' => 'btn btn-success']) ?>
                

            </div>
        </div>
    </div>
    

    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<<JS
 function previewFile(input){
        var file = $("input[type=file]").get(0).files[0];
 
        if(file){
            var reader = new FileReader();
 
            reader.onload = function(){
                $("#output").attr("src", reader.result);
            }
 
            reader.readAsDataURL(file);
        }
    }

JS;
$this->registerJs($script,\yii\web\View::POS_END);
?>