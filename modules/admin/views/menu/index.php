<?php

use yii\helpers\Html;
use app\components\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\rbac\Menu;

$this->title = Yii::t('app', 'Menus');
// $this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile(Yii::getAlias('@web/'). 'css/style-grid.css', ['depends'=>['app\assets\AppAsset']]); 
$this->registerCss('.table th, .table td {padding: 0.75rem !important;} .kv-grid-wrapper { height: 500px !important; }');
$filters['is Parent'] = "Is Parent";
$filters =$filters+ArrayHelper::map(Menu::find()->where(['parent' => null]) ->andWhere(['route' => null])->asArray()->all(), 'name', 'name');

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
                        <?= Html::a(Yii::t('app', 'Create Menu'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
                        <?= Html::a(Yii::t('app', 'Easy Menu Order'), ['/admin-override/menu-easy-order'], ['class' => 'btn btn-sm btn-info']) ?>
                    </div>
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
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'headerOptions' => ['style' => 'width: 5%;'],
                                ],
                                [
                                    'label' => 'Name',
                                    'attribute' => 'name',
                                ],
                                // [
                                //     'attribute' => 'menuParent.name',
                                //     'filter' => Html::activeTextInput($searchModel, 'parent_name', [
                                //         'class' => 'form-control', 'id' => null
                                //     ]),
                                //     'label' => Yii::t('app', 'Parent'),
                                // ],
                                [
                                    'label' => 'Parent',
                                    'attribute' => 'parent_name',
                                    'filter' => Html::activeDropDownList($searchModel, 'parent_name', $filters,[
                                        'class'=>'form-control select2Cad','prompt' => 'All Menu']),
                                    'value' => function($model){
                                        if (!isset($model->menuParent->name)) {
                                            return 'is Parent';
                                        } else return $model->menuParent->name;
                                    }
                                ],
                                [
                                    'label' => 'Route',
                                    'attribute' => 'route',
                                ],
                                // 'order',
                                [
                                    'label' => 'Order',
                                    'attribute' => 'order',
                                    'headerOptions' => ['style' => 'width: 10%;'],
                                    // 'contentOptions' => ['style' => 'text-align:center']
                                ],
                                // [
                                //     'label' => 'Icon',
                                //     'value' => function($model){
                                //         $model = json_decode($model->data, true);
                                //         return '<i class="'.$model['icon'].'">';
                                //     },
                                //     'format' => 'raw',
                                //     'headerOptions' => ['style' => 'color: #337ab7'],
                                //     // 'contentOptions' => ['style' => 'text-align:center']
                                // ],
                                // ['class' => 'yii\grid\ActionColumn'],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{update} {delete}',
                                    'header'=>'Actions',
                                    'headerOptions'=>['style'=> 'width: 10%;text-align:center;color: #337ab7'],
                                    'contentOptions'=>['style'=>'width: 10%;text-align:center;'],
                                    'buttons' => [
                                        'update' => function ($url) {
                                            return Html::a(
                                                '<button type="button" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></button>',
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
                                                '<button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>',
                                                $url,
                                                [
                                                    'title' => 'Delete',
                                                    'data-pjax' => '0',
                                                    'data'=>[
                                                        'method' => 'post',
                                                        'confirm' => 'Are you sure?',
                                                        'params'=>['id' => $model->id],
                                                    ],
                                                ]
                                            );
                                        },
                                    ]
                                ],
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div> 
    </div>
</div>

