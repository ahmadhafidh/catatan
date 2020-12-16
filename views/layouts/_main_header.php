<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

?>
<nav class="navbar navbar-expand-lg navbar-light bg-faded header-navbar">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" data-toggle="collapse" class="navbar-toggle d-lg-none float-left"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><span class="d-lg-none navbar-right navbar-collapse-toggle"><a aria-controls="navbarSupportedContent" href="javascript:;" class="open-navbar-container black"><i class="ft-more-vertical"></i></a></span>
        <h3 class="nav-title-1"><?= Html::encode($this->title) ?></h3>
        </div>
        <h3 class="nav-title-2"><?= Html::encode($this->title) ?></h3>

        <div class="navbar-container">
            <div id="navbarSupportedContent" class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="dropdown nav-item">
                        <?= Html::a(' <i class="fa ft-log-out"></i> '.Yii::t('app', 'Logout'), ['/site/logout'], ['class' => 'btn btn-logout']) ?>
                      
                    </li>
                </ul>

            </div>
        </div>
    </div>
</nav>