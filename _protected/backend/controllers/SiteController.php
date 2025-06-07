<?php

namespace backend\controllers;

use backend\models\Anggaran;
use backend\models\Bimtek;
use backend\models\CapaianKinerja;
use backend\models\Kantor;
use backend\models\Member;
use backend\models\Provinsi;
use backend\models\search\ReportSearch;
use common\components\Roles;
use common\models\LoginForm;
use console\components\Command;
use Yii;
use yii\filters\AccessControl;
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
                        'actions' => ['logout', 'index', 'migrate', 'logout', 'get-detail-provinsi'],
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
        if (isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role  == Roles::ROLE_ADMIN) {
            $this->layout = '@app/views/layouts-lte/main.php';
        }
        return parent::beforeAction($action);
    }

    public function actionMigrate()
    {
        return $this->asJson(Command::execute("migrate/up", ['interactive' => false]));
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $years = Yii::$app->db->createCommand('
          SELECT tahun FROM (
          SELECT tahun FROM analytics_jenis_npp UNION
          SELECT tahun FROM analytics_kanwil UNION
          SELECT tahun FROM analytics_moda UNION
          SELECT tahun FROM analytics_potensi_penyelamatan UNION
          SELECT tahun FROM analytics_total_npp
          ) x ORDER BY tahun DESC
        ')->queryColumn();
        if (empty($years)) {
            $years = [date('Y')];
        }

        $selectedYear = isset($_GET['tahun']) ? $_GET['tahun'] : $years[0];

        $this->layout = '@app/views/layouts/main.php';

        $allOffice = Kantor::find()
            ->select(['id', 'name', 'shortname', 'id_provinsi', 'coordinate', 'parent_id'])
            ->asArray()
            ->all();

        $allProv = Provinsi::find()
            ->select(['id', 'name', 'office_id', 'path_data', 'background_color'])
            ->asArray()
            ->all();

        $anggota = Member::find()
            ->select([
                'id',
                'name',
                'photo',
                'id_office'
            ])->asArray()
            ->all();

        $totalNpp = Yii::$app->db->createCommand('
          SELECT COALESCE(SUM(kasus), 0) kasus, COALESCE(SUM(berat_gr), 0) berat FROM analytics_total_npp WHERE tahun = :tahun
        ', ['tahun' => $selectedYear])->queryOne();

        $totalPenghematan = Yii::$app->db->createCommand('
          SELECT COALESCE(SUM(penghematan_rp), 0) rp, COALESCE(SUM(jiwa), 0) jiwa FROM analytics_potensi_penyelamatan WHERE tahun = :tahun
        ', ['tahun' => $selectedYear])->queryOne();

        $moda = Yii::$app->db->createCommand('
          SELECT perlintasan, SUM(kasus) kasus, SUM(berat) berat FROM analytics_moda WHERE tahun = :tahun GROUP BY perlintasan
          ORDER BY SUM(berat) DESC
        ', ['tahun' => $selectedYear])->queryAll();


        return $this->render('index', [
            'allOffice' => $allOffice,
            'dataProvinsi' => $allProv,
            'anggota' => $anggota,
            'years' => $years,
            'selectedYear' => $selectedYear,
            'totalKasus' => $totalNpp['kasus'],
            'totalBerat' => $totalNpp['berat'],
            'totalPenghematan' => $totalPenghematan['rp'],
            'totalJiwa' => $totalPenghematan['jiwa'],
            'moda' => $moda,
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

    public function actionGetDetailProvinsi()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request->get();
        if (!isset($request['code'])) {
            return;
        }
        $page  = isset($request['page']) && $request['page'] > 0 ? $request['page'] - 1 : 0;
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
            'page' => $page + 1,
            'data' => $data
        ];
    }
}
