<?php
use yii\helpers\Html;

$this->title = 'Update Permission : '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Permisssion', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
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
                    <div class="tabbable-line boxless tabbable-reversed portlet light">
                        <div class="col-md-12">
                            <div class="ownership-status-form">
                                <?=
							        $this->render('_form', [
							            'model' => $model,
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
