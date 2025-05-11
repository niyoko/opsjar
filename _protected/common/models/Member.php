<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "member".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $photo
 * @property string|null $location
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 */
class Member extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'member';
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
            [['location','photo'], 'string'],
            [['file'],'file','skipOnEmpty'=>TRUE,'extensions'=>'jpg, png', 'maxSize' => 1024 * 100 * 2],
            [['created_at', 'updated_at'], 'safe'],
            [['status', 'id_office'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['location'], 'string', 'max' => 50],
            [['created_by'], 'string', 'max' => 255],
            [['id_provinsi'], 'exist', 'skipOnError' => true, 'targetClass' => Provinsi::className(), 'targetAttribute' => ['id_provinsi' => 'id']],
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
            'photo' => 'Photo',
            'location' => 'Location',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'status' => 'Status',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->file->saveAs('photo/' . $this->id.$this->name. '.' . $this->file->extension);
            $this->photo = 'photo/'. $this->id.$this->name . '.' . $this->file->extension;
            return true;
        } else {
            return false;
        }
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
}
