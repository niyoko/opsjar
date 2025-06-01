<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "analytics_moda".
 *
 * @property int $id
 * @property string $perlintasan darat, laut, udara, ekspedisi
 * @property int $tahun
 * @property int $kasus
 * @property int $berat
 * @property string $last_updated_at
 * @property int|null $last_updated_by
 */
class AnalyticsModa extends \yii\db\ActiveRecord
{

    public const PERLINTASAN_DARAT = 'darat';
    public const PERLINTASAN_LAUT = 'laut';
    public const PERLINTASAN_UDARA = 'udara';
    public const PERLINTASAN_EKSPEDISI = 'ekspedisi';
    public const PERLINTASAN_LAINNYA = 'lainnya';

    public const ROW_EXCEL_TAHUN = 114;
    public const ROW_EXCEL_PERLINTASAN_EKSPEDISI = 116;
    public const ROW_EXCEL_PERLINTASAN_DARAT = 117;
    public const ROW_EXCEL_PERLINTASAN_LAUT = 118;
    public const ROW_EXCEL_PERLINTASAN_UDARA = 119;
    // public const ROW_EXCEL_PERLINTASAN_LAINNYA = 120;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'analytics_moda';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_updated_by'], 'default', 'value' => null],
            [['perlintasan', 'tahun', 'kasus', 'berat'], 'required'],
            [['tahun', 'kasus', 'berat', 'last_updated_by'], 'integer'],
            [['last_updated_at'], 'safe'],
            [['perlintasan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'perlintasan' => 'Perlintasan',
            'tahun' => 'Tahun',
            'kasus' => 'Kasus',
            'berat' => 'Berat',
            'last_updated_at' => 'Last Updated At',
            'last_updated_by' => 'Last Updated By',
        ];
    }

    public static function translateLabel($search, $from = 'key')
    {
        $array = [
            self::PERLINTASAN_DARAT => 'Perlintasan Darat',
            self::PERLINTASAN_LAUT => 'Perlintasan Laut',
            self::PERLINTASAN_UDARA => 'Perlintasan Udara',
            self::PERLINTASAN_EKSPEDISI => 'Ekspedisi Lokal',
            self::PERLINTASAN_LAINNYA => 'Lainnya',
        ];

        if ($from === 'value') {
            $array = array_flip($array);
        }

        return $array[$search] ?? 'Tidak Diketahui';
    }

    public static function getRowExcelPerlintasan($perlintasan)
    {
        switch ($perlintasan) {
            case self::PERLINTASAN_EKSPEDISI:
                return self::ROW_EXCEL_PERLINTASAN_EKSPEDISI;
            case self::PERLINTASAN_DARAT:
                return self::ROW_EXCEL_PERLINTASAN_DARAT;
            case self::PERLINTASAN_LAUT:
                return self::ROW_EXCEL_PERLINTASAN_LAUT;
            case self::PERLINTASAN_UDARA:
                return self::ROW_EXCEL_PERLINTASAN_UDARA;
            default:
                return null;
        }
    }

    public static function getAllPerlintasan()
    {
        return [
            self::PERLINTASAN_EKSPEDISI,
            self::PERLINTASAN_DARAT,
            self::PERLINTASAN_LAUT,
            self::PERLINTASAN_UDARA,
        ];
    }

    public static function getTotalByModa($perlintasan, $tahun = null , $formatted = false)
    {
        if ($tahun === null) {
            $tahun = date('Y');
        }
        $result = self::find()
            ->select(['SUM(kasus) AS total_kasus', 'SUM(berat) AS total_berat'])
            ->where(['tahun' => $tahun, 'perlintasan' => $perlintasan])
            ->asArray()
            ->one();

        $totalKasus = (int)($result['total_kasus'] ?? 0);
        $totalBerat = (int)($result['total_berat'] ?? 0);

        if ($formatted) {
            return [
                'kasus' => Yii::$app->formatter->asDecimal($totalKasus),
                'berat' => Yii::$app->formatter->asDecimal($totalBerat),
            ];
        }

        return [
            'kasus' => $totalKasus,
            'berat' => $totalBerat,
        ];
    }

    public static function getTotalKasusByTahun($tahun = null, $formatted = false)
    {
        if ($tahun === null) {
            $tahun = date('Y');
        }
        $result = self::find()
            ->select(['SUM(kasus) AS total_kasus', 'SUM(berat) AS total_berat'])
            ->where(['tahun' => $tahun])
            ->asArray()
            ->one();

        $totalKasus = (int)($result['total_kasus'] ?? 0);
        $totalBerat = (int)($result['total_berat'] ?? 0);

        if ($formatted) {
            return [
                'kasus' => Yii::$app->formatter->asDecimal($totalKasus),
                'berat' => Yii::$app->formatter->asDecimal($totalBerat),
            ];
        }

        return [
            'kasus' => $totalKasus,
            'berat' => $totalBerat,
        ];
    }
}
