<?php

namespace backend\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "member".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $photo
 * @property string|null $location
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 */
class Member extends \common\models\Member
{
   const STATUS_STANDBY =  2;
   const STATUS_DALAM_TUGAS = 1;
   public function getStatusLabel()
   {
        switch ($this->status) {
            case 1:
                $label = 'Dalam Tugas';
                $class='dot-warning';
                break;
            case 2:
                $label = 'Stand by';
                $class='dot';
                break;
            case 3:
                $label = "Cuti";
                $class='dot-secondary';
                break;
            
            default:
                $label = '';
                $class= 'dot-warning';
                break;
        }
        return '<span class="'.$class.'"></span> <small class="text-muted"> '. $label . '</small>';
   }

   public function getStatusBadges()
   {
        switch ($this->status) {
            case 1:
                $label = '<span class="badge badge-warning w-100">Dalam Tugas</span>';
                break;
            case 2:
                $label = '<span class="badge  badge-success w-100">Standby</span>';
                break;
            case 3:
                $label = '<span class="badge badge-secondary w-100">Cuti</span>';
                break;
            
            default:
                $label = '';
                break;
        }

        return $label;
   }

   public static function optionsStatus(){
        return [2 => 'Standby', 1 => 'Dalam Tugas', 3 => 'Cuti'];
   }

   public function getActionButton(){
        $btnUpdate = Html::a('<i class="material-icons-round">edit</i> Ubah', ['update?id='. $this->id], ['class' => 'btn  btn-outline-warning']);
    
        $btnDelete = Html::a('<i class="material-icons-round">delete</i>', $this->id ? '/anggota/delete?id='.$this->id : '#', ['class' => 'btn btn-sm', 'data-pjax' => 0, 'data-confirm' => 'Apakah anda yakin?', 'data-method' => 'post']);        
        return $btnUpdate . $btnDelete;
    }

    public function getPhotoUrl(){
        return $this->photo ?: 'images/no-pict.png';
    }

    public static function getTotalByStatus($status){
        return self::find()->where(['status' => $status])->count();
    }

    public function getLokasiKantor($short = false ){
        $loc = '';
        if($this->id_office){
            $kt = Kantor::findOne($this->id_office);
            if($kt){
                $loc = $short ? $kt->shortname : $kt->name;
            }
        }

        return $loc;
    }
}
