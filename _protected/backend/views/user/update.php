<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

?>
<div class="user-update">

<div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Perbarui Password</h3>
        </div>
        <div class="card-body">
            <?= $this->render('_form_update', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
