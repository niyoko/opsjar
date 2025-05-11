<?php

use backend\models\Bimtek;
use backend\models\Provinsi;
use common\components\Roles;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProvinsiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$action = Yii::$app->user->identity->role == Roles::ROLE_USER ? 'view' : 'index';
?>

<style>
    .tab-active{
        border-bottom: 2px solid orange;
        color: black !important;
    }
    .nav-link{
        text-decoration: none;
        color: grey;
    }
    .nav-link:hover{
        color: black;
    }

    
</style>

<div class="provinsi-index">
    <?= Yii::$app->session->getFlash('info'); ?>
    <div class="card card-secondary">
        <div class="card-body">
            <p>
            <?php $form = ActiveForm::begin([
                'action' => [$action],
                'method' => 'get',
                'id' => 'search-form'
            ]); ?>
               <div class="row">
                    <div class="col-md-12"> 
                        <div class="d-flex bd-highlight">
                            <div class="flex-grow-1"> <h2 class="text-title">Peta Jaringan</h2></div>
                            <div class="bd-highlight">
                                <div class="input-group" style="max-width:300px ;">
                                    <input type="search" id="provinsisearch-name" name="JaringanSearch[name]" class="form-control form-control-md" placeholder="Cari" value="<?= $searchModel->name ?>">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-md btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
               </div> 
               <div class="row inline-block-row">
                    <div class="col-md-12"> 
                        <div class="d-flex bd-highlight">
                            <div class="flex-grow-1">

                            <ul class="nav">
                                <li class="nav-item pt-3">
                                    <a class="nav-link" aria-current="page" href="/provinsi">Peta Kerawanan</a>
                                </li>
                                <li class="nav-item pt-3">
                                    <a class="nav-link tab-active" href="/jaringan">Peta Jaringan</a>
                                </li>
                                <li class="nav-item pt-3">
                                    <a class="nav-link" href="/xray">Buletin</a>
                                </li>
                            </ul>
                            </div>
                            <div class="bd-highlight">
                                <div class="d-flex flex-row-center bd-highlight">
                                    <div class="d-flex pt-3">
                                        <label for="bulan-search" class="font-bold me-2 pt-1">Bulan</label>
                                        <?= Html::dropDownList('JaringanSearch[bulan]', $searchModel->bulan, Bimtek::optionsBulan(), ['class'=>'select form-select form-select-sm mr-2', 'id' => 'bulan-search' , 'prompt' => 'Semua']) ?>
                                    </div>
                                    <div class="d-flex pt-3">
                                        <label for="tahun-search" class="font-bold me-2 pt-1">Tahun</label>
                                        <?= Html::dropDownList('JaringanSearch[tahun]', $searchModel->tahun, Bimtek::optionsTahun(), ['class'=>'form-select form-select-sm select mr-2', 'id' => 'tahun-search' ]) ?>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
               </div> 
            <?php ActiveForm::end(); ?>

            </p>
           <p>
            <div>
                <?= Html::a('<i class="material-icons-round">add</i> Tambah Peta Jaringan', ['create'], ['class' => 'btn btn-outline-warning  mb-3']) ?>
            </div>
           </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table table-sm table-striped table-opsjar'
                ],
                'layout' => '<div class="table-responsive m-b-15">{items}</div><div class="row row-xs"><div class="col-md-6 text-left"><span class="m-l-10">{pager}</span></div><div class="col-md-6 text-center text-md-right"><div class="text-sm m-b-15 m-t-10 m-r-10">{summary}</div></div></div>',
                'showOnEmpty' => false,
                'summary' => 'Menampilkan <b>{begin}-{end}</b> dari <b>{totalCount}</b> Peta Jaringan',
                'emptyText' => '<div class="card-block">Tidak ada Peta Jaringan ditampilkan</div>',
                'pager' => [
                    'linkContainerOptions' => [
                        'class' => 'page-item',
                    ],
                    'linkOptions' => [
                        'class' => 'page-link'
                    ],
                    'activePageCssClass' => 'active',
                    'nextPageLabel' => false,
                    'prevPageLabel' => false,
                    'firstPageLabel' => $this->render('@app/views/utilities/arrow_left'),
                    'lastPageLabel' => $this->render('@app/views/utilities/arrow_right'),
                    'disabledListItemSubTagOptions' => [
                        'class' => 'page-link'
                    ],
                    'maxButtonCount' => 5
                ],
                'columns' => [
                    [
                        'header' => 'No.',
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => [
                            'width' => '10px'
                        ]
                    ],
                    [
                        'label' => 'Jaringan',
                        'headerOptions' => [
                            'class' => 'text-left'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->name;
                        }
                    ],
                    [
                        'label' => 'Diperbarui Pada',
                        'contentOptions' => [
                            'class' => 'text-center'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->created_at ? Yii::$app->formatter->asDate($model->created_at) :Yii::$app->formatter->asDate($model->updated_at);
                        }
                    ],
                    [
                        'label' => 'Dokumen',
                        'contentOptions' => [
                            'class' => 'text-center'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->dokumen ?  Html::a('<i class="material-icons-round">download</i> Unduh Dokumen', $model->dokumen, ['class' => 'btn btn-outline-success', 'target' => '_blank'])  : '<i>Belum Tersedia</i>';
                        }
                    ],
                    [
                        'label' => 'Tindakan',
                        'contentOptions' => [
                            'class' => 'text-center',
                            'width' => '20%'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->getActionButton();
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
            
</div>

<?php $form = ActiveForm::begin([
    'action' => '/provinsi/update-dokumen',
]);
$model = new Provinsi();
?>
<div class="modal fade" id="modalDokumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <h5 class="modal-title font-bold" id="modalDokumenLabel">Dokumen Kerawanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <span id="modal-provinsi-label" class="text-md font-bold">#</span>
            <div class="row mt-3">
                <div class="col-md-4">
                    <input type="hidden" name="prov" value="0" id="provUn">
                    <div class="form-group field-provinsi-dokumen_update_date">
                        <span class="control-label" for="provinsi-dokumen_update_date">Tanggal Diperbarui</span>
                        <?= DateRangePicker::widget([
                            'model'=>$model,
                            'attribute'=>'dokumen_update_date',
                            'convertFormat'=>true,
                            'pluginOptions'=>[
                                'locale'=>['format'=>'Y-m-d'],
                                'singleDatePicker'=>true,
                            ]
                        ]); ?>

                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group field-provinsi-dokumen_kerawanan">
                        <span class="control-label" for="provinsi-dokumen_kerawanan">Link Dokumen</span>
                        <input type="text" id="provinsi-dokumen_kerawanan" class="form-control" name="Provinsi[dokumen_kerawanan]">

                        <div class="help-block"></div>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
        <?= Html::submitButton('<i class="material-icons-round">save</i> Simpan', ['class' => 'btn btn-success']) ?>
      </div>
    </div>
  </div>
</div>
<?php ActiveForm::end(); ?>



<?php
$urlDokumen = Url::to(['provinsi/get-dokumen']);
$script = <<<JS

$('#bulan-search').on('change', function(){
    $('#search-form').submit();
 });
 $('#tahun-search').on('change', function(){
    $('#search-form').submit();
 });

const path = '$urlDokumen';
 $('.btn-modal').on('click', function(){
    console.log($(this).data('id'));
    let id = $(this).data('id');
    $('#provUn').val(id);
    $.ajax({
        url: path,
        type: 'get',
        data: 'id='+id,
        beforeSend: function(){},
        success: function(data){
            $('#modal-provinsi-label').html(data['name']);
            $('#provinsi-dokumen_kerawanan').val(data['link']);
            $('#provinsi-dokumen_update_date').val(data['date']);
        }
    });
 });
JS;
$this->registerJs($script,\yii\web\View::POS_END);
?>