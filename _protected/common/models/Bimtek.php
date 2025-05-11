<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "bimtek".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $surat_tugas
 * @property string|null $date_start
 * @property string|null $date_end
 * @property int|null $tahun
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 */
class Bimtek extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bimtek';
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
            [['surat_tugas', 'report', 'nomor_surat'], 'string'],
            [['date_start', 'date_end', 'created_at', 'updated_at'], 'safe'],
            [['tahun', 'status'], 'integer'],
            [['name'], 'required'],
            [['name', 'created_by'], 'string', 'max' => 255],
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
            'surat_tugas' => 'Surat Tugas',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'tahun' => 'Tahun',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'status' => 'Status',
        ];
    }

    public static function optionsStatus(){
        return [
            1 => 'Scheduled',
            2 => 'Ongoing',
            3 => 'Selesai',
            4 => 'Cancelled'
        ];
    }
}
