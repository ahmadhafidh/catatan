<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\CustomGridView as GridView;
use yii\widgets\Pjax;
use app\components\RandomHelpers;
use yii\helpers\ArrayHelper;
use app\models\Users;
use app\components\Pagesize;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\log\search\AppAuditTrailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'App Audit Trails';
// $this->params['breadcrumbs'][] = $this->title;

?>

<div class="app-audit-trail-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h6 class="main-title d-block d-md-none"><?= Html::encode($this->title) ?></h6>
      </div>
      <div class="col-md-12" style="padding-left: 0px;padding-right: 0px;">
        <div class="col-md-12 p-0">
             <div class="table-responsive">
            <?= Pagesize::init($sizes, $_GET) ?>
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
                        'attribute' => 'user_id',
                        'label'=>'Username',
                        'headerOptions' => ['style' => 'text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center'],
                        'filter' => Html::activeDropDownList($searchModel, 'user_id', ArrayHelper::map(Users::find()->asArray()->all(), 'username', 'username'),['class'=>'form-control select2Cad','prompt' => 'Username']),
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
                        'attribute' => 'action',
                        'headerOptions' => ['style' => 'text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center'],
                        'label'=>'Action',
                    ],
                    [
                        'attribute' => 'stamp',
                        'headerOptions' => ['style' => 'text-align:center;'],
                        'contentOptions' => ['style' => 'text-align:center'],
                        'label'=>'Created Date',
                        "filterInputOptions" => ['class' => "form-control pickadate"]
                    ],
                
                    [
                          'class' => 'app\components\ActionColumn',
                          'template' => '{view}',
                          'header'=>'Actions',
                          'headerOptions' => ['style' => 'text-align:center;'],
                          'contentOptions' => ['style' => 'text-align:center'],

                          'buttons' => [
                              'view' => function ($url, $model) {
                                return '<a data-reqId="'.$model->_id.'" data-href="'.Url::base().$url.'" class="fa fa-code modal-toggler"></a>';
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
     e.preventDefault()
     openModal($(this).data('href'))
   });
});
JS;

$this->registerJs($js);
?>