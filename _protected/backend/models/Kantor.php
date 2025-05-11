<?php

namespace backend\models;

use Yii;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "office".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $id_provinsi
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 * @property string|null $shortname
 *
 * @property Provinsi $provinsi0
 */
class Kantor extends \common\models\Kantor
{
   public static function optionsAll($group = false){
    $q= self::find()->all();
    return $group? ArrayHelper::map($q, 'id', 'name', function($model){
        return $model->provinsi->name;
    }) : ArrayHelper::map($q, 'id', 'name');
   }


   public static function getCountAnngota($id_provinsi)
   {
        $query = new Query();
        $query->from('office');
        $query->where(['office.id_provinsi' => $id_provinsi]);
        $query->select([
            'name' => 'office.shortname',
            'standby' => new Expression('(select count(member.id) from member where member.id_office = office.id and status = '.Member::STATUS_STANDBY.' )'),
            'dalam_tugas' => new Expression('(select count(member.id) from member where member.id_office = office.id and status = '.Member::STATUS_DALAM_TUGAS.' )')
        ]);

        return $query->all();
   }
}
