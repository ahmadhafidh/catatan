<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\components\rbac\MenuHelper;
use yii\widgets\Menu;

?>

<!--.main-menu(class="#{menuColor} #{menuOpenType}", class=(menuShadow == true ? 'menu-shadow' : ''))-->
<div data-active-color="black" data-image="" data-background-color="white" class="app-sidebar pt-md-2" style="box-shadow: none; padding-top: 60px !important">
    <!-- main menu content-->
    <div style="padding-bottom: 150px; background-color: white" class="sidebar-content mt-md-3">
        <div class="nav-container">
            <?php
            $callback = function($menu)
            {
                $data = json_decode($menu['data'], true);
                $icon = isset($data['icon']) ? $data['icon'] : '';
                $hide = !(isset($data['hide']) ? ($data['hide'] == 1 ? true : false) : false);
                $accordion = !empty($menu['children']) ? '<span class="arrow"></span>' : '';
                $ret = [
                    'label' => $menu['name'],
                    'visible' => $hide,
                    'url' => $menu['route'] == null ? '#' : [$menu['route']],
                    'items' => $menu['children'],
                    'options' => $menu['route'] == null ? ['class' => 'has-sub nav-item'] : ['class' => 'nav-item'],
                    'template' => '<a href="{url}"><i class="' . $icon . '"></i>' . $accordion . ' {label}</a>',
            //        'template' => '<a href="{url}">'
            //        .'<div class="row">
            //            <div class="col-sm-2">
            //              <i class="'.$icon.'"></i>
            //            </div>
            //            <div class="col-sm-10">
            //              '.$accordion.' <span class="title">{label}</span>
            //            </div>
            //          </div>
            //        </a> '
                ];
                return $ret;
            };
                $items = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback);
                $me = Menu::widget([
                    'options' => ['class' => 'navigation navigation-main',],
                    // 'activateParents' => true,
                    'submenuTemplate' => "\n<ul class='menu-content'>\n{items}\n</ul>\n",
                    'items' => $items
                ]);
            ?>
            <?= $me ?>
        </div>
    </div>
    <!-- main menu content-->
    <!-- <div class="sidebar-background"></div> -->
    <!-- main menu footer-->
    <!-- include includes/menu-footer-->
    <!-- main menu footer-->
</div>