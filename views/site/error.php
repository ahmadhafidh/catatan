<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

// $this->title = $name;

?>
<div class="site-error">

    <h1><?= Html::encode($name) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        <?= Yii::t("app","The above error occurred while the Web server was processing your request") ?>
    </p>
    <p>
        <?= Yii::t("app","Please contact us if you think this is a server error") ?>
    </p>
    <p>
        <?= Yii::t("app","Thank you") ?>
    </p>

</div>