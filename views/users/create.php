<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Create Users';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
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
