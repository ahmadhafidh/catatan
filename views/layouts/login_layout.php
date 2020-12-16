<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\LoginAsset;

LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo Url::home().'' ?>">

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body data-col="1-column" class=" 1-column  blank-page"  style="background-color: white">
<?php $this->beginBody() ?>
  <div class="wrapper">
      <div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
          <div class="content-wrapper"><!--Login Page Starts-->
              <div class="row full-height-vh m-0">
                  <div class="col-12 p-0 d-flex align-items-center justify-content-center">
                      <?= $content ?>
                  </div>
              </div>
          </div>
        </div>
      </div>
  </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
