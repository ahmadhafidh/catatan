<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->registerCssFile("@web/apex/data/jquery-nestable/jquery.nestable.css", ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@web/apex/data/jquery-nestable/jquery.nestable.js',['depends' => [\yii\web\JqueryAsset::className()]]);

$script = <<<JS
    var updateOutput = function (e) {
        $('#nestable_menu_output').val(JSON.stringify($('.dd').nestable('serialize')));
    };

    $('.dd').nestable({
        // group: 1,
        // maxDepth: 7,
    }).on('change', updateOutput);
JS;

$this->registerJs($script);

// $this->title = Yii::t('app', 'Menus');
// $this->params['breadcrumbs'][] = $this->title;

$this->title = Yii::t('app', 'Easy Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menus'), 'url' => ['/admin/menu/index']];
$this->params['breadcrumbs'][] = $this->title;

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
                        <?= Html::a('<span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span>'.Yii::t('app', 'Back'), 
                            ['/admin/menu/index'], 
                            [
                                'class' => 'btn btn-sm btn-info', 
                                'title' => 'Back'
                            ]) ?>
                        <?= Html::a('<i class="icon-plus"></i> Add Menu', ['admin/menu/create'], ['class' => 'btn btn-sm btn-success']) ?>
                        <?= Html::submitButton('<i class="icon-check"></i> Save', ['class' => 'btn btn-sm btn-primary']) ?>
                    </div>
                    <div class="portlet-body"> 
                        <div class="table-responsive">
                            <div class="tabbable-line boxless tabbable-reversed portlet light">
                                <?= Html::beginForm(['admin-override/menu-easy-order'], 'post') ?>
                         
                                
                                <div class="tab-content">

                                    <?= Html::input('hidden', 'new_order', '', ['id' => 'nestable_menu_output']) ?>

                                    <div class="ownership-status-form">
                                        <div class="dd" id="nestable_menu">
                                            <ol class="dd-list">
                                                <?php foreach ($menuItems as $menu) { ?>
                                                <li class="dd-item dd3-item" data-id="<?=$menu['id']?>">
                                                    <div class="dd-handle dd3-handle tooltips" data-original-title="Drag Menu" data-placement="left"></div>
                                                    <div class="dd3-content">
                                                        <?=$menu['label']?>
                                                         <div class="pull-right">
                                                             <?= Html::a(
                                                                '<i class="icon-pencil"></i>',
                                                                ['admin/menu/update', 'id' => $menu['id']],
                                                                ['data-original-title' => 'Update Menu',
                                                                'class' => 'tooltips',]
                                                            ) ?>
                                                             <?= Html::a(
                                                                '<i class="icon-trash"></i>',
                                                                ['admin/menu/delete', 'id' => $menu['id']],
                                                                ['data-original-title' => 'Delete Menu',
                                                                    'class' => 'tooltips',
                                                                    'data' => [
                                                                        'confirm' => 'Are you sure you want to delete menu?',
                                                                        'method' => 'post',
                                                                    ]
                                                                ]
                                                            ) ?>
                                                        </div>
                                                    </div>
                                                    <?php if (isset($menu['items'])) { ?>
                                                    <ol class="dd-list">
                                                    <?php foreach ($menu['items'] as $child) { ?>
                                                        <li class="dd-item dd3-item" data-id="<?=$child['id']?>">
                                                            <div class="dd-handle dd3-handle"></div>
                                                            <div class="dd3-content">
                                                                 <?=$child['label']?>
                                                                 <div class="pull-right">
                                                                     <?= Html::a(
                                                                        '<i class="icon-pencil"></i>',
                                                                        ['admin/menu/update', 'id' => $child['id']],
                                                                        ['data-original-title' => 'Update Menu',
                                                                        'class' => 'tooltips',]
                                                                    ) ?>
                                                                     <?= Html::a(
                                                                        '<i class="icon-trash"></i>',
                                                                        ['admin/menu/delete', 'id' => $child['id']],
                                                                        ['data-original-title' => 'Delete Menu',
                                                                            'class' => 'tooltips',
                                                                            'data' => [
                                                                                'confirm' => 'Are you sure you want to delete menu?',
                                                                                'method' => 'post',
                                                                            ]
                                                                        ]
                                                                    ) ?>
                                                                 </div>
                                                            </div>
                                                        </li>
                                                    <?php } ?>
                                                    </ol>
                                                    <?php } ?>
                                                </li>
                                                <?php } ?>
                                            </ol>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="btn-group pull-right margin-top-10">
                                                <?= Html::submitButton('<i class="icon-check"></i> Save', ['class' => 'btn btn-sm btn-primary']) ?>
                                            </div>
                                        </div>
                                    </div>  
                                    <?= Html::endForm() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>

