<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">                     
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title"> 
                <div class="caption"> 
                </div> 
                <div class="tools"> 
                    <a href="javascript:;" class="collapse"> </a> 
                    <a href="javascript:;" class="remove"> </a> 
                </div> 
            </div> 
            <div class="portlet-body"> 
                <div class="table-responsive">
                    <div class="tabbable-line boxless tabbable-reversed portlet light">
                 
                        <p>
                            <?= Html::a('<span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span>'.Yii::t('app', 'Back'), 
                                ['/admin/menu/index'], 
                                [
                                    'class' => 'btn btn-info', 
                                    'title' => 'Back'
                                ]) ?>
                            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                            <?=
                                Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ])
                            ?>
                        </p>

                        <div class="tab-content">
                            <div class="ownership-status-form">
                                <?=
                                    DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            // 'menuParent.name:text:Parent',
                                            [
                                                'label' => 'Parent',
                                                'attribute' => 'parent',
                                                'value' => function($model){
                                                    if (empty($model->parent)) {
                                                        return 'is Parent';
                                                    } else return $model->menuParent->name;
                                                }
                                            ],
                                            'name',
                                            'route',
                                            'order',
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


