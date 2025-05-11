<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "report_detail".
 *
 * @property int $id
 * @property int|null $id_report
 * @property int|null $id_jenis_narkotika
 * @property float|null $total
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 *
 * @property JenisNarkotika $jenisNarkotika
 * @property Report $report
 */
class ReportDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_report', 'id_jenis_narkotika', 'status'], 'integer'],
            [['total'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by'], 'string', 'max' => 255],
            [['id_jenis_narkotika'], 'exist', 'skipOnError' => true, 'targetClass' => Narkotika::className(), 'targetAttribute' => ['id_jenis_narkotika' => 'id']],
            [['id_report'], 'exist', 'skipOnError' => true, 'targetClass' => Report::className(), 'targetAttribute' => ['id_report' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_report' => 'Id Report',
            'id_jenis_narkotika' => 'Id Jenis Narkotika',
            'total' => 'Total',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[JenisNarkotika]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJenisNarkotika()
    {
        return $this->hasOne(Narkotika::className(), ['id' => 'id_jenis_narkotika']);
    }

    /**
     * Gets query for [[Report]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReport()
    {
        return $this->hasOne(Report::className(), ['id' => 'id_report']);
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
}
