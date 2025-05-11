<?php

use common\components\MyFormatter;
use backend\models\Bimtek;
use backend\models\Provinsi;
use backend\models\Tahun;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\Progress;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Provinsi */

\yii\web\YiiAsset::register($this);
$this->registerCssFile("@web/css/jqvmap.css", [
    'depends' => [BootstrapAsset::class],
]);
?>
<style>
    html,
    body{
        height: 100%;
        background-color: #252733 !important;
        color: white !important;
    }

    .progress{
        height: 15px;
        margin-top: 5px;
    }

    .text-lg{
        font-size: xx-large;
    }

    .text-md{
        font-size:medium;
    }

    .table-kasus{
        margin-top: 10px;
    }

    .center {
        margin: auto;
        width: 50%;
        padding: 0 auto;
    }

    @media only screen and (max-height: 720px) {
        .box-opsjar .text-lg{
            font-size: large;
        }

        .box-opsjar-header{
            font-size: x-small;
        }

        .box-opsjar .text-md{
            font-size: small;
        }


        .form-select{
            height: auto;
            line-height: 14px;
            font-size: small;
        }

        .table-kasus{
        margin-top: 5px;
    }

    }

    @media only screen and (max-width: 767px) {
        .summary-lg {
            display: none;
        }
    }
    @media only screen and (min-width: 767px) {
        .summary-sm {
            display: none;
        }
    }

    @media only screen and (max-width:1500px){
        
        .text-sm{
            font-size: 10px;
        }

        .tbl-box{
            font-size: 12px !important;
            width: fit-content;
            gap: 15px;
        }

        .case-summary{
            min-width: 11  nmjknm0px !important;
            max-width: 110px !important;
            gap: 5px;
        }

        .tbl-item{
            min-width: 60px !important;
            max-width: 60px !important;
        }

        .tbl-item-total{
            min-width: 70px !important;
            max-width: 70px !important;
        }

        .tbl-item-surat{
            min-width: 80px !important;
        }
    }
    #tbl-penangkapan{
        text-align: center;
        align-items: center;
        align-content: center;
        color:black;
    }
    #tbl-penangkapan .material-icons-outlined{
        font-size: 18px ;
        color:#FBB03B;
        padding-top: 2px;
    }

    #tbl-penangkapan .material-icons{
        font-size: 18px ;
        color:#FBB03B;
        padding-top: 3px;
    }

    .tbl-box{
        box-sizing: border-box;

        /* Auto layout */
        align-items: center;
        gap: 25px;

        height: 50px;
        margin-bottom: 10px;

        background: #FFFFFF;
        /* opsjar/abu muda */

        border-bottom: 1px solid #C4C4C4;

        /* Inside auto layout */

        flex: none;
        order: 0;
        flex-grow: 0;
        font-size: 16px;
        width: fit-content;
    }

    .tbl-box .btn{
        width: max-content;
        height: fit-content;
        padding: 2px;
        font-size: smaller;
    }

    .tbl-no{

        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 0px 5px;
        margin-right: 5px;
        gap: 10px;

        width: 28px;
        height: 28px;

        /* opsjar/orange */

        background: #FBB03B;
        border-radius: 0px 4px 4px 0px;

        /* Inside auto layout */

        flex: none;
        order: 0;
        flex-grow: 0;
    }

    .div-material{
        display: inline-flex;
        vertical-align: bottom;
        gap: 5px;
    }
    .case-summary{
        min-width: 150px;
        max-width: 150px;
        gap: 15px;
    }

    .tbl-item{
        min-width: 80px;
        max-width: 80px;
    }

    .tbl-item-total{
        min-width: 70px;
        max-width: 100px;
    }

    .tbl-base{
        min-width: fit-content;
    }

    .tbl-item-surat{
        min-width: 150px;
    }

    .modal-xl {
        max-width: 90% !important;
    }

    #modalDetail{
        margin-top: 20px;
    }

    #modalDetail  .modal-content
    {
        min-height:500px;
        max-height: fit-content;
    }
    .text-sm{
        font-size: 14px;
    }
    .modal-header {
        border-bottom: 0 none;
    }
    .main-site {

        -webkit-animation:fadein 2s; /* Safari, Chrome and Opera > 12.1 */
       -moz-animation: fadein 2s; /* Firefox < 16 */
        -ms-animation: fadein 2s; /* Internet Explorer */
         -o-animation: fadein 2s; /* Opera < 12.1 */
            animation: fadein 2s;
    }

    @keyframes fadein {
        from { opacity: 0; padding-top: 20px;}
        to   { opacity: 1;  padding-top: 0px ;}
    }

    /* Firefox < 16 */
    @-moz-keyframes fadein {
        from { opacity: 0; padding-top: 20px;}
        to   { opacity: 1;  padding-top: 0px ;}
    }

    /* Safari, Chrome and Opera > 12.1 */
    @-webkit-keyframes fadein {
        from { opacity: 0; padding-top: 20px;}
        to   { opacity: 1;  padding-top: 0px ;}
    }

    /* Internet Explorer */
    @-ms-keyframes fadein {
        from { opacity: 0; padding-top: 20px;}
        to   { opacity: 1;  padding-top: 0px ;}
    }

    /* Opera < 12.1 */
    @-o-keyframes fadein {
        from { opacity: 0; padding-top: 20px;}
        to   { opacity: 1;  padding-top: 0px ;}
    }

    .main-site {

        -webkit-animation:fadein 2s; /* Safari, Chrome and Opera > 12.1 */
       -moz-animation: fadein 2s; /* Firefox < 16 */
        -ms-animation: fadein 2s; /* Internet Explorer */
         -o-animation: fadein 2s; /* Opera < 12.1 */
            animation: fadein 2s;
    }

    @keyframes fadein {
        from { opacity: 0; padding-top: 20px;}
        to   { opacity: 1;  padding-top: 0px ;}
    }

    /* Firefox < 16 */
    @-moz-keyframes fadein {
        from { opacity: 0; padding-top: 20px;}
        to   { opacity: 1;  padding-top: 0px ;}
    }

    /* Safari, Chrome and Opera > 12.1 */
    @-webkit-keyframes fadein {
        from { opacity: 0; padding-top: 20px;}
        to   { opacity: 1;  padding-top: 0px ;}
    }

    /* Internet Explorer */
    @-ms-keyframes fadein {
        from { opacity: 0; padding-top: 20px;}
        to   { opacity: 1;  padding-top: 0px ;}
    }

    /* Opera < 12.1 */
    @-o-keyframes fadein {
        from { opacity: 0; padding-top: 20px;}
        to   { opacity: 1;  padding-top: 0px ;}
    }

    @keyframes box-manajemen {
        0%   {opacity:0;}
        25%  {opacity:0;}
        50%  {opacity:0;}
        75%  {opacity:1;}
        100% {opacity:1;}
    }

    .box-1{
        animation-name: box-manajemen;
        animation-duration: 2s;
        animation-delay: 0s;
    }

    .box-2{
        animation-name: box-manajemen;
        animation-duration: 3s;
        animation-delay: 0s;
    }

    .box-3{
        animation-name: box-manajemen;
        animation-duration: 4s;
        animation-delay: 0s;
    }

    .box-4{
        animation-name: box-manajemen;
        animation-duration: 5s;
        animation-delay: 0s;
    }

    .box-5{
        animation-name: box-manajemen;
        animation-duration: 6s;
        animation-delay: 0s;
    }

    .box-6{
        animation-name: box-manajemen;
        animation-duration: 7s;
        animation-delay: 0s;
    }

    .box-7{
        animation-name: box-manajemen;
        animation-duration: 8s;
        animation-delay: 0s;
    }

