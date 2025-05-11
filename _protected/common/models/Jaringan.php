<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jaringan".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $dokumen
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 */
class Jaringan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jaringan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dokumen'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 150],
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
            'dokumen' => 'Dokumen',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'status' => 'Status',
        ];
    }
}
