<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Kantor */

$this->title = 'Create Kantor';
$this->params['breadcrumbs'][] = ['label' => 'Kantors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kantor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
