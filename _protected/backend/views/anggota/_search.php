<?php

use backend\models\Member;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\MemberSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'search-form'
    ]); ?>

        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="input-group">
                    <input type="search" id="search-in" name="name" class="form-control form-control-md" placeholder="Cari Anggota">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-md btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-8">
                <div class="form-group form-inline">                            
                    <label for="status-search" class="mr-2 mt-1">Status</label>
                    <?= Html::dropDownList('status', $model->status, Member::optionsStatus(), ['class'=>'form form-control mr-2', 'id' => 'status-search' , 'prompt' => 'Semua']) ?>
                   
                </div>
            </div>
        </div>


    <?php ActiveForm::end(); ?>

</div>



<?php
$script = <<<JS
 $('#status-search').on('change', function(){
    $('#search-form').submit();
 });
JS;
$this->registerJs($script,\yii\web\View::POS_END);
?>