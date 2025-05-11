<?php

use common\components\Roles;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ProvinsiSearch */
/* @var $form yii\widgets\ActiveForm */
$action = Yii::$app->user->identity->role == Roles::ROLE_USER ? 'view' : 'index'
?>

<div class="provinsi-search">

    <?php $form = ActiveForm::begin([
        'action' => [$action],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-3 col-sm-4">
            <div class="input-group">
                <input type="search" id="provinsisearch-name" name="ProvinsiSearch[name]" class="form-control form-control-md" placeholder="Cari Provinsi" value="<?= $model->name ?>">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-md btn-default">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php // echo $form->field($model, 'status') ?>

    <?php ActiveForm::end(); ?>

</div>
