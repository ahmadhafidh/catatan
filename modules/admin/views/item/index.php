<?php

use app\components\rbac\RouteRule;
use app\components\rbac\Configs;
use yii\helpers\Html;
use app\components\CustomGridView as GridView;

// $this->title = 'Permission';
$this->registerCssFile(Yii::getAlias('@web/'). 'css/style-grid.css', ['depends'=>['app\assets\AppAsset']]); 
$this->registerCss('.table th, .table td {padding: 0.75rem !important;}');

$context = $this->context;
$labels = $context->labels();
$this->title = Yii::t('app', $labels['Items']);
// $this->params['breadcrumbs'][] = $this->title;

$rules = array_keys(Configs::authManager()->getRules());
$rules = array_combine($rules, $rules);
unset($rules[RouteRule::RULE_NAME]);
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
                        <?= Html::a(Yii::t('app', 'Create '.$labels['Item']), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
                    </div>
                <div class="table-responsive">
                    <div class="tabbable-line boxless tabbable-reversed portlet light">
                        <div class="tab-content">
                            <div class="ownership-status-form">
                                <?=
                                    GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'filterModel' => $searchModel,
                                        'tableOptions' => ['class' => 'table table-bordered table-sm'],
                                        'pager' => [
                                            'firstPageLabel' => '<i class="fa fa-fast-backward"></i>',
                                            'lastPageLabel' => '<i class="fa fa-fast-forward"></i>',
                                            'options' => [
                                                'class' => 'pagination justify-content-end',
                                            ],
                                            'linkOptions' => ['class' => 'page-link'],
                                            'activePageCssClass' => 'page-item active',
                                            'disabledPageCssClass' => 'disabled',
                                        ],
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],
                                            [
                                                'attribute' => 'name',
                                                'label' => Yii::t('app', 'Name'),
                                            ],
                                            // [
                                            //     'attribute' => 'ruleName',
                                            //     'label' => Yii::t('app', 'Rule Name'),
                                            //     'filter' => $rules
                                            // ],
                                            [
                                                'attribute' => 'description',
                                                'label' => Yii::t('app', 'Description'),
                                            ],
                                            // ['class' => 'yii\grid\ActionColumn',],
                                            [
                                                'class' => 'yii\grid\ActionColumn',
                                                'template' => '{view} {update} ', //'{delete}',
                                                'header'=>'Actions',
                                                'headerOptions'=>['style'=> 'width: 15%;text-align:center;color: #337ab7'],
                                                'contentOptions'=>['style'=>'width: 15%;text-align:center;'],
                                                'buttons' => [
                                                    'view' => function ($url) {
                                                        return Html::a(
                                                            '<button type="button" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></button>',
                                                            $url,
                                                            [
                                                                'title' => 'View',
                                                                // 'data-pjax' => '0',
                                                                // 'data' => [
                                                                //     'method' => 'post',
                                                                // ]
                                                            ]
                                                        );
                                                    },

                                                    'update' => function ($url) {
                                                        return Html::a(
                                                            '<button type="button" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></button>',
                                                            $url,
                                                            [
                                                                'title' => 'Update',
                                                                'data-pjax' => '0',
                                                                'data' => [
                                                                    'method' => 'post',
                                                                ]
                                                            ]
                                                        );
                                                    },

                                                    'delete' => function ($url, $model) {
                                                        return Html::a(
                                                            '<button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>',
                                                            $url,
                                                            [
                                                                'title' => 'Delete',
                                                                'data-pjax' => '0',
                                                                'data'=>[
                                                                   'method' => 'post',
                                                                   'confirm' => 'Are you sure?',
                                                               ],
                                                            ]
                                                        );
                                                    },
                                                ]
                                            ],
                                        ],
                                    ])
                                ?>
                            </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>

