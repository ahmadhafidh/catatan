<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Client */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'User Details';
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['/admin/user-management/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="row">
        <div class="col-md-6">
            <p class="form-outer-title-spc"><?= Html::encode($this->title) ?> </p>
        </div>
        <div class="col-md-6 text-sm-right">
            <?= Html::a('Edit User', ['update?id='.$model->user_id], ['class' => 'btn btn-primary btn-md']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 px-3 px-lg-5">
                <div class="card-content"> 
                    <div class="card-body">
                        <div class="user-form">
                            <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        // 'id',
                                        [
                                            'group' => 'user_information',
                                            'items' => [
                                                'username',
                                                'email:Email:email',
                                                'merchant_id+merchant_name:merchant',
                                                'status:User is active:boolean:User is inactive', 
                                                'created_by_name', 
                                                'created_date'
                                            ],
                                        ],
                                    ],
                                ]) ?>
                            <div class="col-md-12 form-group">
                                <?php $form = ActiveForm::begin(); ?>
                                <?= Html::a('<span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span>Back', ['/admin/user-management/index'], [
                                    'class' => 'btn btn-labeled btn-info m-b-5',
                                    'title' => 'Back'
                                ])
                                ?>&nbsp;&nbsp;
                                <?php
                                    if ($model->status != '1') {
                                        $label = 'Activate';
                                    } else {
                                        $label = 'Inactivate';
                                    }
                                    echo Html::a('<span class="btn-info"><i class="glyphicon glyphicon-chevron-left"></i></span>'.$label, ['/admin/user-management/activate?id='.$model->user_id], [
                                        'class' => 'btn btn-labeled btn-secondary m-b-5',
                                        'title' => $label,
                                        'data' => [
                                            'confirm' => 'Are you sure ?',
                                        ]
                                ])
                                ?>&nbsp;
                                <?= Html::a('<span class="btn-danger"><i class="glyphicon glyphicon-chevron-left"></i></span>Delete', ['/admin/user-management/delete?id='.$model->user_id], [
                                    'class' => 'btn btn-labeled btn-danger m-b-5',
                                    'title' => 'Delete',
                                    'data' => [
                                            'confirm' => 'Are you sure ?',
                                        ]
                                ])
                                ?>&nbsp;&nbsp;
                                <?php ActiveForm::end(); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>

