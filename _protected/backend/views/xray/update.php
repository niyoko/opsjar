<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Xray */
?>
<div class="xray-update">

<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">Ubah Data Xray</h3>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>

</div>
