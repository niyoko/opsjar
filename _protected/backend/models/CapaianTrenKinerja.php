<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "capaian_tren_kinerja".
 *
 * @property int $id
 * @property int|null $tahun
 * @property string|null $month
 * @property float|null $value
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 */
class CapaianTrenKinerja extends \common\models\CapaianTrenKinerja
{
    public static function getData($tahun){
        $query = self::find()->where(['tahun' => $tahun])->orderBy('month asc')->limit(12);
        $data = array_fill(0, 12,0);
        if($query->exists()){
            $data = array_map(function($x){
                return round($x);
            }, $query->select('value')->column());
        }
        return $data;
    }
}
