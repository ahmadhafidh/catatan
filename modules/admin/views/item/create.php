<?php
use yii\helpers\Html;

$context = $this->context;
$labels = $context->labels();
$this->title = Yii::t('app', 'Create ' . $labels['Item']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $labels['Items']), 'url' => ['index']];
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
