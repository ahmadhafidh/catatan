<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Create Rule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <?=
    $this->render('_form', [
        'model' => $model,
    ]);
    ?>

</div>
