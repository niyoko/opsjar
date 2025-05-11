<?php

namespace backend\controllers;

use backend\components\MyAlert;
use common\components\MyFormatter;
use backend\models\Narkotika;
use backend\models\Report;
use backend\models\ReportDetail;
use backend\models\search\ReportSearch;
use common\components\Roles;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ReportController implements the CRUD actions for report model.
 */
class ReportController extends Controller
{
     /**
     * @inheritDoc
     */
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
                            'actions' => ['create', 'update', 'delete', 'view','index', 'manajemen'],
                            'allow' => true,
                            'roles' => [Roles::ROLE_ADMIN]
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
        elseif(Yii::$app->user->identity->role == Roles::ROLE_USER){
            $this->redirect('index');
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all report models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReportSearch();
        $searchModel = $this->loadParams($searchModel);
        $dataProvider = $searchModel->search($this->request->queryParams);
       
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single report model.
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
     * Creates a new report model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Report();
        $model->date = date('Y-m-d');
        $jenisNarkotika = Narkotika::optionsAll();
        if ($this->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->load($this->request->post()) ;
                $model->darat = MyFormatter::removeFormatNumber($model->darat);
                $model->udara = MyFormatter::removeFormatNumber($model->udara);
                $model->laut = MyFormatter::removeFormatNumber($model->laut);
                $model->tahun = date('Y', strtotime($model->date));      
                $model->setProvinsi();
                if ($model->save()) {
                    $requestNarkotika = $_POST['narkotika'];
                    $index = 0;
                    foreach (Narkotika::optionsAll() as $key => $value) {
                        $detail = new ReportDetail();
                        $detail->id_report = $model->id;
                        $detail->id_jenis_narkotika =  $key;
                        $detail->total = isset($requestNarkotika[$index]) ? MyFormatter::removeFormatNumber($requestNarkotika[$index]) : 0;
                        if(!$detail->save()){
                            throw new Exception("Error Processing Request ". $detail->getErrors(), 400);
                            
                        }
                        $index++;
                    }

                    $transaction->commit();
                    \Yii::$app->session->setFlash('info', MyAlert::success('<b>Sukses!</b> Berhasil memperbarui data.'));
                    return $this->redirect(['index']);
                }
            } catch (\Exception $e) {
               $transaction->rollBack();
            }
            
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'narkotika' => $jenisNarkotika
        ]);
    }

    /**
     * Updates an existing report model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $jenisNarkotika = Narkotika::optionsAll();
        $modelDetail = ArrayHelper::map(ReportDetail::find()->where(['id_report' => $model->id])->orderBy('id_jenis_narkotika asc')->all(),'id_jenis_narkotika', 'total');
        $model->nmormalisasiKasus();
        if ($this->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->load($this->request->post()) ;
                $model->darat = MyFormatter::removeFormatNumber($model->darat);
                $model->udara = MyFormatter::removeFormatNumber($model->udara);
                $model->laut = MyFormatter::removeFormatNumber($model->laut);
                $model->tahun = date('Y', strtotime($model->date));
                $model->setProvinsi();
                if ($model->save()) {
                    $requestNarkotika = $_POST['narkotika'];
                    $index = 0;
                    foreach (Narkotika::optionsAll() as $key => $value) {
                        $detail = ReportDetail::find()->where(['id_report' => $model->id, 'id_jenis_narkotika' => $key])->one();
                        $detail->id_report = $model->id;
                        $detail->id_jenis_narkotika =  $key;
                        $detail->total = isset($requestNarkotika[$index]) ? MyFormatter::removeFormatNumber($requestNarkotika[$index]) : 0;
                        if(!$detail->save()){
                            throw new Exception("Error Processing Request ". $detail->getErrors(), 400);
                            
                        }
                        $index++;
                    }

                    $transaction->commit();
                    \Yii::$app->session->setFlash('info', MyAlert::success('<b>Sukses!</b> Berhasil memperbarui data.'));
                    return $this->redirect(['index']);
                }
            } catch (\Exception $e) {
               $transaction->rollBack();
               throw new Exception("Error Processing Request ". $e->getMessage(), 400);
               
            }
        }

        return $this->render('update', [
            'model' => $model,
            'narkotika' => $jenisNarkotika,
            'modelDetail' => $modelDetail
        ]);
    }

    /**
     * Deletes an existing report model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {   

        ReportDetail::deleteAll(['id_report' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the report model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return report the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = report::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function loadParams($searchModel){
        $request = Yii::$app->request->get();
        if(isset($request['tahun'])){
            $searchModel->tahun = $request['tahun'];
        }
        if(isset($request['bulan'])){
            $searchModel->bulan = $request['bulan'];
        }
        if(isset($request['name'])){
            $searchModel->name = $request['name'];
        }
        return $searchModel;
    }
}
