<?php
use yii\helpers\Html;
use app\components\GridView;
use yii\helpers\ArrayHelper;

$this->title = 'User Setting';
$this->registerCss('
    ul.custom-list {
        margin: 0;
        padding-left: 14px;
    }
    ul.custom-list li {
        margin: 0;
        padding-left: 0;
        line-height: 1rem;
    }
');

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
            url:'/users/changestatus',
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
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-content"> 
                <div class="card-body">
                    <div class="col-md-12 text-md-right">
                        <?= Html::a('Tambah User', ['create'], ['class' => 'btn btn-primary btn-md']) ?>
                    </div>
                    <div class="tabbable-line boxless tabbable-reversed portlet light">
                        <div class="tab-content">
                            <div class="ownership-status-form">                            
                                <?= 
                                    GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'filterModel' => $searchModel,
                                        'options' => ['style' => 'font-size: 12px;', 'class' => 'grid-view'],
                                        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
                                        'columns' => [
                                            [
                                                'class' => 'yii\grid\SerialColumn',
                                                'header' => 'No'
                                            ],
                                            [
                                                'attribute' => 'username',
                                                'label' => 'Nama User',
                                            ],
                                            [
                                                'attribute' => 'email',
                                                'label' => 'Email',
                                                'contentOptions' => [ 'style' => 'width: 12%;' ],
                                            ],
                                            [
                                                'attribute' => 'role',
                                                'label' => 'Role',
                                                'contentOptions' => [ 'style' => 'width: 12%;' ],

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
                                                'class' => 'yii\grid\ActionColumn',
                                                'template' => '{view}{update}',
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
                                                ],
                                            ],
                                        ],
                                    ]);
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