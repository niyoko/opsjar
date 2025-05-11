<?php

namespace common\models;

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
class CapaianTrenKinerja extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'capaian_tren_kinerja';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun', 'status'], 'integer'],
            [['value'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['month'], 'string', 'max' => 2],
            [['created_by'], 'string', 'max' => 255],
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
            'month' => 'Month',
            'value' => 'Value',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'status' => 'Status',
        ];
    }
}
