<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\ChangePassword */

$this->title = Yii::t('app', 'Change Password');
// $this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6 text-sm-right">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 px-3 px-lg-5">
                <div class="card-content"> 
                    <div class="card-body">
                        <div class="user-form">
                            <br>
                            <br>
                            <p>Please fill out the following fields to change password:</p>
                            <br>
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php $form = ActiveForm::begin(); ?>
                                        <?= $form->field($model, 'oldPassword')->passwordInput() ?>
                                        <?= $form->field($model, 'newPassword')->passwordInput() ?>
                                        <?= $form->field($model, 'retypePassword')->passwordInput() ?>
                                        <div class="form-group" style="text-align: center">
                                            <br>
                                            <?= Html::submitButton(Yii::t('app', 'Change'), ['class' => 'btn btn-info btn-md', 'name' => 'change-button']) ?>
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
