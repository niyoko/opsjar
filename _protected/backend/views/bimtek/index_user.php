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
<div class="bimtek-index">
    <?= Yii::$app->session->getFlash('info'); ?>
    <div class="card card-secondary">
        <div class="card-body">
            <p>
                <h2 class="text-title">Bimbingan Teknis</h2>
               
                <?= $this->render('_search_user', [
                    'model' => $searchModel,
                ]); ?>
            </p>
           
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table table-sm table-striped table-opsjar table-opsjar-user'
                ],
                'layout' => '<div class="table-responsive m-b-15">{items}</div><div class="row row-xs"><div class="col-md-6 text-left"><span class="m-l-10">{pager}</span></div><div class="col-md-6 text-center text-md-right"><div class="text-sm m-b-15 m-t-10 m-r-10">{summary}</div></div></div>',
                'showOnEmpty' => false,
                'summary' => 'Menampilkan <b>{begin}-{end}</b> dari <b>{totalCount}</b> Kegiatan',
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
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => [
                            'width' => '25px'
                        ]
                    ],
                    [
                        'label' => 'Kegiatan',
                        'headerOptions' => [
                            'class' => 'text-start'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->name;
                        }
                    ],
                    [
                        'label' => 'Surat Tugas',
                        'contentOptions' => [
                            'class' => 'text-center'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->getSuratTugasBtn();
                        }
                    ],
                    [
                        'label' => 'Tanggal Pelaksanaan',
                        'contentOptions' => [
                            'class' => 'text-center'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->getTanggalPelaksanaan();
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => [
                            'class' => 'text-center'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return '<h5>'.$model->getStatusBadges(). '</h5>';
                        }
                    ],
                    [
                        'label' => 'Laporan',
                        'contentOptions' => [
                            'class' => 'text-center'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->getLaporanBtn();
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
            
</div>

