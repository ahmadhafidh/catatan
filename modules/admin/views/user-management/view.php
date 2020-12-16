<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'View';
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">                     
        <div class="portlet light bordered">
            <div class="portlet-title"> 
                <div class="caption">
                    <?= Html::encode($this->title) ?>
                </div>
                <div class="tools"> 
                    <a href="javascript:;" class="collapse"> </a> 
                    <a href="javascript:;" class="remove"> </a> 
                </div> 
            </div> 
            <div class="portlet-body"> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="tabbable-line boxless tabbable-reversed portlet light bordered">
                            <div class="users-view">

                                <!-- <p>
                                    <?= Html::a('Update', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
                                    <?= Html::a('Delete', ['delete', 'id' => $model->user_id], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                </p> -->
                                <p>
                                    <?= Html::a('<span class="btn-label"><i class="glyphicon glyphicon-chevron-left"></i></span>Cancel',
                                    ['index'],
                                    [
                                        'class' => 'btn btn-labeled btn-info m-b-5 pull-left',
                                        'title' => 'Cancel'
                                    ]) ?>&nbsp;
                                    <?= Html::a('Update', ['update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
                                    <?php
                                    if ($model->status == 1) {
                                        echo Html::a('Inactive', ['activate', 'id' => $model->user_id], ['class' => 'btn btn-danger']);
                                    } else if ($model->status == 0) {
                                        echo Html::a('Activate', ['activate', 'id' => $model->user_id], ['class' => 'btn btn-success']);
                                    }
                                    ?>
                                </p>

                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        // [
                                        //     'attribute'     => 'parent_id',
                                        //     'label'         => 'Parent Name',
                                        //     'value' => function($data){
                                        //         return $data->parent->name;
                                        //     }
                                        // ],
                                        'email:email',
                                        'phone_number',
                                        'username',
                                        'short_description',
                                        [
                                            'label' => 'Auth Username',
                                            'value' => function($model) {
                                                if ($model->credential) {
                                                    $val = $model->credential->username;
                                                } else {
                                                    $val = '-';
                                                }
                                                return $val;
                                            },
                                        ],
                                        [
                                            'label' => 'Auth Password',
                                            'value' => function($model) {
                                                if ($model->credential) {
                                                    $val = $model->credential->password;
                                                } else {
                                                    $val = '-';
                                                }
                                                return $val;
                                            },
                                        ],
                                        [
                                            'label' => 'Access Token',
                                            'value' => function($model) {
                                                if ($model->credential) {
                                                    $val = $model->credential->access_token;
                                                } else {
                                                    $val = '-';
                                                }
                                                return $val;
                                            },
                                        ],
                                        [
                                            'label' => 'Token Expired Date',
                                            'value' => function($model) {
                                                if ($model->credential) {
                                                    $val = $model->credential->token_expired_date;
                                                } else {
                                                    $val = '-';
                                                }
                                                return $val;
                                            },
                                        ],
                                        [
                                            'label' => 'Created By',
                                            'attribute' => 'created_by_name',
                                        ],
                                        [
                                            'attribute'             => 'created_date',
                                            'value'                 => function($model){
                                                return \app\components\Helper::dateTimeFormat($model['created_date']);
                                            },
                                        ],

                                        [
                                            'label' => 'Status',
                                            'attribute' => 'status',
                                            'value' => function($model){
                                                if ($model->status == 0) {
                                                    $isActive = 'Inactive';
                                                } else
                                                    $isActive = 'Active';

                                                return $isActive;
                                            },
                                        ],
                                    ],
                                ]) ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>


