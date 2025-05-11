<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Kantor */

$this->title = 'Update Kantor: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Kantors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kantor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
