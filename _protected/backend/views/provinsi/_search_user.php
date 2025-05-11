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
        'id' => 'search-form'
    ]); ?>

    <div class="row mt-3">
        <div class="col-md-4 col-sm-4">
            <div class="d-flex">
                <input class="form-control me-2" type="search" aria-label="Search" type="search" id="provinsisearch-name" name="ProvinsiSearch[name]" class="form-control me-2" placeholder="Cari Provinsi" value="<?= $model->name ?>">
                <a type="button" class="btn-submit" style="font-size:30px">
                    <span class="material-icons-outlined text-md">search</span>
                </a>
            </div>
        </div>
    </div>
    <?php // echo $form->field($model, 'status') ?>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<<JS
 $('.btn-submit').on('click', function(){
    $('#search-form').submit();
 });
JS;
$this->registerJs($script,\yii\web\View::POS_END);
?>