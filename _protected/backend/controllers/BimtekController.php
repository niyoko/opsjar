<?php

namespace backend\controllers;

use backend\components\MyAlert;
use backend\models\Bimtek;
use backend\models\search\BimtekSearch;
use common\components\Roles;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BimtekController implements the CRUD actions for Bimtek model.
 */
class BimtekController extends Controller
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
                        [
                            'actions' => ['index'],
                            'allow' => true,
                            'roles' => [Roles::ROLE_USER]
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
     * Lists all Bimtek models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BimtekSearch();
       
        $this->loadParams($searchModel);
        $dataProvider = $searchModel->search($this->request->queryParams);

        if(Yii::$app->user->identity->role == Roles::ROLE_USER){
            return $this->render('index_user', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        else{
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        
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
    }

    /**
     * Displays a single Bimtek model.
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
     * Creates a new Bimtek model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Bimtek();

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $date = explode( ' ',$model->date_start); 
            $model->date_start = $date[0];
            $model->date_end = $date[2];
            $model->tahun = date("Y", strtotime($model->date_start));
            if ($model->save()) {
                \Yii::$app->session->setFlash('info', MyAlert::success('<b>Sukses!</b> Berhasil memperbarui data.'));
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Bimtek model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->date_start = implode(' ', [$model->date_start, '-', $model->date_end]);
        if ($this->request->isPost) {
            $model->load($this->request->post());
            $date = explode( ' ',$model->date_start); 
            $model->date_start = $date[0];
            $model->date_end = $date[2];
            $model->tahun = date("Y", strtotime($model->date_start));
            if($model->save()){
                \Yii::$app->session->setFlash('info', MyAlert::success('<b>Sukses!</b> Berhasil memperbarui data.'));
                return $this->redirect(['index']);
            }
           
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Bimtek model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        \Yii::$app->session->setFlash('info', MyAlert::success('<b>Sukses!</b> Berhasil menghapus data.'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the Bimtek model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Bimtek the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bimtek::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
