<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\BimtekSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="anggota-index">
<?= Yii::$app->session->getFlash('info'); ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="card card-secondary">
        <div class="card-body">

            <p>
                <h2 class="text-title">Anggota</h2>
            </p>

            <div class="row">
                    
                    <div class="col-md-12 col-sm-12">
                        <?= Html::a('<i class="material-icons-round">add</i> Tambah Anggota', ['create'], ['class' => 'btn btn-outline-warning  mb-3']) ?>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <?= $this->render('_search', [
                            'model' => $searchModel,
                        ]); ?>
                    </div>
                </div>
           
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table table-sm table-striped table-opsjar'
                ],
                'layout' => '<div class="table-responsive m-b-15">{items}</div><div class="row row-xs"><div class="col-md-6 text-left"><span class="m-l-10">{pager}</span></div><div class="col-md-6 text-center text-md-right"><div class="text-sm m-b-15 m-t-10 m-r-10">{summary}</div></div></div>',
                'showOnEmpty' => false,
                'summary' => 'Menampilkan <b>{begin}-{end}</b> dari <b>{totalCount}</b> Anggota',
                'emptyText' => '<div class="card-block">Tidak ada Anggota ditampilkan</div>',
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
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => [
                            'width' => '10px'
                        ]
                    ],
                    [
                        'label' => 'Nama',
                        'content' => function ($model, $key, $index, $column) {
                            return $model->name;
                        }
                    ],
                    [
                        'label' => 'Lokasi',
                        'contentOptions' => [
                            'class' => 'text-center'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->getLokasiKantor();
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => [
                            'class' => 'text-center',
                            'width' => '200px'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return '<h5>'.$model->getStatusBadges(). '</h5>';
                        }
                    ],
                    [
                        'label' => '',
                        'contentOptions' => [
                            'class' => 'text-right',
                            'width' => '10%'
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
