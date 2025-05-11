<?php

namespace backend\models;

use common\components\Roles;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "jaringan".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $dokumen
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 */
class Jaringan extends \common\models\Jaringan
{
    public function getActionButton(){
        if(Yii::$app->user->identity->role == Roles::ROLE_USER){
            return $this->dokumen ? Html::a('Unduh Dokumen', $this->dokumen, ['class' => 'text-warning', 'target' => '_blank']): '<span class="text-muted"><i>Dokumen Belum Tersedia</i></span>';
         }
        $btnUpdate = Html::a('<i class="material-icons-round">edit</i> Ubah', ['update?id='. $this->id], ['class' => 'btn btn-outline-warning']);
      
        $btnDelete = Html::a('<i class="material-icons-round">delete</i>', $this->id ? '/jaringan/delete?id='.$this->id : '#', ['class' => 'btn', 'data-pjax' => 0, 'data-confirm' => 'Apakah anda yakin?', 'data-method' => 'post']);        
        return $btnUpdate . $btnDelete;
    }
}
