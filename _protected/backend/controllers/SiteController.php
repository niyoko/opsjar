<?php

namespace backend\controllers;

use backend\models\Anggaran;
use backend\models\Bimtek;
use backend\models\CapaianKinerja;
use backend\models\Kantor;
use backend\models\Member;
use backend\models\Provinsi;
use backend\models\Report;
use backend\models\search\ReportSearch;
use common\components\Roles;
use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','logout', 'get-detail-provinsi'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    public function beforeAction($action)
    {
        if(isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role  == Roles::ROLE_ADMIN){
            $this->layout = '@app/views/layouts-lte/main.php';
        }
        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }
        
        if( isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role == Roles::ROLE_ADMIN){
            $this->layout = '@app/views/layouts-lte/main.php';
            return $this->redirect(['/report']);
        }
        $request = Yii::$app->request->get();
        $tahun = isset($request['tahun']) && $request['tahun'] ? $request['tahun'] : date('Y');
        $bulan = isset($request['bulan']) && $request['bulan'] ? $request['bulan'] : null;
        $idProvinsi = null;
        $provinsi = null;
        if( isset($request['provinsi']) && $request['provinsi']){
            $idProvinsi = Provinsi::find()->where(['path'=> preg_replace("/[^0-9]/", "", $request['provinsi']) ])->one()->id;
            $provinsi = $request['provinsi'];
        }
        
        $dataDetail = Report::getDataDetail($tahun,$idProvinsi, $bulan);
        $columns = array_column($dataDetail, 'total');
        array_multisort($columns, SORT_DESC, $dataDetail);

        $arrDetail = [];
        foreach ($dataDetail as $key => $value) {
            $arrDetail[$value['id']] = $value;
        }
        ArrayHelper::map($dataDetail,'id', function($d){
            return $d;
        });


        $totalTangkapan  = 0;
        foreach ($dataDetail as $key => $value) {
           $totalTangkapan+=$value['total'];
        }
        $kasusTertinggi = Report::getKasusTertinggi($tahun, $bulan);
        $nko = CapaianKinerja::getNko($tahun);
        $nko_color = 'red';
        $text_nko = 'text-danger';
        if(round($nko) > 80 and round($nko) < 100){
            $nko_color = 'orange';
            $text_nko = 'text-warning';
        }
        elseif(round($nko) >= 100){
            $nko_color = 'green';
            $text_nko  = ' text-success';
        }
        $seluruhIndo = Report::getDataSeluruhIndonesia($tahun, $idProvinsi, $bulan);
        $member = [
            'standby' => Member::getTotalByStatus(Member::STATUS_STANDBY),
            'tugas' => Member::getTotalByStatus(Member::STATUS_DALAM_TUGAS)
        ];
        $prov = ArrayHelper::map(Provinsi::find()->all(), function($model){return 'path'. $model->path;}, 'id');
        $location = [];
        $caseBulan = [];
        foreach ($prov as $key => $id) {
            $location[$key] = Provinsi::getCountAnngota($id);
            $tC = Provinsi::getCaseBulan($id, $tahun);
            $bgC = '#198754';
            if(isset($tC[0]) && $tC[0]){
                $bgC = '#ffc107';
                if($tC[0] > 5){
                    $bgC = '#dc3545';
                }
            }
            $caseBulan[$key] = $bgC;
        }


        $bulanJnpp = Bimtek::optionsBulanShort();
        $dataJnpp = [];
        foreach ($bulanJnpp as $key => $value) {
            $d = Report::getJnppData($tahun, $key);
            $kasusJnpp = 0;
            $totalJnpp = 0;
            if($d){
                $kasusJnpp = $d['dar'] + $d['lau'] + $d['uda'];
                $totalJnpp = $d['tangkapan'] /1000;
            }
            $dt = [
                'label' => $value,
                'kasus' => $kasusJnpp,
                'tangkapan' => $totalJnpp
            ];
            $dataJnpp[] = $dt;
        }
        return $this->render('index', [
            'data' => $seluruhIndo, 'tahun' => $tahun, 'provinsi' => $provinsi,
            'detail' => $arrDetail, 'total' => $totalTangkapan, 'case' => $kasusTertinggi, 
            'bulan' => $bulan, 'nko' => $nko, 'member' => $member,
            'dipa' => Anggaran::getSisaDipa($tahun),
            'dokppn' => Anggaran::getSisaDokppn($tahun),
            'locations' => json_encode($location),
            'jnpp' => json_encode($dataJnpp),
            'nko_color' => $nko_color,
            'text_nko' => $text_nko,
            'caseBulan' => json_encode($caseBulan),
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionGetDetailProvinsi(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request->get();
        if(!isset($request['code'])){
            return;
        }
        $page  = isset($request['page']) && $request['page'] > 0 ? $request['page']-1 : 0;
        $tahun = isset($request['tahun']) && $request['tahun'] ? $request['tahun'] : date('Y');
        $c = isset($request['c']) && $request['c']  ? $request['c'] : null;
        $searchModel = new ReportSearch();
        $searchModel->pg = $page;
        $searchModel->tahun = $tahun;
        $searchModel->c = $c;
        $provinsi =  Provinsi::find()->where(['path' => preg_replace("/[^0-9]/", "", $request['code'])])->one();
        $searchModel->id_provinsi = $provinsi->id;
        $dataProvider = $searchModel->searchUser($this->request->queryParams);
        $data = [];
        foreach ($dataProvider->getModels() as $d) {
            $data[] = [
                'date' => $d->getReportedDate(),
                'udara' => round($d->udara),
                'darat' => round($d->darat),
                'laut' => round($d->laut),
                'total' => $d->getTotalGr(true),
                'meth' => $d->getMeth(true),
                'cocaine' => $d->getCocaine(true),
                'ganja' => $d->getGanja(true),
                'mdma' => $d->getMdma(true),
                'lainnya' => $d->getLainnya(true),
                'surat_tugas' => $d->nomor_surat,
                'surat_tugas_url' => $d->surat_tugas,
                'laporan' => $d->laporan
            ];
        }
        $pagesize = $dataProvider->pagination->pageSize;

        $total = $dataProvider->totalCount; 

        return [
            'name' => $provinsi->name,
            'totalPage' => (int) (($total + $pagesize - 1) / $pagesize),
            'page' => $page+1,
            'data' => $data
        ];
    }
}
