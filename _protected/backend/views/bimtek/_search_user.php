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
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="d-flex">
                    <input class="form-control me-2" type="search" name="name" placeholder="Cari Kegiatan" aria-label="Search">
                    <a type="button" class="btn-submit btn" style="font-size:30px" style="vertical-align: middle !important ;">
                        <span class="material-icons-outlined text-md">search</span>
                    </a>
                </div>
               
            </div>
            <div class="col-md-8 col-sm-12 ">
                <div class="d-flex flex-row-center bd-highlight">
                    <div class="p-2 d-flex">
                        <label for="tahun-search" class="font-bold me-2">Tahun</label>
                        <?= Html::dropDownList('tahun', $model->tahun, Bimtek::optionsTahun(), ['class'=>'form-select form-select-sm select mr-2', 'id' => 'tahun-search' ]) ?>
                    </div>
                    <div class="p-2 d-flex">
                        <label for="bulan-search" class="font-bold me-2">Bulan</label>
                        <?= Html::dropDownList('bulan', $model->bulan, Bimtek::optionsBulan(), ['class'=>'select form-select form-select-sm mr-2', 'id' => 'bulan-search' , 'prompt' => 'Semua']) ?>
                    </div>
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
 $('.btn-submit').on('click', function(){
    $('#search-form').submit();
 });
JS;
$this->registerJs($script,\yii\web\View::POS_END);
?>