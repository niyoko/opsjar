<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CapaianKinerja */
/* @var $form ActiveForm */
?>
<div class="capaian">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'stakeholders_value') ?>
        <?= $form->field($model, 'stakeholders_percentage') ?>
        <?= $form->field($model, 'internal_business_process_value') ?>
        <?= $form->field($model, 'internal_business_process_percentage') ?>
        <?= $form->field($model, 'learning_growth_value') ?>
        <?= $form->field($model, 'learning_growth_percentage') ?>
        <?= $form->field($model, 'nko') ?>
        <?= $form->field($model, 'tahun') ?>
        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'created_at') ?>
        <?= $form->field($model, 'updated_at') ?>
        <?= $form->field($model, 'created_by') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- capaian -->
