<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\CustomGridView as GridView;
use yii\widgets\Pjax;
use app\components\RandomHelpers;
use yii\helpers\ArrayHelper;
use app\models\Users;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\log\search\AppAuditTrailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'App Audit Trails';
// $this->params['breadcrumbs'][] = $this->title;

?>
<style>
.picker {
    z-index: 100000;
    position: relative;
}
</style>
<div class="app-log-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h6 class="main-title d-block d-md-none"><?= Html::encode($this->title) ?></h6>
      </div>
      <div class="col-md-12" style="padding-left: 0px;padding-right: 0px;">
        <div class="col-md-12 p-0">
             <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
				 'options' => ['style' => 'font-size: 12px;', 'class' => 'grid-view'],
                'rowOptions' => function($dataProvider){
                    return ['class' => 'row-hover '];
                },
                'columns' => [
                    [
                      'class' => 'yii\grid\SerialColumn',
                      'header' => 'No',
                    ],
                    [
                        'attribute' => 'id',
                        'label'=>'ID',
                        'headerOptions' => ['style' => 'text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center'],
                    ],
                    [
                        'attribute' => 'user_id',
                        'label'=>'User Name',
                        'headerOptions' => ['style' => 'text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center'],
                        'filter' => Html::activeDropDownList($searchModel, 'user_id', ArrayHelper::map(Users::find()->asArray()->all(), 'id', 'username'),['class'=>'form-control select2Cad','prompt' => 'Username']),
                        'value' => function($model) {
                            $user = Users::findOne($model->user_id);
                            if($user) {
                                return $user->username;
                            } else {
                                return $model->user_id;
                            }
                        }
                    ],
                    [
                      'attribute' => 'expire',
                      'label'=>'expire',
                      'format' =>'datetime',
                      'headerOptions' => ['style' => 'text-align:center;'],
                      'contentOptions'=>['style'=>'width: 25%;text-align:center;'],
                    ],
                    [
                      'attribute' => 'type',
                      'label'=>'type',
                      'headerOptions' => ['style' => 'text-align:center;'],
                      'contentOptions' => ['style' => 'text-align:center'],
                    ],
                ],
            ]); ?>
            </div>

        </div>
      </div>
    </div>
  </div>

</div>
<?php
$js = <<<JS
$(function() {
   $("input[name='WebSessionSearch[expire]']").pickadate(
    {
      // container: "body",
      format: "dd-mm-yyyy"
    }
   );
});
JS;

$this->registerJs($js);
?>