</style>
<?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'search-form'
    ]); ?>
<div class="main-site">
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center box-opsjar box-1">
                        <div class="box-opsjar-header">
                            <span class="font-bold"> Manajemen Data</span>
                        </div>
                        
                        <div class="box-body mt-1 text-start">
                            <div class="row">
                                <div class="col-md-12 pl-3 pr-3">
                                    <div class="mb-1 ml-auto">Menampilkan Data</div>
                                </div>
                                <div class="col-md-12">
                                    <?= Html::dropDownList('provinsi',$provinsi,Provinsi::getOptionsMap(), ['class' => 'form-select form-select-sm search-btn', 'id' => 'provinsi', 'aria-label' => 'Provinsi', 'prompt' => 'Seluruh Indonesia']) ?>     

                                </div>
                            </div>
                           <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for="tahun" class="mb-1">Tahun</label>
                                    <?= Html::dropDownList('tahun',$tahun,Bimtek::optionsTahun(), ['class' => 'form-select form-select-sm d-inline-flex search-btn', 'id' => 'tahun', 'aria-label' => 'Tahun']) ?>
                                </div>
                                <div class="col-md-6">
                                    <label for="tahun" class="mb-1">Bulan</label>
                                    <?= Html::dropDownList('bulan',$bulan,Bimtek::optionsBulan(), ['class' => 'form-select form-select-sm d-inline-flex search-btn', 'id' => 'bulan', 'aria-label' => 'Bulan', 'prompt' => 'Semua']) ?>
                                </div>
                           </div>
                            
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12 col-sm-4">
                    <div class="row summary-lg" >
                        <div class="col-md-12 col-sm-4">
                            <div class="text-center box-opsjar box-2">
                                <div class="box-opsjar-header">
                                    <img src="/images/plane.svg" class="filter-green icon m-1"/><span class="font-bold"> Kasus Udara</span>
                                </div>
                               
                                <div class="mt-1 text-center">
                                    <table class="table-kasus">
                                        <tr>
                                            <td style="vertical-align: middle ;"><span class="text-danger text-lg text-case-udara">0</span></td>
                                            <td style="vertical-align: middle ;" class="p-1"><span class="text-sm">Kasus</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="text-center">
                                <div class="text-center box-opsjar box-3">
                                    <div class="box-opsjar-header">
                                        <img src="/images/ship.svg" class="filter-green icon m-1"/><span class="font-bold"> Kasus Laut</span>
                                    </div>
                                
                                    <div class="mt-1 text-center">
                                        <table class="table-kasus">
                                            <tr>
                                                <td style="vertical-align: middle ;"><span class="text-primary text-lg text-case-laut">0</span></td>
                                                <td style="vertical-align: middle ;" class="p-1"><span class="text-sm">Kasus</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="text-center box-opsjar box-4">
                                <div class="box-opsjar-header">
                                    <img src="/images/truck.svg" class="filter-green icon m-1"/><span class="font-bold"> Kasus Darat</span>
                                </div>
                               
                                <div class="mt-1 text-center">
                                    <table class="table-kasus">
                                        <tr>
                                            <td style="vertical-align: middle ;"><span class="text-success text-lg text-case-darat">0</span></td>
                                            <td style="vertical-align: middle ;" class="p-1"><span class="text-sm">Kasus</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div></div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-md-9 col-sm-12 text-center">
            <span class="font-bold" style="text-transform: uppercase; font-size:larger;">DASHBOARD DATA SUBDIREKTORAT OPERASI DAN PENGUNGKAPAN JARINGAN </span>
            <div class="map-container p-0" style="max-width:100%;">
                <div id="map-body"><div id="vmap" ></div>
            </div>
            <div id="keterangan"></div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="text-center box-opsjar-horizontal box-5">
                        <div class="box-opsjar-header">
                            <span class="font-bold"> Jenis Narkotika</span>
                        </div>
                        
                        <div class="box-body mt-3 text-start" style="width:90%;">
                            <table width="100%">
                            <?php foreach($detail as $d): ?>
                                <tr>
                                    <td width="30px" style="padding-right: 5px ;"><span class="text-sm"> <?= $d['label'] ?></span></td>
                                    <td style="padding-left: 5px ;">
                                        <div class="progress progess-<?= $d['label'] ?>" style="height: 15px;">
                                        <input type="hidden" class="progressbar-width" value="<?= $d['width'] ?>">
                                            <div role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"  class="progress-bar <?= $d['color'] ?> progressbar-<?= $d['label'] ?>" style="width:0%;">
                                               <span style="font-size: 10px ;"> <?= $d['total'] ?> gr </span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php  endforeach?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="text-center box-opsjar-horizontal box-6">
                        <div class="box-opsjar-header">
                            <span class="font-bold"> Total Tangkapan</span>
                        </div>
                        
                        <div class="box-body mt-3 text-center ">
                            <div class="pt-3">
                                <div class="text-warning text-lg text-total mx-auto"><?= 0 ?></div>
                                <div><small>gram</small></div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="text-center box-opsjar-horizontal box-7">
                        <div class="box-opsjar-header">
                            <span class="font-bold"> Kasus Tertinggi</span>
                        </div>
                        
                        <div class="box-body mt-3 text-center">
                            <div class="box-opsjar-horizontal-wrap justify-content-center">
                                <span class="text-md"><?= isset($case['name']) ? $case['name'] : '' ?></span>
                                <div class="text-warning text-lg text-case-tertinggi">0</div>
                                Kasus    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row summary-sm">
        <div class="col-md-12 m-0 p-0">
            <div class="row">                
                <div class="col-md-12 col-sm-4">
                    <div class="row summary-lg" >
                        <div class="col-md-12 col-sm-4">
                            <div class="text-center box-opsjar">
                                <div class="box-opsjar-header">
                                    <img src="/images/plane.svg" class="filter-green icon m-1"/><span class="font-bold"> Kasus Udara</span>
                                </div>
                            
                                <div class="mt-1 text-center">
                                    <table>
                                        <tr>
                                            <td style="vertical-align: middle ;"><h1 class="text-danger"><?= $data['udara'] ?></h1></td>
                                            <td style="vertical-align: middle ;" class="p-1"><span class="text-sm">Kasus</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="text-center">
                                <div class="text-center box-opsjar">
                                    <div class="box-opsjar-header">
                                        <img src="/images/ship.svg" class="filter-green icon m-1"/><span class="font-bold"> Kasus Laut</span>
                                    </div>
                                
                                    <div class="mt-1 text-center">
                                        <table>
                                            <tr>
                                                <td style="vertical-align: middle ;"><h1 class="text-primary"><?= $data['laut'] ?></h1></td>
                                                <td style="vertical-align: middle ;" class="p-1"><span class="text-sm">Kasus</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="text-center box-opsjar">
                                <div class="box-opsjar-header">
                                    <img src="/images/truck.svg" class="filter-green icon m-1"/><span class="font-bold"> Kasus Darat</span>
                                </div>
                            
                                <div class="mt-1 text-center">
                                    <table>
                                        <tr>
                                            <td style="vertical-align: middle ;"><h1 class="text-success"><?= $data['darat'] ?></h1></td>
                                            <td style="vertical-align: middle ;" class="p-1"><span class="text-sm">Kasus</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="Modal Detail" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <h5 class="modal-title font-bold text-dark" id="modalDetailLabel">Provinsi</h5>
       
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        <div class="row mb-3">
            <div class="col-md-4 text-dark text-sm d-flex">
                <div class="p-2" style="vertical-align: middle ; display:table-cell"> Tahun</div>
                <div class="p-1">
                    <input type="hidden" value="" id="code">
                    <input type="hidden" value="" id="page-modal">
                    <?= Html::dropDownList('tahun-modal',$tahun,Bimtek::optionsTahun(), ['class' => 'form-select form-select-sm', 'id' => 'tahun-modal', 'aria-label' => 'Tahun']) ?>
                </div>

                <div class="p-2" style="vertical-align: middle ; display:table-cell"> Kasus</div>
                <div class="p-1">
                    <?= Html::dropDownList('case-modal',null,['udara' => 'Udara', 'laut' => "Laut", "darat" => "Darat"], ['prompt' => 'Semua', 'class' => 'form-select form-select-sm', 'id' => 'case-modal', 'aria-label' => 'Kasus']) ?>
                </div>
               
            </div>
            
        </div>
            <div class="table-responsive">
                <div class="" style="font-size: 14px;" id="tbl-penangkapan">
                    Data Belum Tersedia
                </div>
                <div id="pagination-modal" class="mt-3 mb-3">

                </div>
                <div>
                </div>
            </div>
      </div>
    </div>
  </div>
