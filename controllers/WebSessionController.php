<?php

namespace app\controllers;

use Yii;
use app\models\WebSession;
use app\models\WebSessionSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WebSessionController implements the CRUD actions for WebSession model.
 */
class WebSessionController extends Controller
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
     * Lists all WebSession models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WebSessionSearch();
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

    /**
     * Displays a single WebSession model.
     * @param string $id
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
     * Deletes an existing WebSession model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WebSession model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WebSession the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WebSession::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
