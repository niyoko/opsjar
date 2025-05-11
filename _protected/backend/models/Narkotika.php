<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "jenis_narkotika".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 *
 * @property ReportDetail[] $reportDetails0
 */
class Narkotika extends \common\models\Narkotika
{
 

    public static function optionsAll(){
        return ArrayHelper::map(self::find()->where(['status' => 1])->all(), 'id', 'name');
    }

    public static function optionsAllColor(){
        return [
            self:: TYPE_METH  => 'bg-warning',
            self:: TYPE_COCAINE  => 'opsjar-biru-muda',
            self::TYPE_GANJA => 'bg-success',
            self::TYPE_MDMA => 'bg-danger',
            self::TYPE_LAINNYA => 'bg-light'
        ];
    }
}
