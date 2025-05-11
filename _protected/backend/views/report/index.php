<?php

use common\components\MyFormatter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="report-index">
<?= Yii::$app->session->getFlash('info'); ?>
<div class="card">
    <div class="card-body">
        <p>
            <h2 class="mb-3 text-title">Beranda</h2>
        </p>
        <div class="row">
            <div class="col-md-12">
                <?= Html::a('<i class="material-icons-round">add</i> Tambah Data Baru', ['create'], ['class' => 'btn btn-outline-warning  mb-3']) ?>
            </div>
            <div class="col-md-12">
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
                'summary' => 'Menampilkan <b>{begin}-{end}</b> dari <b>{totalCount}</b> Laporan',
                'emptyText' => '<div class="card-block">Data belum tersedia</div>',
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
                        'label' => 'Lokasi Barang Bukti',
                        'content' => function ($model, $key, $index, $column) {
                            $kantor ='<strong>'. $model->getProvinsiName() . '</strong>';
                            if(isset($model->kantor->name)){
                                $kantor .= '<br>'. $model->kantor->name;
                            }
                            return $kantor;
                        }
                    ],
                    [
                        'label' => 'Kasus Udara',
                        'content' => function ($model, $key, $index, $column) {
                            return MyFormatter::applyNumberFormat($model->udara);
                        }
                    ],
                    [
                        'label' => 'Kasus Laut',
                        'contentOptions' => [
                            'class' => 'text-center'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return  MyFormatter::applyNumberFormat($model->laut);
                        }
                    ],
                    [
                        'label' => 'Kasus Darat',
                        'contentOptions' => [
                            'class' => 'text-center'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return MyFormatter::applyNumberFormat($model->darat);
                        }
                    ],
                    [
                        'label' => 'Meth',
                        'contentOptions' => [
                            'class' => 'text-center'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->getMeth(true);
                        }
                    ],
                    [
                        'label' => 'Cocaine',
                        'contentOptions' => [
                            'class' => 'text-center'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->getCocaine(true);
                        }
                    ],
                    [
                        'label' => 'Ganja',
                        'contentOptions' => [
                            'class' => 'text-center'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->getGanja(true);
                        }
                    ],
                    [
                        'label' => 'MDMA',
                        'contentOptions' => [
                            'class' => 'text-center'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->getMdma(true);
                        }
                    ],
                    [
                        'label' => 'Lainnya',
                        'contentOptions' => [
                            'class' => 'text-center',
                            'width' => '10%'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->getLainnya(true);
                        }
                    ],
                    [
                        'label' => 'Total',
                        'contentOptions' => [
                            'class' => 'text-center',
                            'width' => '10%'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->getTotalGr(true);
                        }
                    ],
                    [
                        'label' => 'Dilaporkan',
                        'contentOptions' => [
                            'class' => 'text-center',
                            'width' => '10%'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->getReportedDate();
                        }
                    ],
                    [
                        'label' => '',
                        'contentOptions' => [
                            'class' => 'text-center',
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return  $model->getActionButton();
                        }
                    ],
                ],
            ]); ?>
    </div>
</div>


</div>
