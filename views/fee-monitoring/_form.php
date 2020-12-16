<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Transaksi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaksi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_tilang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_sidang')->textInput() ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kejaksaan_id')->textInput() ?>

    <?= $form->field($model, 'kendaraan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'denda')->textInput() ?>

    <?= $form->field($model, 'biaya_admin')->textInput() ?>

    <?= $form->field($model, 'biaya_total')->textInput() ?>

    <?= $form->field($model, 'no_va')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'va_expired_date')->textInput() ?>

    <?= $form->field($model, 'payment_date')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_date')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
