<?php

use backend\models\Bimtek;
use backend\models\Provinsi;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProvinsiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>


<div class="provinsi-index">
    <?= Yii::$app->session->getFlash('info'); ?>

    <?php $form = ActiveForm::begin([
        'action' => ['view'],
        'method' => 'get',
        'id' => 'search-form'
    ]); ?>
    <div class="row mb-3">
        <div class="col-md-12"> 
            <div class="d-flex bd-highlight">
                <div class="flex-grow-1"> <h2 class="text-title">Peta Kerawanan</h2></div>
                <div class="bd-highlight d-flex">
                    <div class="d-flex" style="margin-right:10px ;">
                        <label for="tahun-search" class="font-bold me-2 pt-1">Tahun</label>
                        <?= Html::dropDownList('tahun', $tahun, Bimtek::optionsTahun(), ['class'=>'form-select form-select-sm select', 'id' => 'tahun-search', 'style' =>'width:100px' ]) ?>
                    </div>
                    <div class="form-input d-flex">
                        <input class="form-control" type="search" aria-label="Search" type="search" id="provinsisearch-name" name="name" class="form-control me-2" placeholder="Cari Provinsi" value="<?= $name ?>">
                        <button type="submit" class=" btn btn-submit" style="font-size:30px">
                            <span class="material-icons-outlined text-md">search</span>
                        </button>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div> 
    <?php ActiveForm::end(); ?>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-secondary">
                <div class="card-header card-title">Peta Kerawanan</div>
                <div class="card-body">    
                    <?php Pjax::begin(['id' => 'kerawanan']) ?>  
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'tableOptions' => [
                                'class' => 'table table-sm table-striped table-opsjar table-opsjar-user'
                            ],
                            'layout' => '<div class="table-responsive m-b-15">{items}</div><div class="row row-xs"><div class="col-md-6 text-left"><span class="m-l-10">{pager}</span></div><div class="col-md-6 text-center text-md-right"><div class="text-sm m-b-15 m-t-10 m-r-10">{summary}</div></div></div>',
                            'showOnEmpty' => false,
                            'summary' => 'Menampilkan <b>{begin}-{end}</b> dari <b>{totalCount}</b> Peta Kerawanan',
                            'emptyText' => '<div class="card-block">Tidak ada Kegiatan ditampilkan</div>',
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
                                    'label' => 'Provinsi',
                                    'headerOptions' => [
                                        'class' => 'text-left'
                                    ],
                                    'content' => function ($model, $key, $index, $column) {
                                        return $model->name;
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
                    <?php Pjax::end() ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-secondary">
                <div class="card-header card-title">Peta jaringan</div>
                <div class="card-body">    
                    <?php Pjax::begin(['id' => 'Jaringan']) ?>         
                        <?= GridView::widget([
                            'dataProvider' => $dataProviderJaringan,
                            'tableOptions' => [
                                'class' => 'table table-sm table-striped table-opsjar table-opsjar-user'
                            ],
                            'layout' => '<div class="table-responsive m-b-15">{items}</div><div class="row row-xs"><div class="col-md-6 text-left"><span class="m-l-10">{pager}</span></div><div class="col-md-6 text-center text-md-right"><div class="text-sm m-b-15 m-t-10 m-r-10">{summary}</div></div></div>',
                            'showOnEmpty' => false,
                            'summary' => 'Menampilkan <b>{begin}-{end}</b> dari <b>{totalCount}</b> Jaringan',
                            'emptyText' => '<div class="card-block">Tidak ada Jaringan ditampilkan</div>',
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
                    <?php Pjax::end() ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-secondary">
                <div class="card-header card-title">Buletin</div>
                <div class="card-body">   
                    <?php Pjax::begin(['id' => 'xray']) ?>          
                        <?= GridView::widget([
                            'dataProvider' => $dataProviderXray,
                            'tableOptions' => [
                                'class' => 'table table-sm table-striped table-opsjar table-opsjar-user'
                            ],
                            'layout' => '<div class="table-responsive m-b-15">{items}</div><div class="row row-xs"><div class="col-md-6 text-left"><span class="m-l-10">{pager}</span></div><div class="col-md-6 text-center text-md-right"><div class="text-sm m-b-15 m-t-10 m-r-10">{summary}</div></div></div>',
                            'showOnEmpty' => false,
                            'summary' => 'Menampilkan <b>{begin}-{end}</b> dari <b>{totalCount}</b> Kasus',
                            'emptyText' => '<div class="card-block">Tidak ada Kasus ditampilkan</div>',
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
                                    'label' => 'Kasus',
                                    'headerOptions' => [
                                        'class' => 'text-left'
                                    ],
                                    'content' => function ($model, $key, $index, $column) {
                                        return $model->name;
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
                    <?php Pjax::end() ?>
                </div>
            </div>
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
 $('#tahun-search').on('change', function(){
    $('#search-form').submit();
 });
JS;
$this->registerJs($script,\yii\web\View::POS_END);
?>