<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Catatan */

$this->title = 'Update Catatan';
$this->params['breadcrumbs'][] = ['label' => 'Catatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="catatan-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
