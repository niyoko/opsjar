<?php

namespace backend\models;

use common\components\Roles;
use Yii;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\rbac\Role;

/**
 * This is the model class for table "provinsi".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 */
class Provinsi extends \common\models\Provinsi
{
   public static function getOptionsMap()
   {
        return ArrayHelper::map(self::find()->where(['status' => 1])->orderBy('name asc')->all(), function($item){return 'path'.$item->path;}, 'name');
   }

   public static function getOptions(){
      return ArrayHelper::map(self::find()->where(['status' => 1])->orderBy('name asc')->all(), 'id', 'name');
   }

   public function getActionButton(){
      if(Yii::$app->user->identity->role == Roles::ROLE_USER){
         return $this->dokumen_kerawanan ? Html::a('Unduh Dokumen', $this->dokumen_kerawanan, ['class' => 'text-warning', 'target' => '_blank']): '<span class="text-muted"><i>Dokumen Belum Tersedia</i></span>';
      }
      $btnUnduh = Html::a('<i class="material-icons-round">download</i> Unduh', $this->dokumen_kerawanan, ['class' => 'btn btn-outline-primary ml-1', 'target' => '_blank']);
      $btnUnggah = Html::a('<i class="material-icons-round">upload</i> Unggah Dokumen', '#', ['class' => 'btn btn-outline-success btn-modal', 'target' => '_blank', 'type' =>'button', 'data-id' => $this->id, 'data-toggle' => 'modal', 'data-target' => '#modalDokumen']);
      $btnUbah = Html::a('<i class="material-icons-round">edit</i> Ubah', '#', ['class' => 'btn btn-outline-warning btn-modal', 'target' => '_blank', 'type' =>'button' ,'data-id' => $this->id, 'data-toggle' => 'modal', 'data-target' => '#modalDokumen']);
      
      return $this->dokumen_kerawanan ? $btnUbah . $btnUnduh : $btnUnggah;
   }

   public static function getIdByCode($code){
      $provinsi = Provinsi::find()->where(['path' => $code])->one();
      return $provinsi ? $provinsi->id : null;
   }

   public static function getCountAnngota($id_provinsi)
   {
        $query = new Query();
        $query->from('provinsi');
        $query->where(['id' => $id_provinsi]);
        $query->select([
            'name' => 'provinsi.name',
            // 'standby' => new Expression('(select count(member.id) from member where member.id_provinsi = provinsi.id and status = '.Member::STATUS_STANDBY.' )'),
            'dalam_tugas' => new Expression('(select count(member.id) from member where member.id_provinsi = provinsi.id and status = '.Member::STATUS_DALAM_TUGAS.' )')
        ]);

        return $query->all();
   }

   public static function getCaseBulan($id_provinsi, $tahun)
   {
        $query = new Query();
        $query->from('report');
        $query->where(['id_provinsi' => $id_provinsi]);
        $query->andWhere(['tahun' => $tahun]);
        $query->select(['total' => '(SUM(COALESCE(report.darat,0)+COALESCE(report.laut,0)+COALESCE(report.udara,0)))']);

        return $query->column();
   }
}
