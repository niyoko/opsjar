<?php

use backend\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group field-user-username required has-success">
                <label class="control-label" for="user-username">Username</label>
                <input type="text" id="user-username" class="form-control" name="username" readonly="true" maxlength="255" aria-required="true" aria-invalid="false" value="<?= $model->username ?>">

                <div class="help-block username-message text-sm" id="username-message"></div>
            </div>
           
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'role')->dropDownList(User::optionsRoles(), ['disabled' => true]) ?>        
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="user-password">Password Baru</label>
            <div class="input-group">
               
                <input type="password" id="user-password" class="form-control" name="User[password]" aria-required="true" aria-invalid="true" value="">
                <span class="input-group-text"><input type="checkbox" tabindex="10000" class="kv-toggle" title="Show/Hide Password" id="reveal-password">
                </span>
            </div>
            
            
            
        </div>
        <div class="col-md-6">
            <label for="user-password">Konfirmasi Password Baru</label>
            <div class="input-group">
                <input type="password" id="user-password_confirm" class="form-control" name="User[password_confirm]" aria-required="true" aria-invalid="true" value="<?= $model->password_confirm ?>">
                <span class="input-group-text"><input type="checkbox" tabindex="10000" class="kv-toggle" title="Show/Hide Password" id="reveal-password-confirm">
                </span>
                
            </div>
            <div class="help-block text-sm mt-0" id="confirm-password"></div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="form-group text-right mt-2">
                <?= Html::a('Batalkan','/user', ['class' => 'btn btn-secondary mr-1']) ?>
                <?= Html::submitButton('<i class="material-icons-round">save</i> Simpan', ['class' => 'btn btn-success']) ?>
            
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$location_path = Url::to(['user/is-username-exist']);
$is_update = isset($is_update) ? 1 : 0;
$script = <<<JS
const input_username = $('#user-username');
const minimum = '$is_update';
const origin_username = '$model->username';
const is_update = '$is_update';

input_username.on('change', is_username_exist);
is_username_exist();

$('#user-password_confirm').on('change', function(){
    confirmPassword();
})
function is_username_exist() {
    let path = '$location_path';
    var username_value = input_username.val();
    
    if( is_update ) {
        var condition = (username_value != '' && (username_value != origin_username) );
    } else {
        var condition = (username_value != '');
    }

    if( condition ){
        $.ajax({
            url: path,
            data: {
                'key':username_value,
            },
            type: 'get',
            beforeSend: function(){},
            success: function(result){
                if(result >= Number(1)){
                    $(".username-message").show().text('Username sudah pernah digunakan')
                    $(".btn-submit").attr('disabled', true)
                } else {
                    $(".username-message").hide()
                    $(".btn-submit").attr('disabled', false)
                }
            }
        });
    } else {
        $(".username-message").hide()
    }
}

const confirmPassword = () => {
    let pwc = $('#user-password_confirm').val();
    let pw = $('#user-password').val();
    if(pwc !== pw){
        $('#confirm-password').html('Konfirmasi password harus sama dengan password');
        $(".btn-submit").attr('disabled', true);
    }
    else{
        $('#confirm-password').html('');
        $(".btn-submit").attr('disabled', false);
    }
}

input_username.on('blur', confirmPassword);

JS;
echo $this->registerJs($script, \yii\web\View::POS_END);
echo $this->registerJs("jQuery('#reveal-password').change(function(){jQuery('#user-password').attr('type',this.checked?'text':'password');})");
echo $this->registerJs("jQuery('#reveal-password-confirm').change(function(){jQuery('#user-password_confirm').attr('type',this.checked?'text':'password');})");

?>