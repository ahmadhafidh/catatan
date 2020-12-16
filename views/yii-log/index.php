<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\GridView;
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
<div class="yii-log-index">
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
                      'attribute' => 'level',
                      'label'=>'Level',
                      'headerOptions' => ['style' => 'text-align:center;'],
                      'contentOptions' => ['style' => 'text-align:center'],
                    ],
                    [
                      'attribute' => 'category',
                      'label'=>'category',
                      'headerOptions' => ['style' => 'text-align:center;'],
                      'contentOptions' => ['style' => 'text-align:center'],
                    ],
                    [
                      'attribute' => 'log_time',
                      'label'=>'log time',
                      'format' =>'datetime',
                      'headerOptions' => ['style' => 'text-align:center;'],
                      'contentOptions' => ['style' => 'text-align:center'],
                    ],
                    [
                        'class' => 'app\components\ActionColumn',
                        'template' => '{view}',
                        'header'=>'Actions',
                        'headerOptions'=>['style'=> 'width: 10%;text-align:center;color: #337ab7'],
                        'contentOptions'=>['style'=>'width: 10%;text-align:center;'],
                        'buttons' => [
                            'view' => function ($url, $model) {
                              return '<span data-reqId="'.$model->_id.'" data-href="'.Url::base().$url.'" class="fa fa-code modal-toggler"></span>';
                            },
                        ]
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
   $('.modal-toggler').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show')
         .find('.modal-body')
         .load($(this).data('href'));
   });
   $("input[name='YiiLogSearch[log_time]']").pickadate(
    {
      // container: "body",
      format: "dd-mm-yyyy"
    }
   );
});
JS;

$this->registerJs($js);
?>
