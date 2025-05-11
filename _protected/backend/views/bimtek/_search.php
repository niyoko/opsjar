<?php

use backend\models\Bimtek;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\BimtekSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bimtek-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'search-form'
    ]); ?>


    <?php // $form->field($model, 'name') ?>


    <?php // $form->field($model, 'date_start') ?>
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="input-group">
                    <input type="search" id="search-in" name="name" class="form-control form-control-md" placeholder="Cari Kegiatan" value="<?= $model->name ?>">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-md btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-8">
                <div class="form-group form-inline ">                            
                    <label for="bulan-search" class="mr-2">Bulan</label>
                    <?= Html::dropDownList('bulan', $model->bulan, Bimtek::optionsBulan(), ['class'=>'form form-control mr-2', 'id' => 'bulan-search' , 'prompt' => 'Semua']) ?>
                    <label for="tahun-search" class="mr-2">Tahun</label>
                    <?= Html::dropDownList('tahun', $model->tahun, Bimtek::optionsTahun(), ['class'=>'form form-control mr-2', 'id' => 'tahun-search' ]) ?>
                </div>
            </div>
        </div>

    <?php // echo $form->field($model, 'tahun') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<<JS
 $('#bulan-search').on('change', function(){
    $('#search-form').submit();
 });
 $('#tahun-search').on('change', function(){
    $('#search-form').submit();
 });
JS;
$this->registerJs($script,\yii\web\View::POS_END);
?>