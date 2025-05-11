<?php

namespace backend\controllers;

use backend\components\MyAlert;
use common\components\MyFormatter;
use backend\models\Anggaran;
use backend\models\AnggaranDetail;
use backend\models\Bimtek;
use backend\models\search\AnggaranSearch;
use common\components\Roles;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * AnggaranController implements the CRUD actions for Anggaran model.
 */
class AnggaranController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'ruleConfig' => [
                        'class' => \backend\components\AccessRule::className(),
                    ],
                    'rules' => [
                        [
                            'actions' => ['index','create', 'unduh'],
                            'allow' => true,
                            'roles' => [Roles::ROLE_ADMIN]
                        ],
                        [
                            'actions' => ['index'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    public function beforeAction($action)
    {
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }
        if(Yii::$app->user->identity->role == Roles::ROLE_ADMIN){
            $this->layout = '@app/views/layouts-lte/main.php';
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Anggaran models.
     *
     * @return string
     */
    public function actionIndex()
    {

        $tahun = isset($_GET['tahun']) ? $_GET['tahun']: date("Y");
        $anggaran = $this->findModelAnggaran($tahun);
        // print_r($anggaran); die;
        $anggaranDetail = $this->findModelAnggaranDetail($tahun);
        if ($this->request->isPost) {
            $request = Yii::$app->request->post();
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $anggaran[Anggaran::TYPE_OPERATION]=[
                    'budget' => MyFormatter::removeFormatNumber($request['anggaran-'.Anggaran::TYPE_OPERATION]),
                    'realisasi' => MyFormatter::removeFormatNumber($request['penggunaan-'.Anggaran::TYPE_OPERATION]),
                ];
    
                $anggaran[Anggaran::TYPE_BIMTEK]=[
                    'budget' => MyFormatter::removeFormatNumber($request['anggaran-'.Anggaran::TYPE_BIMTEK]),
                    'realisasi' => MyFormatter::removeFormatNumber($request['penggunaan-'.Anggaran::TYPE_BIMTEK]),
                ];

                $tahun = $request['tahun-input'];

                $anggaranOps = Anggaran::find()->where(['tahun' => $tahun, 'type' => Anggaran::TYPE_OPERATION])->one();
                if($anggaranOps){
                    Anggaran::updateAll(['budget' => $anggaran[Anggaran::TYPE_OPERATION]['budget'], 'realisasi' => $anggaran[Anggaran::TYPE_OPERATION]['realisasi']], ['id' => $anggaranOps->id]);
                }
                else{
                    $mA = new Anggaran(['type' => Anggaran::TYPE_OPERATION,'budget' => $anggaran[Anggaran::TYPE_OPERATION]['budget'] , 'realisasi' => $anggaran[Anggaran::TYPE_OPERATION]['realisasi'], 'tahun' => $tahun ]);
                    if(!$mA->save()){
                        throw new Exception("Error Processing Request ". $mA->getErrors(), 400);
                        
                    }
                }

                $anggaranBimtek = Anggaran::find()->where(['tahun' => $tahun, 'type' => Anggaran::TYPE_BIMTEK])->one();
                if($anggaranBimtek){
                    Anggaran::updateAll(['budget' => $anggaran[Anggaran::TYPE_BIMTEK]['budget'], 'realisasi' => $anggaran[Anggaran::TYPE_BIMTEK]['realisasi']], ['id' => $anggaranBimtek->id]);
                }
                else{
                    $mA = new Anggaran(['type' => Anggaran::TYPE_BIMTEK,'budget' => $anggaran[Anggaran::TYPE_BIMTEK]['budget'] , 'realisasi' => $anggaran[Anggaran::TYPE_BIMTEK]['realisasi'], 'tahun' => $tahun ]);
                    if(!$mA->save()){
                        throw new Exception("Error Processing Request ". $mA->getErrors(), 400);
                        
                    }
                }

                if(isset($request['anggaran_months_value'], $request['penggunaan_months_value'])){
                    $this->saveAnggaranDetail($request);
                }

                $transaction->commit();
                \Yii::$app->session->setFlash('info', MyAlert::success('<b>Sukses!</b> Berhasil memperbarui data.'));
                return $this->redirect(['index']);
            } catch (\Exception $th) {
                $transaction->rollBack();
                throw new Exception("Error Processing Request " . $th->getMessage(), 400);
            }
           
        }
        $rekap = ArrayHelper::map(Anggaran::find()->groupBy('tahun')->all(), 'tahun', 'tahun');

        if(Yii::$app->user->identity->role == Roles::ROLE_ADMIN){
            
            return $this->render('index', [
                'anggaran' => $anggaran,
                'anggaranDetail' => $anggaranDetail,
                'tahun' => $tahun,
                'rekap' => $rekap,
                
            ]);
        }
        else{
            return $this->render('index_user', [
                'anggaran' => $anggaran,
                'anggaranDetail' => $anggaranDetail,
                'tahun' => $tahun,
                'rekap' => $rekap,
                'bimtek' => Anggaran::getDataAnggaran(Anggaran::TYPE_BIMTEK, $tahun),
                'operasional' => Anggaran::getDataAnggaran(Anggaran::TYPE_OPERATION, $tahun),
                'month' => json_encode(Anggaran::getDataAnggaranBulanan($tahun))
            ]);
        }
    }

    /**
     * Displays a single Anggaran model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Anggaran model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Anggaran();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Anggaran model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Anggaran model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Anggaran model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Anggaran the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Anggaran::findOne(['id' => $id])) !== null) {
            return $model;
        }

        return new Anggaran();
    }

    private function findModelAnggaran($tahun){
        $anggaran = Anggaran::find()->where(['tahun' => $tahun])->orderBy('type')->all();
        $data = [
            Anggaran::TYPE_OPERATION => [
                'budget' => 0,
                'realisasi' => 0,
            ],
            Anggaran::TYPE_BIMTEK => [
                'budget' => 0,
                'realisasi' => 0,
            ]
        ];
        if($anggaran){
            foreach ($anggaran as $key => $value) {
                $data[$value->type] = [
                    'budget' => round($value->budget),
                    'realisasi' => round($value->realisasi)
                ];
            }
        }
       

        return $data;
       
    }

    private function findModelAnggaranDetail($tahun){
        $anggaran = ArrayHelper::map(AnggaranDetail::find()->where(['tahun' => $tahun])->orderBy('month')->all(), 'month', function($item){
            return $item;
        });
        $data = [];
        foreach (Bimtek::optionsBulan() as $key => $value) {
            $budget = 0;
            $realisasi = 0;
            if(isset($anggaran[$key])){
                $budget = round($anggaran[$key]->budget);
                $realisasi = round($anggaran[$key]->realisasi);
            }

            $data[$key] = [
                'budget' => $budget,
                'realisasi' => $realisasi
            ];
        }

        return $data;
       
    }

    public function saveAnggaranDetail($request){
        $tahun = $request['tahun-input'];
        $anggaran = $request['anggaran_months_value'];
        $penggunaan=  $request['penggunaan_months_value'];
        $month = $request['anggaran_months'];
        foreach ($anggaran as $key => $a) {
            $detail = AnggaranDetail::find()->where(['tahun' => $tahun, 'month' => $month[$key]])->one();
            if($detail){
                $detail->budget = MyFormatter::removeFormatNumber($a);
                $detail->realisasi = MyFormatter::removeFormatNumber($penggunaan[$key]);
            }
            else{
                $detail = new AnggaranDetail(['tahun' => $tahun, 'month' => $month[$key], 'budget' => MyFormatter::removeFormatNumber($a), 'realisasi' => MyFormatter::removeFormatNumber($penggunaan[$key])]);
            }
            if(!$detail->save()){
                throw new Exception("Error Processing Request ". $detail->getErrors(), 400);
                
            }
        }
    }

    public function actionUnduh(){
        $request =  Yii::$app->request->get();
        if(!isset($request['tahun'])){
            throw new Exception("Butuh tahun anggaran", 400);
        }

        $anggaran = $this->findModelAnggaran($request['tahun']);
        $anggaranDetail = $this->findModelAnggaranDetail($request['tahun']);

        $file = \Yii::getAlias('@webroot') . '/template/anggaran.xlsx';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getProperties()->setCreator('Opsjar');
        $spreadsheet->getProperties()->setLastModifiedBy('Opsjar');
        $spreadsheet->getProperties()->setTitle('Opsjar Anggaran ' . $request['tahun']);
        $spreadsheet->getActiveSheet()->setCellValue('B2', $anggaran[Anggaran::TYPE_OPERATION]['budget']);
        $spreadsheet->getActiveSheet()->setCellValue('B3', $anggaran[Anggaran::TYPE_OPERATION]['realisasi']);
        $spreadsheet->getActiveSheet()->setCellValue('C2', $anggaran[Anggaran::TYPE_BIMTEK]['budget']);
        $spreadsheet->getActiveSheet()->setCellValue('C3', $anggaran[Anggaran::TYPE_BIMTEK]['realisasi']);
        $i = 0;
        $col = 'B';
        $col2 = 'B';
        foreach (Bimtek::optionsBulan() as $key => $value){
            if($i < 6){
                $spreadsheet->getActiveSheet()->setCellValue($col.'6', $anggaranDetail[$key]['budget']);
                $spreadsheet->getActiveSheet()->setCellValue($col.'7', $anggaranDetail[$key]['realisasi']);
                $col++;
            }
            else{
                $spreadsheet->getActiveSheet()->setCellValue($col2.'10', $anggaranDetail[$key]['budget']);
                $spreadsheet->getActiveSheet()->setCellValue($col2.'11', $anggaranDetail[$key]['realisasi']);
                $col2++;
            }
            $i++;
        }
        
        $local_file = \Yii::getAlias('@webroot') . '/template/anggaran-' . $request['tahun'] . '.xlsx';
        $writer->save($local_file);
        $content = file_get_contents($local_file);
        header("Content-Disposition: attachment; filename=".$local_file);

        unlink($local_file);
        exit($content);

    }
}
