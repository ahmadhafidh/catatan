<?php

use app\assets\RBACAutocomplete;
use yii\helpers\Html;
use yii\helpers\Json;
use app\components\rbac\Configs;
use app\components\rbac\RouteRule;
use yii\widgets\ActiveForm;

$context = $this->context;
$labels = $context->labels();
$rules = Configs::authManager()->getRules();
unset($rules[RouteRule::RULE_NAME]);
$source = Json::htmlEncode(array_keys($rules));

$js = <<<JS
    $('#rule_name').autocomplete({
        source: $source,
    });
JS;

// RBACAutoComplete::register($this);
$this->registerJs($js);

?>

<div class="auth-item-form">
    <?php $form = ActiveForm::begin(['id' => 'item-form']); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
        </div>
        <?php /*
        <div class="col-sm-6">
            <?= $form->field($model, 'ruleName')->textInput(['id' => 'rule_name']) ?>

            <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>
        </div>
        */ ?>
    </div>
    <div class="form-group">
        <?= Html::a('<span class="btn-label"><i class="fa fa-chevron-left"></i></span> Cancel', 
            ['index'], 
            [
                'class' => 'btn btn-sm btn-labeled btn-info m-b-5 pull-left', 
                'title' => 'Cancel'
            ]) ?>&nbsp;
        <?php
        echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), [
            'class' => $model->isNewRecord ? 'btn btn-sm btn-success' : 'btn btn-sm btn-primary',
            'name' => 'submit-button'])
        ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
