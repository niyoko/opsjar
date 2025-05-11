<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\report */

$this->title = 'Update Report: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="report-update">
    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Update Data</h3>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'narkotika' => $narkotika,
                'modelDetail' => $modelDetail
            ]) ?>
        </div>
    </div>
</div>
