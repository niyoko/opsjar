<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "analytics_potensi_penyelamatan".
 *
 * @property int $id
 * @property int|null $tahun
 * @property float|null $koefisiensi
 * @property float|null $penghematan_rp
 * @property int|null $jiwa
 * @property float|null $penghematan_triliun
 * @property string $last_updated_at
 * @property int|null $last_updated_by
 */
class AnalyticsPotensiPenyelamatan extends \yii\db\ActiveRecord
{

    public const ROW_EXCEL_YEAR = 9; // Tahun 2023
    public const ROW_EXCEL_KOEFISIENSI = 10; // Koefisiensi
    public const ROW_EXCEL_PENGHEMATAN_RP = 10; // Penghematan Rp
    public const ROW_EXCEL_JIWA = 11; // Jiwa
    public const ROW_EXCEL_PENGHEMATAN_TRILIUN = 11; // Penghematan Triliun

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'analytics_potensi_penyelamatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun', 'koefisiensi', 'penghematan_rp', 'jiwa', 'penghematan_triliun'], 'default', 'value' => null],
            [['last_updated_by'], 'default', 'value' => 1],
            [['tahun', 'jiwa', 'last_updated_by'], 'integer'],
            [['koefisiensi', 'penghematan_rp', 'penghematan_triliun'], 'number'],
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
            'koefisiensi' => 'Koefisiensi',
            'penghematan_rp' => 'Penghematan Rp',
            'jiwa' => 'Jiwa',
            'penghematan_triliun' => 'Penghematan Triliun',
            'last_updated_at' => 'Last Updated At',
            'last_updated_by' => 'Last Updated By',
        ];
    }

    public static function getTotalJiwaByTahun($tahun)
    {
        $total = self::find()
            ->select(['SUM(jiwa) AS total_jiwa'])
            ->where(['tahun' => $tahun])
            ->scalar();

        return $total ? (int)$total : 0;
    }

    public static function getTotalPenghematanRpByTahun($tahun)
    {
        $total = self::find()
            ->select(['SUM(penghematan_rp) AS total_penghematan_rp'])
            ->where(['tahun' => $tahun])
            ->scalar();

        return $total ? (float)$total : 0.0;
    }

    public static function getTotalPenghematanTriliunByTahun($tahun)
    {
        $total = self::find()
            ->select(['SUM(penghematan_triliun) AS total_penghematan_triliun'])
            ->where(['tahun' => $tahun])
            ->scalar();

        return $total ? (float)$total : 0.0;
    }

}
