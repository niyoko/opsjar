<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Member */

?>
<div class="member-create">

    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Buat Anggota</h3>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>

