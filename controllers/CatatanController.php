<?php

namespace app\controllers;

use Yii;
use app\models\Catatan;
use app\models\CatatanSearch;
// use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CatatanController implements the CRUD actions for Catatan model.
 */
class CatatanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Catatan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $count = Yii::$app->db->createCommand('SELECT SUM(nominal) FROM catatan')->queryScalar();

        if (Yii::$app->request->isAjax) {
            return $this->ajaxTotalCount($dataProvider);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $this->initPageSize($dataProvider),
            // 'dataProvider' => $dataProvider,
            'count' => $count,
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
     * Displays a single Catatan model.
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
     * Creates a new Catatan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    { 
        $model = new Catatan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Catatan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {

            $model->user_id = Yii::$app->user->identity->id;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();
            
            return $this->redirect(['index']);

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Catatan model.
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
     * Finds the Catatan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Catatan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Catatan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionChangestatus()
    {
        $status = (Yii::$app->request->post('status') == 'true') ? 1 : 0 ;
        $id = Yii::$app->request->post('id');
        if (($model = Catatan::findOne($id)) !== null) {
            $model->status = $status;
            $model->save(false);
            return true;
        }
    }
}
