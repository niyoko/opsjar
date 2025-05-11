<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\KantorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kantor';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kantor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Tambah Kantor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="col-md-12 pb-3">
            <?= $this->render('_search', [
                'model' => $searchModel,
            ]); ?>
        </div>
        <div class="col-md-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table table-sm table-striped table-opsjar'
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
                        'label' => 'Nama Pendek',
                        'contentOptions' => [
                            'class' => 'text-center'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->shortname;
                        }
                    ],
                    [
                        'label' => 'Provinsi',
                        'contentOptions' => [
                            'class' => 'text-center'
                        ],
                        'content' => function ($model, $key, $index, $column) {
                            return $model->provinsi->name;
                        }
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
    


</div>
