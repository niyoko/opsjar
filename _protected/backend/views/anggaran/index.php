<?php

use backend\models\Anggaran;
use backend\models\Bimtek;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Bimtek */
/* @var $form yii\widgets\ActiveForm */
use kartik\daterange\DateRangePicker;
?>
<style>
    table tr td{
        padding-top: 8px;
        padding-right: 8px;
        padding-bottom: 8px;
    }
    table tr th{
        padding-left: 3px;
    }
</style>

<div class="bimtek-form">
    <?= Yii::$app->session->getFlash('info'); ?>
    <input type="hidden" value="true" name="submitted">
    <div class="card card-secondary">
        
        <div class="card-body">
            <p>
                
                <h2 class="text-title">Anggaran</h2>
                <div class="form-group">
                    
                </div>
            </p>
            <p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row mb-2">
                                    <div class="col-md-8 col-sm-3 col-xs-6">
                                        <?= $this->render('_search', [
                                            'tahun' => $tahun,
                                        ]); ?>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-6 text-right">
                                    <?php $form = ActiveForm::begin(['id' => 'submit-form']); ?>
                                        <input type="hidden" name="tahun-input" value="<?= $tahun ?>">
                                        <?= Html::submitButton('<i class="material-icons-round">save</i> Simpan Data', ['class' => 'btn btn-outline-warning']) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-12">
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h3 class="card-title">DATA DAFTAR ISIAN PELAKSANAAN ANGGARAN (DIPA) SUBDIREKTORAT OPERASI DAN PENGUNGKAPAN JARINGAN NARKOTIKA</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                               
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h3 class="card-title text-bold mb-2">Operasi</h3>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="nko-input text-sm">Anggaran</label>
                                                            <input id="nko-input" type="text" class="form-control form-control-sm number-format" name="anggaran-<?= Anggaran::TYPE_OPERATION  ?>" value="<?= $anggaran[Anggaran::TYPE_OPERATION]['budget'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="nko-input text-sm">Penggunaan</label>
                                                            <input id="nko-input" type="text" class="form-control form-control-sm number-format" name="penggunaan-<?= Anggaran::TYPE_OPERATION ?>" value="<?= $anggaran[Anggaran::TYPE_OPERATION]['realisasi'] ?>">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body"> 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h3 class="card-title text-bold mb-2">Bimbingan Teknis</h3>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="nko-input text-sm">Anggaran</label>
                                                            <input id="nko-input" type="text" class="form-control form-control-sm number-format" name="anggaran-<?= Anggaran::TYPE_BIMTEK ?>" value="<?= $anggaran[Anggaran::TYPE_BIMTEK]['budget'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="nko-input text-sm">Penggunaan</label>
                                                            <input id="nko-input" type="text" class="form-control form-control-sm number-format" name="penggunaan-<?= Anggaran::TYPE_BIMTEK?>" value="<?= $anggaran[Anggaran::TYPE_BIMTEK]['realisasi'] ?>">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-12">
                                        <?=  Html::button('<i class="material-icons-round">save</i> Perbarui Data', ['class' => 'btn btn-outline-success btn-submit']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h3 class="card-title">DATA DANA OPERASIONAL KHUSUS PENGAMANAN PENERIMAAN (DOKPPN) SUBDIREKTORAT OPERASI DAN PENGUNGKAPAN JARINGAN NARKOTIKA</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h3 class="card-title mb-2">Anggaran</h3>
                                                    </div>
                                                    <?php foreach (Bimtek::optionsBulan() as $key => $value):?>
                                                        <div class="col-md-4 col-sm-12 ">
                                                            <div class="form-group">
                                                                <label for="bulan-<?= $key ?>"><?= $value ?></label>
                                                                <input type="text" name="anggaran_months_value[]" id="bulan-<?= $key ?>" class="form-control form-control-sm number-format"  value="<?= isset($anggaranDetail[$key]['budget']) ? $anggaranDetail[$key]['budget'] : 0 ?>">
                                                                <input type="hidden" name="anggaran_months[]" id="id-<?= $key ?>" class="form-control form-control-sm number-format" value="<?= $key ?>">
                                                            </div>
                                                        </div>
                                                    <?php endforeach ?>  
                                                    
                                                </div>  
                                            </div>
                                        </div>                                    
                                    </div>
                                    <div class="col-md-12 pt-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h3 class="card-title mb-2">Penggunaan</h3>
                                                    </div>
                                                    <?php foreach (Bimtek::optionsBulan() as $key => $value):?>
                                                        <div class="col-md-4 col-sm-12 ">
                                                            <div class="form-group">
                                                                <label for="bulan-<?= $key ?>"><?= $value ?></label>
                                                                <input type="text" name="penggunaan_months_value[]" id="bulan-<?= $key ?>" class="form-control form-control-sm number-format" value="<?= isset($anggaranDetail[$key]['realisasi']) ? $anggaranDetail[$key]['realisasi'] : 0 ?>">
                                                                <input type="hidden" name="penggunaan_months[]" id="id-<?= $key ?>" class="form-control form-control-sm number-format" value="<?= $key ?>">
                                                            </div>
                                                        </div>
                                                    <?php endforeach ?>  
                                                    
                                                </div>  
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-md-12">
                                        <?=  Html::button('<i class="material-icons-round">save</i> Perbarui Data', ['class' => 'btn btn-outline-success btn-submit']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Rekapan Data Berdasarkan Tahun</h3>
                            </div>
                            <div class="card-body">
                                <?php if($rekap): ?>
                                        <?php foreach ($rekap as $key => $value) : ?>
                                            <table width="100%" class="border-bottom">
                                                    <tr>
                                                        <td><?= $value ?></td>
                                                        <td class="text-right">
                                                            <a href="/anggaran/unduh?tahun=<?= $value ?>" target="_blank" class="text-success font-bold">Unduh Data</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                        <?php endforeach ?>
                                <?php else :?>
                                   <i> Belum ada data rekapan </i>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </p>
        </div>
    </div>
    <?php
    
    ?>

    
<?php  ActiveForm::end(); ?>
   

</div>

<?php
$script = <<<JS
 $('.btn-submit').on('click', function(){
    $('#submit-form').submit();
 });

JS;
$this->registerJs($script,\yii\web\View::POS_END);
?>