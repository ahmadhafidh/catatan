<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class ClearCacheController extends Controller
{
    public function actionIndex()
    {
        $clear = Yii::$app->cache->flush();
        if ($clear) {
        	echo "Success";
        	return ExitCode::OK;
        }
    	echo "Failed";
    	return ExitCode::UNSPECIFIED_ERROR;
    }
}
