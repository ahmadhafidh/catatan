<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\TrackLogHelpers;

?>


<div class="catatan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true])->label('Nama') ?>
    <?= $form->field($model, 'nominal')->textInput(['maxlength' => true, 'type' => 'number', 'min' => 0])->label('Nominal') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', ucfirst(Yii::$app->controller->action->id)) , ['class' => 'btn btn-success pull-right']) ?>
        <?= Html::a('kembali', ['index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>