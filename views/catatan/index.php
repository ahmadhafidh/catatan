<?php

use yii\helpers\Html;
use app\models\Users;
use yii\helpers\ArrayHelper;
use app\components\CustomForm as ActiveForm;
use app\components\GridView;
// use app\components\Pagesize;

$this->title = 'Catatan';
$this->params['breadcrumbs'][] = $this->title;

$js = <<< JS
    $(".toggleStatus").change(function(){
        let id = $(this).data("id")
        let status = $(this).data("status")== "1"
        
        // alert(status)
        // return false
        sendRequest(!status, id)
    })
    function sendRequest(status, id){
        $.ajax({
            url:'/catatan/changestatus',
            method:'post',
            data:{status:status,id:id},
            success:function(data){
                // console.log(data);
                window.location.reload();
                // alert(data);
            },
            error:function(jqXhr,status,error){
                alert(error);
            }
        });
    }
JS;

$this->registerJs($js, \yii\web\View::POS_READY);
?>
<div class="catatan-index">

    <div class="card-body">
        <div class="col-md-12 text-md-right mt-3">
            <?= Html::a('Tambah catatan', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <b>Total Nominal</b>
    <b>: <?= $count; ?></b>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'options' => ['style' => 'font-size: 12px;', 'class' => 'grid-view'],
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'header' => 'No'
                ],
                [
                    'header' => 'Nama',
                    'attribute' => 'nama',
                ],
                [
                    'header' => 'Nominal',
                    'attribute' => 'nominal',
                    'value' => function($data){
                        if($data->nominal == null){
                            return '-';
                         }else{
                           return $data->nominal;
                         }
                        // return 'Rp. ' . number_format($data->nominal);
                    },
                ],
                [
                    'attribute' => 'status',
                    'contentOptions' => [ 'style' => 'width: 10%;' ],
                    'filter' => Html::activeDropDownList($searchModel, 'status', 
                        ['0' => 'Inactive', '1' => 'Active'],
                        ['class'=>'form-control select2Cad', 'prompt' => 'Status']),
                    'content' => function($model, $data) {
                        return $model->status==1 ? '<span style="color: green">Active</span>' : '<span style="opacity: 0.4">Inactive</span>';
                    },
                ],
                [
                    'header' => 'Action',
                    'attribute' => 'status',
                    'filter' => false,
                    'format' => 'raw',
                    'contentOptions' => [ 'class' => 'text-center' ],
                    'value' => function($data){
                        $checked = $data->status==1 ? "checked" : "";
                        return '<label class="switch">
                        <input class="toggleStatus" value="'.$data->status.'" data-status="'.$data->status.'" data-id="'.$data->id.'" type="checkbox" '.$checked.'>
                        <span class="slider round"></span>
                        </label>';
                    }
                ],
                [
                    'attribute' => 'user_id',
                    'label'=>'Teman Dari',
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
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}{delete}',
                    'header' => 'Action',
                    'buttons' => [
                        'view' =>  function($url, $model) {
                            return Html::a('<i class="fa fa-eye"></i>', $url, [
                                'title' => 'View',
                                'data-pjax' => '0',
                                'class' => 'btn btn-primary btn-sm',
                            ]) . "&nbsp;";
                        },
                        'update' =>  function($url, $model) {
                            return Html::a('<i class="fa fa-pencil"></i>', $url, [
                                'title' => 'Update',
                                'class' => 'btn btn-info btn-sm',
                            ]) . "&nbsp;";
                        },
                        'delete' =>  function($url, $model) {
                            return Html::a('<i class="icon-trash"></i>', $url, [
                                'title' => 'Delete',
                                'data' => [
                                    'confirm' => 'Apakah anda yakin untuk menghapus data ini?',
                                    'method' => 'post',
                                ],
                                'class' => 'btn btn-danger btn-sm',
                                'data-method'=>'post',
                            ]) . "&nbsp;";
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>