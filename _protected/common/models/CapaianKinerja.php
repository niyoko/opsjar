<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "capaian_kinerja".
 *
 * @property int $id
 * @property float|null $stakeholders_value
 * @property float|null $stakeholders_percentage
 * @property float|null $internal_business_process_value
 * @property float|null $internal_business_process_percentage
 * @property float|null $learning_growth_value
 * @property float|null $learning_growth_percentage
 * @property int|null $tahun
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 * @property float|null $nko
 */
class CapaianKinerja extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'capaian_kinerja';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stakeholders_value', 'stakeholders_percentage', 'internal_business_process_value', 'internal_business_process_percentage', 'learning_growth_value', 'learning_growth_percentage', 'nko'], 'number'],
            [['tahun', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'stakeholders_value' => 'Stakekholders Value',
            'stakeholders_percentage' => 'Stakeholders Percentage',
            'internal_business_process_value' => 'Internal Business Process Value',
            'internal_business_process_percentage' => 'Internal Business Process Percentage',
            'learning_growth_value' => 'Learning Growth Value',
            'learning_growth_percentage' => 'Learning Growth Percentage',
            'tahun' => 'Tahun',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'status' => 'Status',
            'nko' => 'Nko',
        ];
    }
}
