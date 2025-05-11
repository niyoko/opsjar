<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "report".
 *
 * @property int $id
 * @property int|null $id_provinsi
 * @property string|null $date
 * @property float|null $udara
 * @property float|null $laut
 * @property float|null $darat
 * @property float|null $total
 * @property string|null $surat_tugas
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 * @property int|null $tahun
 *
 * @property Provinsi $provinsi
 * @property ReportDetail[] $reportDetails
 */
class Report extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report';
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
    public function rules()
    {
        return [
            [['id_provinsi', 'status', 'tahun', 'id_office'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['udara', 'laut', 'darat', 'total'], 'number'],
            [['surat_tugas', 'nomor_surat', 'laporan'], 'string'],
            [['id_provinsi', 'date'], 'required', 'message' => '{attribute} harus dipilih'],
            [['created_by'], 'string', 'max' => 255],
            [['id_provinsi'], 'exist', 'skipOnError' => true, 'targetClass' => Provinsi::className(), 'targetAttribute' => ['id_provinsi' => 'id']],
            [['id_office'], 'exist', 'skipOnError' => true, 'targetClass' => Kantor::className(), 'targetAttribute' => ['id_office' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_provinsi' => 'Provinsi',
            'date' => 'Tanggal Laporan',
            'udara' => 'Udara',
            'laut' => 'Laut',
            'darat' => 'Darat',
            'total' => 'Total',
            'surat_tugas' => 'Surat Tugas',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'status' => 'Status',
            'tahun' => 'Tahun',
        ];
    }

    /**
     * Gets query for [[Provinsi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvinsi()
    {
        return $this->hasOne(Provinsi::className(), ['id' => 'id_provinsi']);
    }

    public function getKantor()
    {
        return $this->hasOne(Kantor::className(), ['id' => 'id_office']);
    }

    /**
     * Gets query for [[ReportDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReportDetails()
    {
        return $this->hasMany(ReportDetail::className(), ['id_report' => 'id']);
    }
}
