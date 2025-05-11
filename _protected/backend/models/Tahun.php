<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tahun".
 *
 * @property int $id
 * @property string|null $label
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 */
class Tahun extends \common\models\Tahun
{
    public static function optionsDropdown(){
        return ArrayHelper::map(self::find()->where(['status' => 1])->orderBy('label desc')->all(), 'id', 'label');
    }
}
