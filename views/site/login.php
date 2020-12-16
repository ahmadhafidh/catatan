<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
  
<div class="col-md-6 text-center">
    <?= Html::img(Yii::getAlias(''), null, ['width'=>'207px','text-align' => 'center', 'style' => 'padding-bottom: 5%;'])?>
    <h2>Login Administrator</h2>
    <p>Silahkan masukkan username dan password Anda</p>
    <div class="custom-login">
        <section class="login-form">
            <?php
                $get = Yii::$app->request->queryparams;
                if (isset($get['from']) && $get['from'] === 'reset-password')
                {
                    echo '<div class="alert bg-light-success mb-2 text-bold-400" role="alert">Sukses, kata sandi anda telah diperbaharui.</div>';
                }
            ?>
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}",
                    'horizontalCssClasses' => [
                        'autoComplete'=>false,
                    ],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput([/*'autofocus' => true,*/'placeholder' => "Username", 'class' => 'form-control input-lg', 'style' => 'width:100%'])->label(false) ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => "Password", 'class' => 'form-control input-lg', 'style' => 'margin-bottom:5px;'])->label(false) ?>

            <div class="form-group" style="margin-top: 10%;">
                <?= Html::submitButton('Login', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>  

            <p>Lupa Password? Atur ulang password Anda <a href="/site/forgot-password">disini</a></p>
        </section>  
    </div>
</div>
<div class="col-md-6 bg-img" style="background-color:gray;"></div>
