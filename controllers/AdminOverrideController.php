<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\rbac\AuthItem;
use app\models\rbac\Menu;
use app\components\rbac\Helper;
use yii\web\NotFoundHttpException;
use yii\base\UserException;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;

class AdminOverrideController extends Controller
{
    public $type;

    public function actionMenu($id = null)
    {
        if ($id) {
            $model = $this->findMenuModel($id);
        } else {
            $model = new Menu(null);
        }

        $post_data = Yii::$app->getRequest()->post();
        $menus = ArrayHelper::map(Menu::getMenuSource(), 'id', 'name');
        $post_data['Menu']['data'] = json_encode(Yii::$app->getRequest()->post('Menu')['data']);
        if ($parent = ArrayHelper::removeValue($menus, Yii::$app->getRequest()->post('Menu')['parent_name'])) {
            $post_data['Menu']['parent'] = array_keys($parent)[0];
        } else {
            $post_data['Menu']['parent'] = null;
        }
        if ($model->load($post_data) && $model->save()) {
            Helper::invalidate();
            // return $this->redirect(['/admin/menu/view', 'id' => $model->id]);
            return $this->redirect(['/admin/menu/index']);
        }

        throw new UserException('Error managing menu, please contact your supervisor.');
    }

    public function actionMenuEasyOrder()
    {

        $model = Yii::$app->getRequest()->post();
        // echo '<pre>';
        // print_r($model);die();

        if ($new_order = Yii::$app->getRequest()->post('new_order')) {
            $new_order = json_decode($new_order);

            $connection = Yii::$app->db;
            foreach ($new_order as $parent_index => $parent_item) {
                $parent_model = $this->findMenuModel($parent_item->id);
                $parent_model->order = $parent_index +1;
                $parent_model->parent = null;
                $parent_model->save();
                if (isset($parent_item->children)) {
                    foreach ($parent_item->children as $children_index => $children_item) {
                        $children_model = $this->findMenuModel($children_item->id);
                        $children_model->order = $children_index;
                        $children_model->parent = $parent_item->id;
                        $children_model->save();
                    }
                }
            }
            Helper::invalidate();
            return $this->redirect(['/admin/menu']);
        }
        // $page_name = 'Menu Easy Order';
        $icon = 'icon-cursor-move';
        // // $this->view->params['dev_notice'] = Yii::$app->params['dev_notice']['wip'];

        // Yii::$app->view->title = $page_name.' | '.Yii::$app->name;
        // Yii::$app->params['breadcrumbs'] = array(
        //     ['label' => 'Access Menu', 'url' => ['/admin/menu']],
        //     'Easy Order',
        // );

        $items = $this->getMenus();

        return $this->render('easy_order', [
            'menuItems' => $items,
            'pageName' => '',//$page_name,
            'icon' => $icon,
        ]);
    }

    // protected function findItemModel($id)
    // {
    //     $auth = Yii::$app->getAuthManager();
    //     $item = $this->type === Item::TYPE_ROLE ? $auth->getRole($id) : $auth->getPermission($id);
    //     if ($item) {
    //         return new AuthItem($item);
    //     } else {
    //         throw new NotFoundHttpException('The requested page does not exist.');
    //     }
    // }

    protected function findMenuModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist'));
        }
    }

    public function getMenus($ar = null, $pid = null) {
        if (!$ar) {
            $tableName = 'menu';
            $ar = (new \yii\db\Query())
                ->select(['m.id', 'm.name', 'm.order', 'm.route', 'parent_id' => 'p.id'])
                ->from(['m' => $tableName])
                ->leftJoin(['p' => $tableName], '[[m.parent]]=[[p.id]]')
                ->all();
        }

        $op = array();
        foreach( $ar as $item ) {
            if( $item['parent_id'] == $pid ) {
                $op[$item['id']] = array(
                    'id' => $item['id'],
                    'label' => $item['name'],
                    'url' => $item['route'],
                    'parent_id' => $item['parent_id'],
                    'order' => $item['order'],
                );
                $children =  $this->getMenus( $ar, $item['id'] );
                if( $children ) {
                    $op[$item['id']]['items'] = $children;
                }
                $order[] = $item['order'];
            }
            if ($op != []) {
                array_multisort($order, $op);
            }
        }
        return $op;
    }
}