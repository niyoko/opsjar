<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jenis_narkotika".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 *
 * @property AnalyticsJenisNpp[] $analyticsJenisNpps
 * @property ReportDetail[] $reportDetails
 */
class JenisNarkotika extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jenis_narkotika';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_at', 'created_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 100],
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
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[AnalyticsJenisNpps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnalyticsJenisNpps()
    {
        return $this->hasMany(AnalyticsJenisNpp::class, ['id_jenis_narkotika' => 'id']);
    }

    /**
     * Gets query for [[ReportDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReportDetails()
    {
        return $this->hasMany(ReportDetail::class, ['id_jenis_narkotika' => 'id']);
    }

}
