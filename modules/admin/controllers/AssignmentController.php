<?php

namespace app\modules\admin\controllers;

use Yii;
use app\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\rbac\Assignment;
use app\models\rbac\searchs\Assignment as AssignmentSearch;

class AssignmentController extends Controller
{
    public $userClassName;
    public $idField = 'id';
    public $usernameField = 'username';
    public $fullnameField;
    public $searchClass;
    public $extraColumns = [];

    public function init()
    {
        parent::init();
        if ($this->userClassName === null) {
            $this->userClassName = Yii::$app->getUser()->identityClass;
            $this->userClassName = $this->userClassName ? : 'app\models\membership\user\User';
        }
    }

    public function behaviors()
    {
        $this->enableCsrfValidation = false; 
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'assign' => ['post'],
                    'assign' => ['post'],
                    'revoke' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

        if ($this->searchClass === null) {
            $searchModel = new AssignmentSearch;
            $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams(), $this->userClassName, $this->usernameField);
        } else {
            $class = $this->searchClass;
            $searchModel = new $class;
            $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
        }

        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        // dd($dataProvider);
        if (Yii::$app->request->isAjax) {
            return $this->ajaxTotalCount($dataProvider);
        }
        return $this->render('index', [
            'dataProvider' => $this->initPageSize($dataProvider),
            'sizes' => $this->sizes,
            'searchModel' => $searchModel,
            'idField' => $this->idField,
            'usernameField' => $this->usernameField,
            'extraColumns' => $this->extraColumns,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
                'model' => $model,
                'idField' => $this->idField,
                'usernameField' => $this->usernameField,
                'fullnameField' => $this->fullnameField,
        ]);
    }

    public function actionAssign($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = new Assignment($id);
        $success = $model->assign($items);
        Yii::$app->getResponse()->format = 'json';
        return array_merge($model->getItems(), ['success' => $success]);
    }

    public function actionRevoke($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = new Assignment($id);
        $success = $model->revoke($items);
        Yii::$app->getResponse()->format = 'json';
        return array_merge($model->getItems(), ['success' => $success]);
    }

    protected function findModel($id)
    {
        $class = $this->userClassName;
        if (($user = $class::findIdentity($id)) !== null) {
            return new Assignment($id, $user);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist'));
        }
    }
}
