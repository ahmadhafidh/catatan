<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\Modal;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<html lang="en" class="loading">
<!-- BEGIN : Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="author" content="PT. SPE">
    <?php $this->registerCsrfMetaTags() ?>

    <title><?= Html::encode(Yii::$app->name) ?></title>
<!--     <link rel="apple-touch-icon" sizes="60x60"
        href="<?php echo Yii::getAlias('@web/apex/') ?>img/ico/apple-icon-60.png">
    <link rel="apple-touch-icon" sizes="76x76"
        href="<?php echo Yii::getAlias('@web/apex/') ?>img/ico/apple-icon-76.png">
    <link rel="apple-touch-icon" sizes="120x120"
        href="<?php echo Yii::getAlias('@web/apex/') ?>img/ico/apple-icon-120.png">
    <link rel="apple-touch-icon" sizes="152x152"
        href="<?php echo Yii::getAlias('@web/apex/') ?>img/ico/apple-icon-152.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::getAlias('@web/') ?>favicon.ico"> -->
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo Url::home().'' ?>">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link
        href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900|Montserrat:300,400,500,600,700,800,900"
        rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->

    <!-- END Page Level CSS-->
    <?php $this->head() ?>
</head>
<!-- END : Head-->
<?php $this->beginBody() ?>
<!-- BEGIN : Body-->

<body data-col="2-columns" class=" 2-columns " style="background-color: white">
    <div class="wrapper">

        <!-- main menu-->
        <?php echo Yii::$app->controller->renderPartial('@app/views/layouts/_main_sidebar');?>
        <!-- / main menu-->
        <!-- Navbar (Header) Starts-->
        <?php echo Yii::$app->controller->renderPartial('@app/views/layouts/_main_header');?>
        <!-- Navbar (Header) Ends-->


        <div class="main-panel">
            <!-- BEGIN : Main Content-->
            <div class="main-content">

                <div class="content-wrapper">
                    <div class="px-1">
                        <?= $content ?>
                    </div>
                </div>
            </div>
            <!-- END : End Main Content-->

            <!-- BEGIN : Footer-->
            <footer class="footer footer-static footer-light">
                <p class="clearfix text-muted text-sm-center px-2">
                    <span></span>
                </p>
            </footer>
            <!-- End : Footer-->
        </div>
        <div id="modal" class="fade modal" role="dialog" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                    <span id="text_to_be_copied" class="modal-title"></span>
                    <button onclick="copyLink(this)" class="btn btn-sm btn-light">
                            <span class="fa fa-link"></span> Copy Link
                        </button>
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">

                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
<!-- END : Body-->
<?php $this->endBody() ?>

</html>
<?php $this->endPage() ?>