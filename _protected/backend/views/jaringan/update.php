<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Jaringan */

?>
<div class="jaringan-update">

<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">Update Peta Jaringan</h3>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>


</div>
