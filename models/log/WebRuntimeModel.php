<?php

namespace app\models\log;

use Yii;

class WebRuntimeModel  extends \yii\mongodb\ActiveRecord
{
    public static function collectionName()
    {
        return 'yii_log';
    }

    /**
     * {@inheritdoc}
     */

    public static function getDb()
    {
        return Yii::$app->get('log_mongo');
    }
    public function attributes()
    {
        return [
            '_id',
            'level', 
            'category', 
            'log_time' ,
            'prefix' ,
            'message',
            'created_date',
        ];
    }

    /**
     * {@inheritdoc}
     */
    
    public function rules()
    {
        return [
            [['_id','level', 'category', 'log_time' ,'prefix' ,'message','created_date'], 'safe']
        ];
    }
}