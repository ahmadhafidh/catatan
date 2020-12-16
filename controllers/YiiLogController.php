<?php

namespace app\controllers;

use Yii;
use app\models\log\YiiLog;
use app\models\log\search\YiiLogSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * YiiLogController implements the CRUD actions for YiiLog model.
 */
class YiiLogController extends Controller
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
     * Lists all YiiLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new YiiLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // print_r($dataProvider);
        // exit;
        if (Yii::$app->request->isAjax) {
            return $this->ajaxTotalCount($dataProvider);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single YiiLog model.
     * @param integer $_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        // dd($this->findModel($id)->old_value);
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing YiiLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the YiiLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return YiiLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = YiiLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
