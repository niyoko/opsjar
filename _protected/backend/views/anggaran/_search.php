<?php

use backend\models\Bimtek;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\AnggaranSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="anggaran-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'search-form'
    ]); ?>

    <div class="form-group form-inline ">                            
        <span for="tahun-search" class="mr-2 font-bold">Tahun</span>
        <?= Html::dropDownList('tahun', $tahun , Bimtek::optionsTahun(), ['class'=>'form form-control mr-2', 'id' => 'tahun-search' ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php
$script = <<<JS
 $('#tahun-search').on('change', function(){
    $('#search-form').submit();
 });
JS;
$this->registerJs($script,\yii\web\View::POS_END);
?>