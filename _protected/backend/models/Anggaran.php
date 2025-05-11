<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "anggaran".
 *
 * @property int $id
 * @property int|null $tahun
 * @property float|null $budget
 * @property float|null $realisasi
 * @property int|null $type
 */
class Anggaran extends \yii\db\ActiveRecord
{
    public const TYPE_OPERATION = 1;
    public const TYPE_BIMTEK = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anggaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun', 'type'], 'integer'],
            [['budget', 'realisasi'], 'number'],
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
            'budget' => 'Budget',
            'realisasi' => 'Realisasi',
            'type' => 'Type',
        ];
    }

    public static function getDataAnggaran($type, $tahun){
        $budget = 0;
        $realisasi = 0;
        $anggaran = Anggaran::find()->where(['tahun' => $tahun, 'type' => $type])->orderBy('id desc')->limit(1)->one();
        if($anggaran){
            $budget = $anggaran->budget;
            $realisasi = $anggaran->realisasi;
        }

        return[
            'anggaran' => $budget ? round($budget - $realisasi) : 0,
            'penggunaan' => round($realisasi),
            'percentage' => $budget ? round($realisasi / $budget * 100) : 0
        ];
    }

    public static function getDataAnggaranBulanan($tahun){
        $anggaran = AnggaranDetail::find()->where(['tahun' => $tahun])->orderBy('month desc')->limit(1);
        $budget = array_fill(0, 12,0);
        $realisasi = array_fill(0, 12,0);
        if($anggaran->exists()){
            $budget = array_map(function ($x) {
                return round($x);
            }, $anggaran->select('budget')->column());
            $realisasi =  array_map(function ($x) {
                return round($x);
            }, $anggaran->select('realisasi')->column());
        }
        return[
            'anggaran' => $budget,
            'penggunaan' => $realisasi,
        ];
    }

    public static function getSisaDipa($tahun){
        $ops =  self::getDataAnggaran(self::TYPE_OPERATION, $tahun);
        $bimtek = self::getDataAnggaran(self::TYPE_BIMTEK, $tahun);
        $res = (($ops['anggaran'] + $bimtek['anggaran']) - ($ops['penggunaan'] + $bimtek['penggunaan']));
        return $res > 0 ? round($res) : 0;
    }

    public static function getSisaDokppn($tahun){
        $dt  = self::getDataAnggaranBulanan($tahun);
        $anggaran = 0;
        $penggunaan = 0;
        foreach ($dt['anggaran'] as $index => $a) {
            $anggaran+=$a;
            $penggunaan += $dt['penggunaan'][$index]; 
        }

        $res = ($anggaran - $penggunaan) / 1000;

        return $res > 0 ? round($res) : 0;
    }

}
