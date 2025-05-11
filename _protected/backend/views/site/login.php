<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
?>

<style>

    body {
        color: white;
        background-color: #3F435C;
    }
</style>
<div class="site-login">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5">

                        <div class="mb-md-5 mt-md-4 pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-center mb-5">
                                        <div class="ml-auto mr-auto">
                                            <img height="40px" src="/images/opsjar_logo.png" alt="Opsjar Logo" class="brand-image" style="opacity: .8">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                                        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                                        <?= $form->field($model, 'password')->passwordInput() ?>

                                        <?= $form->field($model, 'rememberMe')->checkbox() ?>

                                        <div class="d-grid gap-2 d-md-block mx-auto text-center btn-block">
                                            <?= Html::submitButton('Login', ['class' => 'btn oprjar-orange btn-block font-bold w-100', 'style' => 'color:#F3FAFF;', 'name' => 'login-button']) ?>
                                        </div>
                                        <?php ActiveForm::end(); ?>
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>