<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
 * @property ReportDetail[] $reportDetails
 */
class Narkotika extends \yii\db\ActiveRecord
{
    const TYPE_METH = 1;
    const TYPE_COCAINE = 2;
    const TYPE_GANJA = 3;
    const TYPE_MDMA =  4;
    const TYPE_LAINNYA = 5;
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
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['created_by'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        $timezone = new \DateTimeZone(\Yii::$app->formatter->timeZone);
        $date = new \DateTime('now', $timezone);
        $today = $date->format('Y-m-d H:i:s');
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                //'value' => date('Y-m-d H:i:s'),
                'value' => $today,
            ]
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
     * Gets query for [[ReportDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReportDetails()
    {
        return $this->hasMany(ReportDetail::className(), ['id_jenis_narkotika' => 'id']);
    }
}
