<?php

namespace app\modules\admin\controllers;

use Yii;
use app\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

use app\models\Users as User;
use app\models\Merchant;
use app\models\WebSession;
use app\models\AuthAssignment;
use app\models\search\UserSearch;
use app\models\rbac\form\ChangePassword;
use app\components\TrackLogHelpers;

/**
 * UserManagementController implements the CRUD actions for Users model.
 */
class UserManagementController extends Controller
{

    const ROLE_ADMIN = 'admin';
    const ROLE_MERCHANT = 'merchant_user';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    // 'delete' => ['GET', 'POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->isAjax) {
            return $this->ajaxTotalCount($dataProvider);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $this->initPageSize($dataProvider),
            'sizes' => $this->sizes,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view_new', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $action = 'Delete User';

        $data = [
            'activity' => $action. ' '.Yii::$app->controller->id,
            'old_value' => json_encode($model->toArray()),
            'new_value' => NULL,
            'action' => $action,
            'model' => Yii::$app->controller->id,
            'model_id' => (string)$model->id,
            'url_referer' => Yii::$app->request->url,
        ];

        $getDifferentAttributes = TrackLogHelpers::insertTrailUser($data);
        $model->delete(false);
        Yii::$app->getSession()->setFlash('success', Yii::t("app","User deleted"));
        return $this->redirect(['index']);
    }

    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        $is_active = ($model->status == 1) ? 0 : 1;
        $model->status = $is_active;

        if ($model->save()) {

            if ($is_active == 0) {
                // $user_session = WebSession::findOne(['user_id' => $model->user_id]);
                // $session = \Yii::$app->session;
                // $session->setId($user_session->id);
                // $session->destroy();

                WebSession::deleteAll(['user_id' => $model->user_id]);
            }
            return $this->redirect(['index']);
        } else {
            // throw new NotFoundHttpException();
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist'));
        }
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->scenario = 'create';

        $dataPost = Yii::$app->request->post();

        $current_role = Yii::$app->user->identity->role;
        if ($current_role == self::ROLE_MERCHANT) {
            $dataPost['User']['role'] = self::ROLE_MERCHANT;
            $dataPost['User']['merchant_id'] = Yii::$app->user->identity->merchant_id;
        }

        if (Yii::$app->request->isAjax && $model->load($dataPost)) {
            if ($model->role == self::ROLE_ADMIN) {
                $model->merchant_id = '0';
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load($dataPost)) {
            if ($model->role == self::ROLE_ADMIN) {
                $model->merchant_id = '0';
            }
            // to administrator
            $now = date('Y-m-d H:i:s');
            $model->created_date = $now;
            $model->status = 1;

            $model->setPassword($model->password);
            $model->password_confirm = $model->password;

            $model->created_by = Yii::$app->user->identity->user_id;
            $model->created_by_name = (string) Yii::$app->user->identity->username;

            if ($model->validate() && $model->save()) {

                $assign = new AuthAssignment();
                $assign->user_id = (string)$model->user_id;
                $assign->item_name = (string)$model->role;
                $assign->created_at = date('U');
                $assign->save(false);

                Yii::$app->getSession()->setFlash('success', 'User added');
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('error', 'Error' . json_encode($model->errors));
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionChangePassword()
    {
        $model = new ChangePassword();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->change()) {
            $identity = Yii::$app->user->identity;
            $data = self::getTrailUser($identity);
            TrackLogHelpers::insertTrailUser($data);

            return $this->goHome();
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_role = $model->role;
        $old_password = $model->password;
        $model->scenario = 'update';

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if ($model->role == self::ROLE_ADMIN) {
                $model->merchant_id = '0';
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->role == self::ROLE_ADMIN) {
                $model->merchant_id = '0';
            }

            if ($old_role != $model->role) {
                $delete = AuthAssignment::deleteAll(['user_id' => $model->user_id]);

                $assign = new AuthAssignment();
                $assign->user_id = (string)$model->user_id;
                $assign->item_name = (string)$model->role;
                $assign->created_at = date('U');
                $assign->save(false);
            }

            if ($model->validate()) {
                if ($model->password && $model->password != '') {
                    $model->setPassword($model->password);
                    $model->password_confirm = $model->password;
                } else {
                    $model->password = $old_password;
                }
                $model->save();

                Yii::$app->getSession()->setFlash('success', 'User updated');
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('error', 'Error' . json_encode($model->errors));
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public static function actionGetMerchList()
    {

        $merchants = Merchant::getDb()->cache(function ($db) {
            return Merchant::find()->select(['id', 'merchant_id', 'merchant_name'])->where(['status' => '1'])->orderBy('id DESC')->all(); 
        });
        if (count($merchants)>0) { 

            echo "<option value=''>-Select Merchant-</option>";

            foreach($merchants as $val){ 
                echo "<option value='".$val->id."'>".$val->merchant_id." - ".$val->merchant_name."</option>"; 
            } 

        } else { 
            echo "<option value='0'>-Select Merchant-</option>";
        } 
    }

    private static function getTrailUser($identity)
    {
        $action = 'Change Password';
        $data = [
            'activity' => $action. ' '.$identity->username,
            'old_value' => NULL,
            'new_value' => NULL,
            'action' => $action,
            'model' => Yii::$app->controller->id,
            'model_id' => (string)$identity->user_id,
            'url_referer' => Yii::$app->request->url,
        ];

        return $data;
        
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist'));
    }

}
