<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\UsersSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\UserRegisterForm;
use yii\widgets\ActiveForm;
use app\models\AuthAssignment;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    // 'delete' => ['POST'],
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
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->isAjax) {
            return $this->ajaxTotalCount($dataProvider);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $this->initPageSize($dataProvider),
            'sizes' => $this->sizes
        ]);
    }

    public function actionToggle($id)
	{
		$model = $this->findModel($id);
		if($model->status == 1) $model->status = 0;
        else $model->status = 1;
        
        
		$model->save(false);
       
        return $this->redirect(['index']);
    }
    
    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        error_reporting(-1);
        
        $model = new UserRegisterForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

           return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($model->signup())
                return $this->redirect(['/users/index']);
        }

        return $this->render('create', [
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

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            $model->save();

            $test = new AuthAssignment();//::find()->where(["=",'user_id' ,$id])->all();
            
            if($test!=null){
                $test->deleteAll('user_id = '. $id);
            }

            $update = new AuthAssignment();

            $update->user_id = $id;
            $update->created_at = time();

            $update->item_name = $model->role;
            $update->save(false);
            \Yii::$app->cache->flush();
            return $this->redirect(['users/index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist'));
    }

    public function actionChangestatus()
    {
        $status = (Yii::$app->request->post('status') == 'true') ? 1 : 0 ;
        $id = Yii::$app->request->post('id');
        if (($model = Users::findOne($id)) !== null) {
            $model->status = $status;
            $model->save(false);
            return true;
        }
    }
}
