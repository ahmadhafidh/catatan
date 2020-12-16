<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Request;
use yii\filters\VerbFilter;

use app\models\Transaksi;
use app\models\EcollLog;
use app\models\MasterKejaksaan;
use app\components\BniHashing;

/**
 * Country Controller API
 *
 */
class NotificationController extends Controller
{    
    public $enableCsrfValidation = false;

  	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['post'],
                ],
            ],
        ];
    }

  	public function actionIndex() {
    	$req = new Request();
        $postData = $req->post();

        if (empty($postData)) {
            $ecollData = json_decode(file_get_contents('php://input'), true);
            $vaCredential = MasterKejaksaan::find()
                ->select([
                    'cid',
                    'secret_key',
                    'prefix'
                ])
                ->where(['cid' => $ecollData['client_id']])
                ->one();
                    
            if (!empty($vaCredential)) {
                $parseData = BniHashing::parseData($ecollData['data'], $ecollData['client_id'], $vaCredential->secret_key);
                if (!empty($parseData)) {
                    $model = new Transaksi();
                    $result = $model->updateData($parseData);
                    
                    $log = new EcollLog;
                    $session = Yii::$app->session;
                    $ingoing = $session['ingoing'];
                    $ingoing['request_raw'] = json_encode($ecollData);
                    $ingoing['request_parsed'] = json_encode($parseData);                
                    $ingoing['response_raw'] = $result;
                    $ingoing['response_parsed'] = $result;
                    $session['ingoing'] = $ingoing;
                    $logged = $log->simpanLogingoing($model, $parseData);

                    if(isset($result) && json_decode($result)->status == '000') {
                        return $result;
                    } else {
                        return $result;
                    }
                }
            } else {
                return json_encode([
                    'status' => '009',
                    'message' => 'Telah terjadi kesalahan. Data tidak di temukan.'
                ]);
            }
        } else {
            return json_encode([
                'status' => '001',
                'message' => 'Incomplete / Invalid Parameter(s).'
            ]); 
        }        
  	}
}