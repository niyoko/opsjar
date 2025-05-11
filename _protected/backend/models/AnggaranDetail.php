<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "anggaran_detail".
 *
 * @property int $id
 * @property int|null $tahun
 * @property int|null $type
 * @property string|null $month
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 */
class AnggaranDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anggaran_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun', 'type', 'status'], 'integer'],
            [['created_at', 'updated_at', 'budget', 'realisasi'], 'safe'],
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
            'type' => 'Type',
            'month' => 'Month',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'status' => 'Status',
        ];
    }
}
