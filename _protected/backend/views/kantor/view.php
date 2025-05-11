<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Kantor */

$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>
<div class="kantor-view">
    <h4><?= $model->name ?></h4>
    <p>
       
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label' => 'Kantor','value' => $model->name],
            ['label' => 'Nama Pendek', 'value' => $model->shortname],
            ['label' => 'Provinsi','value' => $model->provinsi->name],
        ],
    ]) ?>

    <a href="/kantor" class="btn btn-outline-secondary">Kembali</a> <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

</div>
