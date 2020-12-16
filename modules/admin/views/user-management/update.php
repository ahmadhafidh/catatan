<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
$this->title = 'Update User';
$this->params['breadcrumbs'][] = ['label' => 'User Management', 'url' => ['/admin/user-management/index']];
// $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
	<div class="row">
        <div class="col-md-6">
            <p class="form-outer-title-spc"><?= Html::encode($this->title) ?> </p>
        </div>
        <div class="col-md-6">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 px-3 px-lg-5">
                <div class="card-content"> 
                    <div class="card-body">
                            <?= $this->render('_form', [
                                'model' => $model,
                            ]) ?>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>