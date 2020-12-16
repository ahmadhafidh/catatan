<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Users;
use app\models\AuthItemChild;
use kartik\select2\Select2;

?>

<div class="users-form">

    <?php $form = ActiveForm::begin([
    ]); ?>
    
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_new')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_confirm')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    
    <?= $form->field($model, 'role')->dropDownList(ArrayHelper::map(
        AuthItemChild::find()->where([
        'AND',
        ['LIKE', 'child', '%_permission', false],
        ['NOT LIKE', 'parent', '%_permission', false]])->all(), 'parent', 'parent'),
        ['prompt' => ''])
    ?>

    <div class="form-group">
        <?= Html::a('Kembali', ['/users/index'], ['class' => 'btn btn-info']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
