<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "analytics_total_npp".
 *
 * @property int $id
 * @property int|null $tahun
 * @property int|null $kasus
 * @property float|null $berat_gr
 * @property float|null $berat_kg
 * @property string $last_updated_at
 * @property int|null $last_updated_by
 */
class AnalyticsTotalNpp extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'analytics_total_npp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun', 'kasus', 'berat_gr', 'berat_kg'], 'default', 'value' => null],
            [['last_updated_by'], 'default', 'value' => 1],
            [['tahun', 'kasus', 'last_updated_by'], 'integer'],
            [['berat_gr', 'berat_kg'], 'number'],
            [['last_updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahun' => 'Tahun',
            'kasus' => 'Kasus',
            'berat_gr' => 'Berat Gr',
            'berat_kg' => 'Berat Kg',
            'last_updated_at' => 'Last Updated At',
            'last_updated_by' => 'Last Updated By',
        ];
    }

    public static function getTotalKasus($tahun = null)
    {
        if ($tahun === null) {
            $tahun = date('Y');
        }
        $data = self::find()
            ->where(['tahun' => $tahun])
            ->one();

        return $data ? Yii::$app->formatter->asDecimal($data->kasus) : 0;
    }


    /**
     * Get total berat in grams for a given year. if berat_gr is more than 1000 return as kg
     *
     * @param int|null $tahun The year to get the total berat for. Defaults to the current year.
     * @return float The total berat in grams.
     */
    public static function getTotalBerat($tahun = null, $asKg = false)
    {
        $tahun = $tahun ?? date('Y');
        $data = self::findOne(['tahun' => $tahun]);
        return $data ? ($asKg ? $data->berat_kg : $data->berat_gr) : null;
    }

    public static function getLastUpdatedAt($tahun = null)
    {
        $tahun = $tahun ?? date('Y');
        $data = self::find()
            ->select(['last_updated_at'])
            ->where(['tahun' => $tahun])
            ->orderBy(['last_updated_at' => SORT_DESC])
            ->one();

        return $data ? Yii::$app->formatter->asDatetime($data->last_updated_at) : null;
    }
}
