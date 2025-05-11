<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';

?>
<div class="user-index">
    <div class="carda">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-outline card-warning">
                                <div class="card-header">
                                    <h2 class="card-title">Akun Anda</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group form-inline ">  
                                                <label for="username">Username </label>
                                                <label id="username" class="ml-3"><?= Yii::$app->user->identity->username ?></label>
                                            </div>
                                            <hr>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group form-inline ">  
                                                <label for="password">Password </label>
                                                <label for=""><a href="/user/update?id=<?= Yii::$app->user->identity->id ?>" type="button" class="text-warning ml-3">Ubah Password</a></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="card card-outline card-warning">
                                <div class="card-header">
                                    <h2 class="card-title">Daftar User</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <?= Html::a('<i class="material-icons-round">add</i> Tambah User', ['create'], ['class' => 'btn btn-outline-success  mb-3']) ?>
                                        </div>
                                    </div>
                                    <?= GridView::widget([
                                        'dataProvider' => $dataProvider,
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
                                                'header' => 'Username',
                                                'headerOptions' => ['class' => 'text-left'],
                                                'contentOptions' => [
                                                    'width' => '40%'
                                                ],
                                                'content' => function($model){
                                                    return $model->username;
                                                }
                                            ],
                                            [
                                                'header' => 'Role',
                                                'headerOptions' => ['class' => 'text-center'],
                                                'contentOptions' => [
                                                    'class' => 'text-center'
                                                ],
                                                'content' => function($model){
                                                    return $model->getRoleLabel();
                                                }
                                            ],
                                            [
                                                'label' => '',
                                                'contentOptions' => [
                                                    'class' => 'text-right',
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
