<?php

namespace backend\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 */
class User extends \common\models\User
{
    public $password_confirm;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username','password', 'role'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password', 'password_reset_token', 'email', 'verification_token', 'password_confirm'], 'string', 'max' => 255],
            [['username', 'password', 'password_confirm', 'password'], 'safe'],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
        ];
    }


    public static function optionsRoles(){
        return ['1' => 'Super Admin', '2' => 'User'];
    }

    public function getActionButton(){
        $btnDelete = Html::a('<i class="material-icons-round">delete</i>', $this->id ? '/user/delete?id='.$this->id : '#', ['class' => 'btn ', 'data-pjax' => 0, 'data-confirm' => 'Apakah anda yakin?', 'data-method' => 'post']);
        return '<a href="/user/update?id='.$this->id.'" type="button" class="text-warning font-bold ml-3">Ubah Password</a>' . $btnDelete;
    }

    public function getRoleLabel(){
        return $this->role == 1 ? 'Super Admin' : 'User';
    }
}
