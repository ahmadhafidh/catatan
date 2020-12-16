<?php

namespace app\controllers;

use Yii;
use app\models\Transaksi;
use app\models\TransaksiSearch;
use app\models\UploadDocForm;
use app\components\ImportExcel;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransaksiController implements the CRUD actions for Transaksi model.
 */
class TestController extends Controller
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
     * Lists all Transaksi models.
     * @return mixed
     */
    public function actionIndex()
    {
        header('Cache-Control: no cache,must-revalidate');
        ini_set("memory_limit","-1");
        ini_set("max_execution_time",0);

        $user_id = Yii::$app->user->identity->id;
        $model = new UploadDocForm();

        $data_post = Yii::$app->request->post();
        if ($model->load($data_post)) {
            $data_upload = ImportExcel::saveFileExcel($model, 'file_data', $user_id);

            // $filename = '';
            // if ($import['status'] == 1) {
            //     $filename = $import['filename'];
            // }

            $import = ImportExcel::importExcel($data_upload, $user_id);

            return $this->render('status', [
                'model' => $model,
                'status' => true
            ]);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionStatus()
    {
        $model = new UploadDocForm();

        $dataPost = Yii::$app->request->post();
        
        // if (Yii::$app->request->isAjax && $model->load($dataPost)) {
        //     Yii::$app->response->format = Response::FORMAT_JSON;
        //     return ActiveForm::validate($model);
        // }

        if ($dataPost) {
            $model->file_data = UploadedFile::getInstance($model, 'file_data');
            $now = date('Y-m-d H:i:s');
            $crnt_dir = \Yii::getAlias('@webroot');
            $path = '/documents/';
            $upload_dir = $crnt_dir.$path;
            $filename = $model->file_data->name;

            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0775, true);
            }

            if (strlen($filename) > 35 && strpos($filename, ' ') == false || strpos($filename, '_') == true || strpos($filename, '-') == true) {
                $filename = 'File Upload '.date('d F Y H i s').'.'.$model->file_data->extension;
            }

            $identity = Yii::$app->user->identity;

            $data = new TechnicalDocuments();
            $data->setAttributes([
                'name' => $filename,
                'path' => $path.$filename,
                'created_date' => $now,
                'created_by' => $identity->user_id,
                'created_by_name' => $identity->username
            ]);

            if ($model->upload($upload_dir, $filename) && $data->save(false)) {
                // file is uploaded successfully
                return $this->redirect(['index']);
            } 
            return $this->render('status', [
                'model' => $model,
            ]);
        }

        return $this->render('status', [
            'model' => $model,
        ]);
    }

    public function actionImportExcel()
    {   
        header('Cache-Control: no cache,must-revalidate');
        ini_set("memory_limit","-1");
        ini_set("max_execution_time",0);

        $model = new Bulk();

        if (BulkLog::findUploadProgress(Yii::$app->user->identity->user_id, null, 'register')) {
            return $this->render('submerchant_bulk_new_v2', [
                'model' => $model,
                'status' => true
            ]);
        } 

        if ($model->load(Yii::$app->request->post())) {
            $import = ImportExcelNew::importExcel($model, 'bulk', Yii::$app->user->identity->user_id);

            $filename = '';
            if ($import['status'] == 1) {
                $filename = $import['filename'];
            }

            $userId   = Yii::$app->user->identity->user_id;
            $userType = Yii::$app->user->identity->user_type;
            $merchantIdLogin = Yii::$app->user->identity->merchant_id;

            $path = Yii::getAlias('@command');
            $pathDetailLog = $path . "/web/uploads/bulk_log_detail/";

            if (!file_exists($pathDetailLog)) {
                mkdir($pathDetailLog, 0775, true);
            }

            $command = "nohup " . PHP_PATH . ' ' . $path . DIRECTORY_SEPARATOR ."yii bulk {$userId} {$merchantIdLogin} {$userType} null > ". $pathDetailLog ."{$filename}.txt &";

            // TEST ON WINDOWS   
            // $command = 'start /B ' . PHP_PATH . ' ' . $path . DIRECTORY_SEPARATOR . "yii bulk {$userId} {$merchantIdLogin} {$userType} null > ". $pathDetailLog ."{$filename}.txt"; // TODO dynamic action and params 

            if ($import['status'] == 1) {
                sleep(1);
                // ImportExcelNew::execInBackground($command);

                // get pid
                $pid = ProcessHelper::getPid($command);

                // update table set pid
                $bulk = BulkLog::find()->where(['user_id' => $userId])->orderBy(['created_date' => SORT_DESC])->one();
                $bulk->pid = $pid;
                $bulk->save(false);

                // run background process to check pid

                $command_check = "nohup " . PHP_PATH . ' ' . $path . DIRECTORY_SEPARATOR ."yii bulk/check {$pid} > /dev/null &";
                ImportExcelNew::execInBackground($command_check);
            }

            return $this->render('submerchant_bulk_new_v2', [
                'model' => $model,
                'status' => true
            ]);
        }
        
        return $this->render('submerchant_bulk_new_v2', [
            'model' => $model,
            'status' => false
        ]);
    }

    /**
     * Finds the Transaksi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaksi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaksi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist'));
    }
}
