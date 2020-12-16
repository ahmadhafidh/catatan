<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\log\search\AppAuditTrailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-audit-trail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, '_id') ?>

    <?= $form->field($model, 'audit_trail_id') ?>

    <?= $form->field($model, 'activity') ?>

    <?= $form->field($model, 'old_value') ?>

    <?= $form->field($model, 'new_value') ?>

    <?php // echo $form->field($model, 'action') ?>

    <?php // echo $form->field($model, 'model') ?>

    <?php // echo $form->field($model, 'model_id') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'ip_address') ?>

    <?php // echo $form->field($model, 'url_referer') ?>

    <?php // echo $form->field($model, 'browser') ?>

    <?php // echo $form->field($model, 'stamp') ?>

    <?php // echo $form->field($model, 'is_error') ?>

    <?php // echo $form->field($model, 'error_desc') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
