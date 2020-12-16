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
                        <!-- 
                        <a id="dropdownBasic3" href="#" data-toggle="dropdown" class="nav-link position-relative dropdown-toggle">
                            <i class="ft-user font-medium-3 blue-grey darken-4"></i>
                            <p class="d-none">User Settings</p>
                        </a>
                        <div ngbdropdownmenu="" aria-labelledby="dropdownBasic3" class="dropdown-menu text-left dropdown-menu-right">
                            <a href="<?= Url::to(['/profile']) ?>" class="dropdown-item py-1">
                                <i class="icon-user mr-2"></i> <span class="text-center"><?= ucwords(Yii::$app->user->identity->username) ?></span>
                            </a>
                            <a href="<?= Url::to(['/profile/change-password']) ?>" class="dropdown-item py-1">
                                <i class="icon-lock mr-2"></i> <span>Change Password</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="/site/logout" class="dropdown-item"><i class="ft-power mr-2"></i><span>Logout</span></a>
                        </div> -->
                    </li>
                </ul>

            </div>
        </div>
    </div>
</nav>