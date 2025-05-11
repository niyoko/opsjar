<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "capaian_iku".
 *
 * @property int $id
 * @property int|null $tahun
 * @property float|null $grey
 * @property float|null $below
 * @property float|null $meet
 * @property float|null $exceed
 * @property string|null $created_at
 * @property string $updated_at
 * @property string|null $created_by
 * @property int|null $status -1=deleted,1=active,0=inactive
 */
class CapaianIku extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'capaian_iku';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun', 'status'], 'integer'],
            [['grey', 'below', 'meet', 'exceed'], 'number'],
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
            'tahun' => 'Tahun',
            'grey' => 'Grey',
            'below' => 'Below',
            'meet' => 'Meet',
            'exceed' => 'Exceed',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'status' => 'Status',
        ];
    }
}
