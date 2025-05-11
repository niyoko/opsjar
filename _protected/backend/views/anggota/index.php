<?php

use backend\models\Member;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Members';
$this->params['breadcrumbs'][] = $this->title;
$pageSize = $dataProvider->pagination->pageSize;
$totalPage = ceil($dataProvider->getTotalCount() / $pageSize);
$page  = $dataProvider->pagination->page;
?>


<div class="member-index shadow p-3 mb-5 bg-body rounded">
    <div class="row mb-3">
        <div class="col-md-8 col-sm-12">
            <h4 class="font-bold">DAFTAR ANGGOTA SUBDIREKTORAT OPERASI DAN PENGUNGKAPAN JARINGAN NARKOTIKA</h4>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <?php $form = ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'get',
                        'id' => 'search-form'
                    ]); ?>
                    <div class="row mb-3">
                        <label for="status-search" class="col-sm-12 col-lg-3 col-md-12 col-form-label col-form-label-sm form-label font-bold text-left mr-5">Tampilkan</label>
                        <div class="col-md-12 col-sm-12 col-lg-9">
                            <?= Html::dropDownList('status', $searchModel->status, Member::optionsStatus(), ['class' => 'form-select', 'id' => 'status-search', 'prompt' => 'Semua']); ?>
                        </div>
                    </div>
                    <div class="mb-3 form-group form-inline">
                        
                        
                    </div>
                    
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php Pjax::begin(); ?>
    <div class="row">
        <?php foreach ($dataProvider->getModels() as $d): ?>
        <?= $this->render('_item_member', [
                'model' => $d,
                'search' => null,
            ]); ?>
        <?php endforeach ?>
        <div class="col-md-12">
            <?php if($totalPage > 0): ?>
                <nav class="mt-5" aria-label="Pagination">
                    <ul class="pagination justify-content-left">
                        <li class="page-item <?= $dataProvider->pagination->page == 0 ? 'disabled' : '' ?>">
                            <a class="page-link" href="#" tabindex="-1"><</a>
                        </li>
                        <?php for ($i = 0 ; $i < $totalPage ; $i++) :?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link" href="/anggota/index?page=<?= ($i+1)?>&per-page=<?= $pageSize ?>"><?= ($i+1) ?></a></li>
                        <?php endfor ?>
                        <a class="page-link <?= ($page+1) ==  $totalPage ? 'disabled' : '' ?>" href="/anggota/index?page=<?= ($page+2)?>&per-page=<?= $pageSize ?>">></a>
                        </li>
                    </ul>
                </nav>
            <?php else : ?>
                <div style="min-height: 200px  ; vertical-align:middle !important; margin-left:5px" class="p-2"><i class="mt-5">Belum ada data anggota</i></div>
            <?php endif ?>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>



<?php
$script = <<<JS
 $('#status-search').on('change', function(){
    $('#search-form').submit();
 });
JS;
$this->registerJs($script,\yii\web\View::POS_END);
?>