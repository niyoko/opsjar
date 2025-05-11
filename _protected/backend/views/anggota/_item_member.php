<?php

use yii\helpers\Url;
use backend\models\OrderAssigned;
use common\components\Roles;
use common\models\SalesActivity;
use yii\bootstrap5\Html;

/* @var $this common\components\View */
?>
<style>
    .circle {
        width: 50px;
        height: 50px;
        border-radius: 100%;
        font-size: 18px;
        color: #0097c7;
        line-height: 50px;
        text-align: center;
        background: #c3e6f1;
        padding: 0;
    }

    .title {
        /* font-size: 18px; */
        font-size: 1.3rem;
        font-weight: 600;
        font-style: normal;
        font-stretch: normal;

    }

    .dot {
        height: 10px;
        width: 10px;
        background-color: green;
        border-radius: 50%;
        display: inline-block;
    }

    .dot-secondary {
        height: 10px;
        width: 10px;
        background-color: grey;
        border-radius: 50%;
        display: inline-block;
    }

    .dot-warning {
        height: 10px;
        width: 10px;
        background-color: orange;
        border-radius: 50%;
        display: inline-block;
    }

    .btn {
        min-width: 90px;
        text-align: center;
    }

    .shipper-leads-view {
        font-size: 14px;
    }
</style>

<div class="col-lg-3 col-md-4 col-sm-6 p-2">
    <div class="card m-0" style="max-width:400px">
        <div class="card-body">
            <table>
                <td width="30%" class="p-0" >
                    <img width="80px" height="80px" class="rounded-circle" src="/<?= $model->getPhotoUrl() ?>" alt="<?= $model->name ?>">
                </td>
                <td style="padding-left: 15px;">
                    <h6 class="card-title"><?= $model->name ?></h6>
                    <div class="card-text"><small class="text-muted"><?= $model->location ?  $model->location : ''?></small></div>
                    <div class="card-text"> <?= $model->getStatusLabel() ?> </div>
                    
                </td>
            </table>
           
        </div>
    </div>       
</div>
<!-- begin handle clickable card row -->
<?php
$script = <<<JS
$('.invoice-item.clickable').click(function(e){
    let id = $(this).data('id');
    let url = $(this).data('url');
    if(url!=='' && url!==null){
        window.location.href = url;
    }
});
JS;
//$this->registerJs($script,\yii\web\View::POS_END);
?>
<!-- end handle clickable card row -->
