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
class AppAuditTrail extends \yii\mongodb\ActiveRecord
{
    public $user;
	public $username;
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return 'app_audit_trail';
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
            [['old_value', 'new_value', 'error_desc'], 'string'],
            [['action', 'model', 'stamp'], 'required'],
            [['stamp'], 'safe'],
            [['is_error'], 'integer'],
            [['activity'], 'string', 'max' => 50],
            [['action', 'model', 'model_id', 'user_id', 'email', 'url_referer', 'browser'], 'string', 'max' => 255],
            [['ip_address'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'activity' ,
            'old_value' ,
            'new_value' ,
            'action' ,
            'model' ,
            'model_id' ,
            'user_id' ,
            'email' ,
            'ip_address' ,
            'url_referer' ,
            'browser' ,
            'stamp' ,
            'is_error' ,
            'error_desc' ,
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

}   
