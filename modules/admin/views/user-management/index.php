<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Management';

?>
<div class="user-model-index">
    <div class="row">
        <div class="col-md-12 text-sm-right">
              <?= Html::a('Add User', ['create'], ['class' => 'btn btn-info btn-md']) ?>
        </div>
    </div>
    <div class="table-responsive">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'includeModule' => true,
            'rowOptions' => function($dataProvider, $key, $index){
                $current = '/'.Yii::$app->controller->module->id;
                    return ['class' => 'row-hover clickable-row', 'data-href' => 'view?id='.$dataProvider->id];
                },
            'tableOptions' => ['class' => 'table'],
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['style'=>'text-align:left'],
                    'contentOptions' => ['style' => 'text-align:left'],
                    'header'=>'No'
                ],
                [
                    'label' => 'Username',
                    'attribute' => 'username',
                    'filterInputOptions' => [
                        'class' => 'form-control form-control-sm',
                    ],
                ],
                [
                   'label' => 'Role',
                   'attribute' => 'role',
                //    'filterInputOptions' => [
                //        'class' => 'form-control form-control-sm',
                //     ],
                ],
                [
                    'label' => 'Email',
                    'attribute' => 'email',
                    'filterInputOptions' => [
                        'class' => 'form-control form-control-sm',
                    ],
                ],
                [
                    'label' => 'Merchant',
                    'attribute' => 'merchant_id_name',
                    'filterInputOptions' => [
                        'class' => 'form-control form-control-sm',
                    ],
                    'value' => function ($model)
                    {
                        if (isset($model->merchant_id)) {
                            if ($model->merchant) {
                                return $model->merchant_id != 0 ? $model->merchant->merchant_name . ' - ' . $model->merchant->merchant_id : '-';
                            } 
                        }
                        return '-';
                    }
                ],
                [
                    'attribute' => 'status',
                    'label' => 'Status',
                    'format' => 'raw',
                    'filter' => Html::activeDropDownList($searchModel, 'status', ['0' => 'Inactive', '1' => 'Active'],['class'=>'form-control select2', 'prompt' => 'Status']),
                    'value' => function($dataProvider){
                      return $dataProvider->status==1 ? '<span style="color: green">Active</span>' : '<span style="opacity: 0.4">Inactive</span>';
                    }
                  ],
                [
                    'attribute' => 'created_date',
                    'label' => 'Created Date',
                    'filter' => 'pickadate',
                    'value' => function($dataProvider){
                      return date('d/m/Y', strtotime($dataProvider->created_date));
                    }
                ],
            ],
        ]);
        ?>
    </div>
</div>
