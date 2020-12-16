<?php

namespace app\models\log;

use Yii;
use app\models\User;
/**
 * This is the model class for table "smartcom_dev_log.app_audit_trail".
 *
 * @property string $activity
 * @property string $old_value
 * @property string $new_value
 * @property string $action
 * @property string $model
 * @property string $model_id
 * @property string $user_id
 * @property string $email
 * @property string $ip_address
 * @property string $url_referer
 * @property string $browser
 * @property string $stamp
 * @property int $is_error 0 success, 1 error
 * @property string $error_desc
 */
class YiiLog extends \yii\mongodb\ActiveRecord
{
    public $user;
	public $username;
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return 'yii_log';
    }

    public static function getDb()
    {
        return Yii::$app->get('log_mongo');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {

        return [
            [['category','message'], 'string'],
            [['level','log_time'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'level' ,
            'category' ,
            'log_time' ,
            'message' ,
        ];
    }

    // public function getUser()
    // {
    //     return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    // }

}   