</div>
<?php ActiveForm::end(); ?>
<?php 
$path = Url::to(['site/get-detail-provinsi']);
$script = <<<JS

    jQuery(document).ready(function () {
        drawMap('$provinsi');
        $('#provinsi').on('change', function(){
            $('#vmap').remove();
            $('#map-body').html('<div id="vmap""></div>');
            drawMap($(this).val());
            $('#keterangan').html();
            if($(this).val()){
            $('#keterangan').html("Data Provinsi "+$(this).children("option:selected").text()+" " )
            }
            else{
            $('#keterangan').html("Data Seluruh Indonesia ")
            }
            
        
        });

       

        $(window).on("resize", sizeMap);

    });

   

    const sizeMap = () => {
        var containerWidth = $('.map-container').width(),
            containerHeight = (containerWidth / 3.1);

        $('#vmap').css({
            'width': containerWidth,
            'height': containerHeight
        });
    }

    const fillModal = (provinsi, tahun, c, p) => {
        $.ajax({
            url: '{$path}',
            type: 'get',
            data: 'code='+provinsi+'&tahun='+tahun+'&c='+c+'&page='+p,
            beforeSend: function(){},
            success: function(data){
                $('#modalDetailLabel').html(data.name);
                $('#code').val(provinsi);
                $('#page-modal').val(data.page);
                if(data.data){
                    d = data.data;
                    tmpl = '';
                    pagination = '';
                    $('#tbl-penangkapan').html('Data tidak ditemukan');
                    $('#pagination-modal').html('');
                    for(i=0; i< d.length ; i++){
                        tmpl+='<div class="d-flex flex-row bd-highlight tbl-box">';
                        tmpl +='<div class="tbl-no">'+(i+1)+'</div>';
                        tmpl+='<div class="tbl-base"><div class="text-sm m-0 p-0 text-start">'+d[i].date+'</div><div class="m-0 p-0 font-bold">Penangkapan '+data.name+'</div></div>';
                        tmpl+= '<div class="d-flex case-summary"><div class="div-material"><span class="material-icons-outlined">flight_takeoff</span> '+d[i].udara+'</div>';
                        tmpl+= '<div class="div-material"><span class="material-icons-outlined">anchor</span> '+d[i].laut+'</div>';
                        tmpl+= '<div class="div-material"><span class="material-icons">local_shipping</span> '+d[i].darat+'</div>';
                        tmpl+= ' </div>'
                        tmpl+='<div class="tbl-item-total"><div class="text-sm m-0 p-0">Total </div><div class="m-0 p-0 font-bold">'+d[i].total+'</div></div>';
                        tmpl+='<div class="tbl-item"><div class="text-sm m-0 p-0">Meth</div><div class="m-0 p-0 font-bold">'+d[i].meth+'</div></div>';
                        tmpl+='<div class="tbl-item"><div class="text-sm m-0 p-0">Cocaine</div><div class="m-0 p-0 font-bold">'+d[i].cocaine+'</div></div>';
                        tmpl+='<div class="tbl-item"><div class="text-sm m-0 p-0">Ganja</div><div class="m-0 p-0 font-bold">'+d[i].ganja+'</div></div>';
                        tmpl+='<div class="tbl-item"><div class="text-sm m-0 p-0">MDMA </div><div class="m-0 p-0 font-bold">'+d[i].mdma+'</div></div>';
                        tmpl+='<div class="tbl-item"><div class="text-sm m-0 p-0">Lainnya </div><div class="m-0 p-0 font-bold">'+d[i].lainnya+'</div></div>';
                        tmpl+='<div class="tbl-item-surat"><div class="text-sm m-0 p-0">Surat Tugas </div><div class="m-0 p-0 font-bold"><a class="text-warning" href="'+d[i].surat_tugas_url+'">'+d[i].surat_tugas+'</a></div></div>';
                        tmpl+='<div class="button-laporan"><a class="btn btn-outline-warning" href="'+d[i].laporan+'">Unduh Dokumen</a></div>';
                        
                        tmpl += '</div>';
                    }
                    if(tmpl != ''){
                        $('#tbl-penangkapan').html(tmpl);
                        
                        if(data.totalPage > 1){
                            pagination = '<ul class="pagination justify-content-left">';
                            start = data.page > 1 ? data.page-1 : 1;
                            disabledPrev = data.page == 1 ? 'disabled' : '';
                            if(data.page>2){
                                pagination += '<li class="page-item '+disabledPrev+'"><a data-id="'+(data.page-1)+'" class="page-link page-btn" href="#" type="button"><span class="material-icons text-sm">skip_previous</span></a></li>'

                            }
                            pagination += '<li class="page-item '+disabledPrev+'"><a data-id="'+(data.page-1)+'" class="page-link" href="#" type="button"><span class="material-icons text-sm">arrow_back_ios</span></a></li>'
                            for(i = start; i <= data.totalPage ; i++ ){
                                isActive = i == data.page ? 'active' : '';
                                pagination += '<li class="page-item '+isActive+'"><a data-id="'+i+'"  class="page-link page-btn" href="#">'+i+'</a></li>';
                            }
                            if(data.page < (data.totalPage-2)){
                                pagination += '<li class="page-item"><a data-id="'+(data.totalPage)+'" class="page-link" href="#"><span class="material-icons">skip_next</span></a></li>'   
                            }
                            
                            disabledNext = data.page == data.totalPage ? "disabled" : "";
                            pagination += '<li class="page-item '+disabledNext+'"><a data-id="'+(data.totalPage)+'" class="page-link" href="#"><span class="material-icons text-sm">arrow_forward_ios</span></a></li>'
                            pagination += '</ul>';
                            $('#pagination-modal').html(pagination);
                        }
                    }
                    
                }
            }
        });
    }
    
    const drawMap = (selectedRegions = null) => {
        sizeMap();
        
        jQuery('#vmap').vectorMap({
            map: 'indonesia_id',
            enableZoom: false,
            showTooltip: true,
            selectedColor: '#d8a854',
            scaleColors: ['#b6d6ff', '#005ace'],
            color: "#c3d3e3",
            selectedRegions: selectedRegions,
            hoverOpacity: null,
            borderColor: '#818181',
            borderOpacity: 0.25,
            borderWidth: 1,
            hoverColor: '#d8a854',
            backgroundColor: "#252733",
            markerStyle: {
                initial: {
                        fill: '#F8E23B',
                        stroke: '#383f47'
                }
            },
            markers: [[1,2]],
            onRegionClick: function(event, code, region){
                fillModal(code, '', '', 1)
                $('#modalDetail').modal('show');
            },
            onLabelShow: function(event, label,code){
                var regionName = label[0].innerHTML;
                let html = ['<table>',
                    '<tr><td colspan="2" class="text-md"><b>'+regionName+'</b></td></tr>',
                    '<tr>',
                    '<td>Name</td>',
                    '<td>Code</td>',
                    '</tr>',
                    '<tr>',
                    '<td>',
                    regionName,
                    '</td>',
                    '<td>',
                    code,
                    '</td>',
                    '</tr>',
                '</table>'
                ].join("");
                label[0].innerHTML = html;
            }

            
            
        });
    }

    $('.btn-close').on('click', function(){
        $('#vmap').remove();
        $('#map-body').html('<div id="vmap""></div>');
        drawMap('$provinsi');
        setTimeout(function(){
            if(!$("#modalDetail").hasClass('show')){
              
                window.location.reload(1);
            }
       
        }, 30000);
    });

    $('#tahun-modal').on('change', function(){
        code = $('#code').val();
        c = $('#case-modal').val();
        p = $('#page-modal').val();
        fillModal(code,$(this).val(),c,p);

    });

    $('#tahun-modal').on('change', function(){
        code = $('#code').val();
        c = $('#case-modal').val();
        p = $('#page-modal').val();
        tahun = $('#tahun-modal').val();
        fillModal(code,tahun,c,p);

    });

    $('#pagination-modal').on('click', '.page-link', function() {
        code = $('#code').val();
        c = $('#case-modal').val();
        p = $(this).data("id");
        tahun = $('#tahun-modal').val();
        fillModal(code,tahun,c,p);
    });

    $('#case-modal').on('change', function(){
        code = $('#code').val();
        c = $('#case-modal').val();
        p = $('#page-modal').val();
        tahun = $('#tahun-modal').val();
        fillModal(code,tahun,c,p);

    });




    $('.search-btn').on('change', function(){
        $('#search-form').submit();
    });

        let progressWidth = document.getElementsByClassName('progressbar-width');

        let progress = document.getElementsByClassName('progress');
        let progressBar = document.getElementsByClassName('progress-bar');
    


        setTimeout(function() {            
            moveCase($('.text-case-tertinggi'), Number('{$case["total"]}'))       
        }, 4700); 
        

        setTimeout(function() {            
            moveTotal()            
        }, 4500); 

        setTimeout(function() {
            move(progressBar[0],progressWidth[0].value )
            move(progressBar[1],progressWidth[1].value )
            move(progressBar[2],progressWidth[2].value )
            move(progressBar[3],progressWidth[3].value )
            move(progressBar[4],progressWidth[4].value )
        }, 3600); 

        setTimeout(function() {
            moveCase($('.text-case-darat'), Number('{$data["darat"]}'))
        }, 3000); 

        setTimeout(function() {
            moveCase($('.text-case-laut'), Number('{$data["laut"]}'))
        }, 2500); 

        setTimeout(function() {
            moveCase($('.text-case-udara'), Number('{$data["udara"]}'))
        }, 2000); 

        setTimeout(function(){
            console.log($("#modalDetail").hasClass('show'));
            if(!$("#modalDetail").hasClass('show')){
              
                window.location.reload(1);
            }
       
        }, 30000);

        function move(elem,maxwidth) {
            var width = 1;
            var id = setInterval(frame, 10);
            function frame() {
            if (width >= maxwidth) {
                clearInterval(id);
                i = 0;
            } else {
                width++;
                elem.style.width = width + '%';
            }
            }
        }

        function moveTotal(){
            var width = 1;
            var id = setInterval(frame,5 );
            let total = Number('{$total}');
            function frame() {
            if (width >= total) {
                clearInterval(id);
                i = 0;
            } else {
                let pembagi = total > 1000 ? 100 : total ;
                width+= Math.floor(total / pembagi);
                if(width > total){
                    width = total;
                }
                $('.text-total').html(width);
            }
            }
        }

        function moveCase(elem, ttl){
            var width = 1;
            var id = setInterval(frame,5 );
            function frame() {
            if (width >= ttl) {
                clearInterval(id);
                i = 0;
            } else {
                let pembagi = ttl > 1000 ? 100 : ttl ;
                width+= Math.floor(ttl / pembagi);
                if(width > ttl){
                    width = ttl;
                }
                elem.html(width);
            }
            }
        }
    
JS;
$this->registerJsFile(
    '@web/js/jquery.vmap.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
$this->registerJsFile(
    '@web/js/jquery.vmap.indonesia.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
$this->registerJs($script,\yii\web\View::POS_END);
?>
