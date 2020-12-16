<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\rbac\Menu;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

$icons = Yii::$app->params['icons'];
$bmenus = Menu::getMenuSource();
$menus = [];
$routes = ['' => '/#'];
foreach ($bmenus as $bm) {
    if (empty($bm['parent_name'])) {
        $menus[$bm['name']] = $bm['name'];
    }
}
ArrayHelper::removeValue($menus, $model->name);
$broutes = Menu::getSavedRoutes();
foreach ($broutes as $key => $value) {
    $routes[$value] = $value;
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"> 
                <h4 class="card-title">
                </h4>
            </div> 
            <div class="card-content"> 
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="menu-form">
                            <?php
                                $form = ActiveForm::begin(['action' =>['/admin-override/menu?id='.$model->id]]);
                                $model->data = json_decode($model->data, true);
                            ?>
                            <!-- <?= Html::activeHiddenInput($model, 'parent', ['id' => 'parent_id']); ?> -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>

                                    <?= $form->field($model, 'parent_name')->dropDownList($menus, ['prompt'=>'', 'class' => 'form-control select2']) ?>

                                    <?= $form->field($model, 'route')->dropDownList($routes, ['class' => 'form-control select2']) ?>

                                </div>
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'data[icon]')->dropDownList($icons, ['prompt'=>'Pilih Icon', 'class' => 'form-control select2'])->label('Icon') ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <?= Html::a('<span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span>Cancel', 
                                    ['/admin/menu/index'], 
                                    [
                                        'class' => 'btn btn-labeled btn-info m-b-5 pull-left', 
                                        'title' => 'Cancel'
                                    ]) ?>&nbsp;
                                <?=
                                Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
                                    ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
                                ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                        <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
