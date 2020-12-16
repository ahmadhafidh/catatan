<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
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
</style>

  
<div class="col-md-6 text-center">

    <h2><b>Atur Ulang Password</b></h2>
    <p>Silahkan atur ulang password untuk anda. <br>
    mengakses dashboard E-TilangKejaksaan</p>
    <div class="custom-login">
        <section class="login-form">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}",
                    'horizontalCssClasses' => [
                        'autoComplete'=>false,
                    ],
                ],
            ]); ?>            

            <!-- /password baru -->
            <?= $form->field($model, 'email')->textInput([/*'autofocus' => true,*/'placeholder' => "Password baru", 'class' => 'form-control input-lg', 'style' => 'width:100%'])->label(false) ?>
            <!-- /confirm ulang -->
            <?= $form->field($model, 'email')->textInput([/*'autofocus' => true,*/'placeholder' => "Confirm ulang", 'class' => 'form-control input-lg', 'style' => 'width:100%'])->label(false) ?>

            <div class="form-group" style="margin-top: 10%;">
                <?= Html::submitButton('Atur Ulang', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>  

        </section>  
    </div>
</div>
<div class="col-md-6 bg-img" style="background-color:gray;"></div>
