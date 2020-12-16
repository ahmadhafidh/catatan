<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Update Rule') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="auth-item-update">

    <?=
    $this->render('_form', [
        'model' => $model,
    ]);
    ?>
</div>
