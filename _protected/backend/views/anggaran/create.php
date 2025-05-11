<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Anggaran */

$this->title = 'Create Anggaran';
$this->params['breadcrumbs'][] = ['label' => 'Anggarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anggaran-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
