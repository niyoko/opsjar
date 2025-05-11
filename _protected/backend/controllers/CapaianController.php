<?php

namespace backend\controllers;

use backend\components\MyAlert;
use backend\models\CapaianIku;
use backend\models\CapaianKinerja;
use backend\models\CapaianTrenKinerja;
use common\components\MyFormatter;
use common\components\Roles;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class CapaianController extends \yii\web\Controller
{

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
                            'actions' => ['index'],
                            'allow' => true,
                            'roles' => [Roles::ROLE_ADMIN]
                        ],
                        [
                            'actions' => ['index'],
                            'allow' => true,
                            'roles' => [Roles::ROLE_USER],
                        ],
                    ],
                ],
            ]
        );
    }

    
    public function actionIndex()
    {
        $tahun = date('Y');
        $modelIku =  $this->findModelIku($tahun);
        $modelKinerja = $this->findModelKinerja($tahun);
        $modelTren = $this->findModelTren($tahun);
        $modelTrenId = $this->findModelTrenId($tahun);
        if(isset($_POST['CapaianIku'], $_POST['CapaianKinerja'], $_POST['submitted']) && $_POST['submitted']){
            $modelIku->attributes = $_POST['CapaianIku'];
            $modelIku->tahun = $tahun;
            $modelIku->removeAllFormatNumber();
            if(!$modelIku->save()){
                throw new Exception("Error Processing Request ". $modelIku->getErrors(), 400);
                
            }
            $modelKinerja->attributes = $_POST['CapaianKinerja'];
            $modelKinerja->tahun = $tahun;
            $modelKinerja->removeAllFormatNumber();
            if(!$modelKinerja->save()){
                throw new Exception("Error Processing Request ". $modelKinerja->getErrors(), 400);
                
            }


            if(isset($_POST['months'], $_POST['values'])){
                foreach ($_POST['values'] as $key => $value) {
                    if(isset($modelTrenId[$_POST['months'][$key]])){
                        CapaianTrenKinerja::updateAll(['value' => $value], ['tahun' => $tahun, 'id' => $modelTrenId[$_POST['months'][$key]]]);
                    }
                    else{
                        $ctk = new CapaianTrenKinerja();
                        $ctk->tahun = $tahun;
                        $ctk->value = $value;
                        $ctk->month = $_POST['months'][$key];
                        if(!$ctk->save()){
                            throw new Exception("Error Processing Request ". $ctk->getErrors(), 400);
                            
                        }
                    }
                }
            }
            \Yii::$app->session->setFlash('info', MyAlert::success('<b>Sukses!</b> Berhasil memperbarui data.'));
            return $this->redirect(['index']);
            
            
        }

        if(Yii::$app->user->identity->role == Roles::ROLE_ADMIN){
            $modelKinerja->formatAllField();
            return $this->render('index', [
                'modelIku' => $modelIku,
                'modelKinerja' => $modelKinerja,
                'modelTren' => $modelTren
            ]);
        }
        else{
            $stakeHoldersValue = isset($modelKinerja->stakeholders_value) ? $modelKinerja->stakeholders_value: 0;
            $stakeHoldersSisa = isset($modelKinerja->stakeholders_value) ? 120 - $modelKinerja->stakeholders_value : 0 ;
            $stakeHoldersPercentage = isset($modelKinerja->stakeholders_percentage) ? $modelKinerja->stakeholders_percentage: 0;
            
            $internalBussinessValue = isset($modelKinerja->internal_business_process_value) ? $modelKinerja->internal_business_process_value : 0;
            $internalBussinessSisa = isset($modelKinerja->internal_business_process_value) ? 120 - $modelKinerja->internal_business_process_value : 0;
            $internalBussinessPercentage = isset($modelKinerja->internal_business_process_percentage) ? $modelKinerja->internal_business_process_percentage : 0;

            $learningGrowthValue = isset($modelKinerja->learning_growth_value) ? $modelKinerja->learning_growth_value : 0;
            $learningGrowthSisa = isset($modelKinerja->learning_growth_value) ? 120 - $modelKinerja->learning_growth_value: 0;
            $learningGrowthPercentage = isset($modelKinerja->learning_growth_percentage) ? $modelKinerja->learning_growth_percentage : 0;
            
            
            $getColor = function ($percentage)  {
                $color = '#FF3E3E';
                if($percentage > 80 && $percentage < 100){
                    $color = '#FBB03B';
                }
                elseif($percentage >= 100){
                    $color = '#45CD39';
                }
                return $color;
            };

            
            $nko_color = 'red';
            if(round($modelKinerja->nko) > 80 and round($modelKinerja->nko) < 100){
                $nko_color = 'orange';
                $text_nko = 'text-warning';
            }
            elseif(round($modelKinerja->nko) >= 100){
                $nko_color = 'green';
                $text_nko  = ' text-success';
            }

            // $modelKinerja->roundAllField();
            return $this->render('index_user', [
                'modelIku' => $modelIku,
                'modelKinerja' => $modelKinerja,
                'modelTren' => $modelTren,
                'stakeHolders' => [
                    'value' => $stakeHoldersValue,
                    'sisa' => $stakeHoldersSisa,
                    'percentage' => round($stakeHoldersPercentage),
                    'color' => $getColor($stakeHoldersValue)
                ],
                'internalBussiness' => [
                    'value' => $internalBussinessValue,
                    'sisa' => $internalBussinessSisa,
                    'percentage' => round($internalBussinessPercentage),
                    'color' => $getColor($internalBussinessValue)
                ],
                'learningGrowth' => [
                    'value' => $learningGrowthValue,
                    'sisa' => $learningGrowthSisa,
                    'percentage' => round($learningGrowthPercentage),
                    'color' => $getColor($learningGrowthValue)
                ],
                'month' => json_encode(CapaianTrenKinerja::getData($tahun)),
                'nko_color' => $nko_color
            ]);
        }
        
    }

    private function findModelIku($tahun){
        $iku = CapaianIku::find()->where(['tahun' => $tahun])->one() ;
        
        if(!$iku){
            $iku = new CapaianIku();
        }
        $iku->roundAllField();
        return $iku;
    }

    private function findModelKinerja($tahun){
        $kinerja = CapaianKinerja::find()->where(['tahun' => $tahun])->one();
        if(!$kinerja){
            $kinerja =  new CapaianKinerja();
        }
        // $kinerja->roundAllField();
        return $kinerja;
    }

    private function findModelTrenId($tahun){
        return  ArrayHelper::map(CapaianTrenKinerja::find()->where(['tahun' => $tahun])->orderBy('month asc')->all(), 'month', 'id');
    }

    private function findModelTren($tahun){
        return  ArrayHelper::map(CapaianTrenKinerja::find()->where(['tahun' => $tahun])->orderBy('month asc')->all(), 'month', function($item){
            return round($item->value);
        });
    }

}
