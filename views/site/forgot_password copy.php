<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Lupa Password | ' . Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    .custom-login {
        padding-left: 22% !important;
        padding-right: 22% !important;
    }

    .bg-img {
        /* The image used */
        background-image: url("/img/aerial-photo-of-buildings-and-roads-681335.png");

        /* Full height */
        height: 100%; 

        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .bg-light-success {
        background-color: #E0FBDA!important;
        color: #40C057!important;
        border-color: #E0FBDA;
    }

    .bg-light-danger {
        background-color: #FEE8DC!important;
        color: #F55252!important;
        border-color: #FEE8DC;
    }
</style>

<div class="col-md-6 text-center">
    <h2><b>Lupa Password?</b></h2>
    <p>
        Silahkan masukkan alamat email akun Anda. <br>
        Kami akan mengirimkan link untuk mengatur ulang <br>
        password Anda melalui email.
    </p>
    <div class="custom-login">
        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger fade in alert-dismissible">
                <strong><?= Yii::$app->session->getFlash('error') ?></strong>
            </div>
        <?php endif; ?>
        <section class="login-form">
            <?php
                if (!empty($result))
                {
                    echo '<div class="alert bg-light-' . $result['type'] . ' mb-2 text-bold-400" role="alert">' . $result['message'] . '</div>';
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

            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email', 'class' => 'form-control input-lg', 'style' => 'width:100%'])->label(false) ?>

            <div class="form-group" style="margin-top: 10%;">
                <?= Html::submitButton('Kirim link Reset', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>

            <div class="form-group" style="margin-top: 10%;">
                <u><?= Html::a('Kembali ke halaman login', Url::to(['/site/login']), ['class' => 'text-success']) ?></u>
            </div>

            <?php ActiveForm::end(); ?>
        </section>
    </div>
</div>
<div class="col-md-6 bg-img" style="background-color:gray;"></div>
