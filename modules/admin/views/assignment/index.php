<?php

use yii\helpers\Html;
use app\components\GridView;
use yii\widgets\Pjax;
use app\models\Users;

$this->title = 'Assignment';
// $this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile(Yii::getAlias('@web/'). 'css/style-grid.css', ['depends'=>['app\assets\AppAsset']]);
$this->registerCss('.table th, .table td {padding: 0.75rem !important;} .kv-grid-wrapper { height: 500px !important; }');

$js = <<<JS
    $(document).ready(function() { 
        $('.select2').each(function () {
            $(this).select2({
                placeholder: "Select one",
                allowClear: true,
                dropdownAutoWidth : true,
                width: "100%"
            });
        });
        
	$('.pickadate').pickadate({
		format: 'yyyy-mm-dd',
	});
    });
JS;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"> 
            </div> 
            <div class="card-content"> 
                <div class="card-body">
                    <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
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
                                    'contentOptions' => ['style' => 'text-align:center;'],
                                ],
                                [
                                    'label'=>'Username',
                                    'attribute' => 'username',
                                    'filterInputOptions' => [
                                        'class' => 'form-control form-control-sm',
                                    ],
                                    // 'filter' => Html::activeDropDownList($searchModel, 'name', array('' => 'All') + Users::findAvailable('name'), [
                                    //     'class' => 'form-control select2',
                                    //     'data-plugin' => 'select2',
                                    // ]),
                                ],
                                [
                                    'label'=>'Email',
                                    'attribute' => 'email',
                                    'filter'=>false,
                                    'filterInputOptions' => [
                                        'class' => 'form-control form-control-sm',
                                    ],
                                ],
                                // [
                                //     'label' => 'User Type',
                                //     'attribute' => 'roles',
                                //     'filter' => array('super_admin' => 'Super Admin', 'admin' => 'Admin', 'user_client' => 'User Client'),
                                //     'filterInputOptions' => [
                                //         'class' => 'form-control select2',
                                //         'data-plugin' => 'select2',
                                //     ],
                                //     'value' => function ($model)
                                //     {
                                //         switch ($model->user_type) {
                                //             case 'super_admin':
                                //                 return 'Super Admin';
                                //                 break;
                                //             case 'admin':
                                //                 return 'Admin';
                                //                 break;
                                //             case 'user_client':
                                //                 return 'User Client';
                                //                 break;
                                //             default:
                                //                 '-';
                                //         }
                                //     }
                                // ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{view}',
                                    'header' => 'Actions',
                                    'headerOptions' => ['style' => 'width: 8%;text-align:center;color: #337ab7'],
                                    'contentOptions' => ['style' => 'text-align:center;'],
                                    'buttons' => [
                                        'view' => function ($url)
                                        {
                                            return Html::a(
                                                            '<button type="button" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></button>', $url, [
                                                        'title' => 'Detail',
                                                        'data-pjax' => '0',
                                                            ]
                                            );
                                        },
                                        'update' => function ($url)
                                        {
                                            return Html::a(
                                                            '<button type="button" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></button>', $url, [
                                                        'title' => 'Update',
                                                        'data-pjax' => '0',
                                                            ]
                                            );
                                        },
                                        'delete' => function ($url, $model)
                                        {
                                            return Html::a(
                                                            '<button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>', $url, [
                                                        'title' => 'Delete',
                                                        'data-pjax' => '0',
                                                        'data' => [
                                                            'method' => 'post',
                                                            'confirm' => 'Are you sure?',
                                                            'params' => ['id' => $model->id],
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
