<?php

namespace backend\controllers;

use backend\components\MyAlert;
use backend\models\Member;
use backend\models\search\MemberSearch;
use common\components\Roles;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * MemberController implements the CRUD actions for Member model.
 */
class AnggotaController extends Controller
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
     * Lists all Member models.
     *
     * @return string
     */
    public function actionIndex()
    {

        $searchModel = new MemberSearch();
        $this->loadParams($searchModel);
        if(Yii::$app->user->identity->role == Roles::ROLE_ADMIN){
            $searchModel->pageSize = 10;
            $page = 1;
            if(isset($params['page'])){
                $page = $params['page'] - 1;
                if($page < 0){
                    $page = 0;
                }
                
            }
            $dataProvider = $searchModel->search($this->request->queryParams); 
        }
        else{
            $params = $this->request->queryParams;
            $page = 0;
            if(isset($params['page'])){
                $page = $params['page'] - 1;
                if($page < 0){
                    $page = 0;
                }
                
            }
            $searchModel->page = $page;
            $dataProvider = $searchModel->searchMember($this->request->queryParams); 
        }
               

        if(Yii::$app->user->identity->role == Roles::ROLE_ADMIN){
            
            return $this->render('manajemen', [
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

    /**
     * Displays a single Member model.
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
     * Creates a new Member model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Member();

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->file = UploadedFile::getInstance($model,'file');
            if(!empty($model->file)){
                $model->upload();
            }
            $model->file = null;
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
     * Updates an existing Member model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->file = UploadedFile::getInstance($model,'file');
            if(!empty($model->file)){
                $model->upload();
            }
            $model->file = null;
            if ($model->save()) {
                \Yii::$app->session->setFlash('info', MyAlert::success('<b>Sukses!</b> Berhasil memperbarui data.'));
                return $this->redirect(['index']);
            }
        } 
        

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Member model.
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
     * Finds the Member model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Member::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    

    public function actionManajemen(){
        $searchModel = new MemberSearch();
        $this->loadParams($searchModel);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('manajemen', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    private function loadParams($searchModel){
        $request = Yii::$app->request->get();
        if(isset($request['status'])){
            $searchModel->status = $request['status'];
        }
        if(isset($request['name'])){
            $searchModel->name = $request['name'];
        }
    }
}
