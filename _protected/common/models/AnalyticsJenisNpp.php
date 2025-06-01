<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "analytics_jenis_npp".
 *
 * @property int $id
 * @property int $id_jenis_narkotika
 * @property int $tahun
 * @property int $kasus
 * @property float $berat
 * @property string $last_updated_at
 * @property int|null $last_updated_by
 *
 * @property JenisNarkotika $jenisNarkotika
 */
class AnalyticsJenisNpp extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'analytics_jenis_npp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_updated_by'], 'default', 'value' => null],
            [['id_jenis_narkotika', 'tahun', 'kasus', 'berat'], 'required'],
            [['id_jenis_narkotika', 'tahun', 'kasus', 'last_updated_by'], 'integer'],
            [['berat'], 'number'],
            [['last_updated_at'], 'safe'],
            [['id_jenis_narkotika'], 'exist', 'skipOnError' => true, 'targetClass' => JenisNarkotika::class, 'targetAttribute' => ['id_jenis_narkotika' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_jenis_narkotika' => 'Id Jenis Narkotika',
            'tahun' => 'Tahun',
            'kasus' => 'Kasus',
            'berat' => 'Berat',
            'last_updated_at' => 'Last Updated At',
            'last_updated_by' => 'Last Updated By',
        ];
    }

    /**
     * Gets query for [[JenisNarkotika]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJenisNarkotika()
    {
        return $this->hasOne(JenisNarkotika::class, ['id' => 'id_jenis_narkotika']);
    }


    
}
