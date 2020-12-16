<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Merchant;

/* @var $this yii\web\View */
/* @var $model app\models\Client */
/* @var $form yii\widgets\ActiveForm */

$role = \Yii::$app->user->identity->role;
?>

<div class="user-form">
    <div class="col-md-12 form-title-spc">
        User Information
    </div>
    <div class="col-md-12 form-group-spc">
        <?php
        $form = ActiveForm::begin([
            'fieldConfig' => [
                'labelOptions' => ['class' => ['widget' => 'control-label']]
            ],
        ]);
        ?>

        <?= $form->field($model, 'username', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'class' => 'form-control', 'readonly' => ($model->isNewRecord) ? false : true]) ?>

        <?= $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'class' => 'form-control', 'readonly' => ($model->isNewRecord) ? false : true]) ?>

        <?php if ($role == 'admin') { echo $form->field($model, 'role')->dropDownList(['admin' => 'Admin', 'merchant_user' => 'Merchant'], 
        [
            'prompt' => '-Select Role-',
            'class' => 'form-control select2',
            'onchange' => '
                var val = $(this).val();
                $.post("get-merch-list",
                    function( data ){
                        $("select#user-merchant_id").html(data);

                        if (val == "merchant_user") {
                            $(".sel-merchant").show("fast");
                        } else {
                            $(".sel-merchant").hide("fast");
                        }
                    }
                );
            '
        ]); } ?>

        <div class="sel-merchant" style="display: <?= ($model->role !== 'merchant_user')? 'none' : 'block'?> ">
            <?php 
                $lists = ArrayHelper::map(Merchant::find()->select(['id', "(CONCAT(merchant_id, ' - ', merchant_name)) as merchant_name"])->asArray()->all(), 'id', 'merchant_name');
                echo $form->field($model, 'merchant_id', ['enableClientValidation'=>false, 'enableAjaxValidation' => true])->label('Merchant')->dropDownList($lists, [
                'prompt' => '-Select Merchant-',
                'class' => 'form-control select2',
            ]); ?>
        </div>

            <?= $form->field($model, 'password')->passwordInput(['value' => '', 'maxlength' => true, 'class' => 'form-control']) ?>

            <?= $form->field($model, 'password_confirm')->passwordInput(['value' => '', 'maxlength' => true, 'class' => 'form-control']) ?>
        <div class="form-group">
            <?=
            Html::a('<span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span>Cancel', ['/admin/user-management/index'], [
                'class' => 'btn btn-labeled btn-info m-b-5 pull-left',
                'title' => 'Cancel'
            ])
            ?>&nbsp;

            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>&nbsp;

        <?php ActiveForm::end(); ?>
    </div>
</div>

<style type="text/css">
.select2-selection__arrow {
    margin-top: 0px;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #85888c;
    line-height: 15px;
}
</style>