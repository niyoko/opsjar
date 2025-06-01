<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "analytics_kanwil".
 *
 * @property int $id
 * @property int $id_office
 * @property string $kasus
 * @property float $berat
 * @property int $tahun
 *
 * @property Office $office
 */
class AnalyticsKanwil extends \yii\db\ActiveRecord
{

    public const ROW_EXCEL_TAHUN = 449; // Tahun
    public const ROW_EXCEL_KASUS = 451; // Kasus
    public const ROW_EXCEL_BERAT = 451; // Berat
    public const COL_EXCEL_OFFICE = 'B'; // Kantor Wilayah
    public const ROW_START_EXCEL = 451; // Baris awal data di Excel
    public const ROW_END_EXCEL = 584; // Kolom awal data di Excel

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'analytics_kanwil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_office', 'kasus', 'berat', 'tahun'], 'required'],
            [['id_office', 'tahun'], 'integer'],
            [['berat'], 'number'],
            [['id_office'], 'exist', 'skipOnError' => true, 'targetClass' => Kantor::class, 'targetAttribute' => ['id_office' => 'id']],
             [['kasus'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_office' => 'Id Office',
            'kasus' => 'Kasus',
            'berat' => 'Berat',
            'tahun' => 'Tahun',
        ];
    }

    /**
     * Gets query for [[Office]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOffice()
    {
        return $this->hasOne(Kantor::class, ['id' => 'id_office']);
    }

    public static function getTotalKasusByTahun($tahun = null)
    {
        if ($tahun === null) {
            $tahun = date('Y');
        }
        $data = self::find()
            ->where(['tahun' => $tahun])
            ->all();

        $totalKasus = 0;
        foreach ($data as $item) {
            $totalKasus += $item->kasus;
        }

        return $totalKasus;
    }

    public static function getTotalBeratByTahun($tahun = null)
    {
        if ($tahun === null) {
            $tahun = date('Y');
        }
        $data = self::find()
            ->where(['tahun' => $tahun])
            ->all();

        $totalBerat = 0.0;
        foreach ($data as $item) {
            $totalBerat += $item->berat;
        }

        return $totalBerat;
    }

    public static function getTotalByOfficeAndTahun($id_office, $tahun = null)
    {
        if ($tahun === null) {
            $tahun = date('Y');
        }
        $data = self::find()
            ->where(['id_office' => $id_office, 'tahun' => $tahun])
            ->one();

        return $data ? [
            'kasus' => $data->kasus,
            'berat' => $data->berat,
        ] : [
            'kasus' => 0,
            'berat' => 0.0,
        ];
    }

}
