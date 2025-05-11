<?php

namespace backend\controllers;

use backend\models\Provinsi;
use backend\models\search\JaringanSearch;
use backend\models\search\ProvinsiSearch;
use backend\models\search\XraySearch;
use common\components\Roles;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ProvinsiController implements the CRUD actions for Provinsi model.
 */
class ProvinsiController extends Controller
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
                            'actions' => ['create', 'update', 'delete', 'view','index', 'manajemen', 'get-dokumen','update-dokumen','jaringan'],
                            'allow' => true,
                            'roles' => [Roles::ROLE_ADMIN]
                        ],
                        [
                            'actions' => ['view'],
                            'allow' => true,
                            'roles' => [Roles::ROLE_USER],
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
     * Lists all Provinsi models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProvinsiSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionJaringan()
    {
        $searchModel = new JaringanSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('jaringan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Provinsi model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $request = Yii::$app->request->get();
        $name  = isset($request['name']) ? $request['name'] : '';
        $tahun  = isset($request['tahun']) ? $request['tahun'] : date('Y');
        $searchModel = new ProvinsiSearch();
        $searchModel->name = $name;
        // $searchModel->tahun  = $tahun;
        $dataProvider = $searchModel->search($this->request->queryParams);

        $searchModelJaringan = new JaringanSearch();
        $searchModelJaringan->name = $name;
        // $searchModelJaringan->tahun  = $tahun;
        $dataProviderJaringan = $searchModelJaringan->search($this->request->queryParams);

        $searchModelXray = new XraySearch();
        $searchModelXray->name = $name;
        $searchModelXray->tahun  = $tahun;
        $dataProviderXray = $searchModelXray->search($this->request->queryParams);

        return $this->render('index_user', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelJaringan' => $searchModelJaringan,
            'dataProviderJaringan' => $dataProviderJaringan,
            'searchModelXray' => $searchModelXray,
            'dataProviderXray' => $dataProviderXray,
            'name' => $name,
            'tahun' => $tahun
        ]);
    }

    /**
     * Creates a new Provinsi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Provinsi();

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
     * Updates an existing Provinsi model.
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
     * Deletes an existing Provinsi model.
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
     * Finds the Provinsi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Provinsi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Provinsi::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMap(){
        return $this->render('map', [
            'model' => [],
        ]);
    }

    public function actionGetDokumen(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request->get();
        $provinsi  = Provinsi::findOne($request['id']);
        $date = '';
        $link = '';
        if($provinsi){
            $date = $provinsi->dokumen_update_date ?: date('Y-m-d');
            $link = $provinsi->dokumen_kerawanan;
        }

        return [
            'name' => $provinsi->name,
            'link' => $link,
            'date' => $date
        ];
    }

    public function actionUpdateDokumen(){
       $request =  Yii::$app->request->post();
       if(isset($request['prov'])){
            $model = Provinsi::findOne($request['prov']);
            if($model){
                $model->dokumen_update_date =  isset($request['Provinsi']['dokumen_update_date']) ? $request['Provinsi']['dokumen_update_date'] : $model->dokumen_update_date;
                $model->dokumen_kerawanan =  isset($request['Provinsi']['dokumen_kerawanan']) ? $request['Provinsi']['dokumen_kerawanan'] : $model->dokumen_kerawanan;
                if(!$model->save()){
                    throw new Exception("Error Processing Request", 1);
                    
                }
            }

       }
       return $this->redirect(['index']);
    }
}
