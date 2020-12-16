<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Ubah Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .bg-light-success {
        background-color: #E0FBDA!important;
        color: #40C057!important;
        border-color: #E0FBDA;
    }

    .bg-light-danger {
        background-color: #FEE8DC!important;
        color: #F55252 !important;
        border-color: #FEE8DC;
    }

    .alert[class*=bg-] .alert-link {
        color: inherit !important;
    }
</style>
<div class="row">
    <div class="col-md-6">
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

        <?= $form->field($model, 'password_old')->passwordInput(['placeholder' => "Password lama", 'class' => 'form-control input-lg', 'style' => 'width:100%'])->label(false) ?>
        <?= $form->field($model, 'password_new')->passwordInput(['placeholder' => "Password baru", 'class' => 'form-control input-lg', 'style' => 'width:100%'])->label(false) ?>
        <?= $form->field($model, 'password_confirm')->passwordInput(['placeholder' => "Confirm ulang", 'class' => 'form-control input-lg', 'style' => 'width:100%'])->label(false) ?>

        <div class="form-group" style="margin-top: 5%;">
            <?= Html::submitButton('Atur Ulang', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
        </?>

        <?php ActiveForm::end(); ?>
    </div>
</div>