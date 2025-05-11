<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\KantorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kantor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'search-form'
    ]); ?>

    <div class="row">
        <div class="col-md-3 col-sm-4">
            <div class="input-group">
                <input type="search" id="search-in" name="name" class="form-control form-control-md" placeholder="Cari Kantor" value="<?= $model->name ?>">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-md btn-default">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
