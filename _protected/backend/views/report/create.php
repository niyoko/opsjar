<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\report */

?>
<div class="report-create">

    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Tambah Data Baru</h3>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'narkotika' => $narkotika
            ]) ?>
        </div>
    </div>

</div>
