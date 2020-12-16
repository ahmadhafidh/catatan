<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_forgot_password".
 *
 * @property int $id
 * @property int $user_id
 * @property string $verification_code
 * @property string $created_date
 * @property string $expired_date
 * @property string $sent_date
 * @property int $status
 */
class UserForgotPassword extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_forgot_password';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_date', 'expired_date', 'sent_date'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['created_date', 'expired_date', 'sent_date'], 'safe'],
            [['verification_code'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'verification_code' => Yii::t('app', 'Verification Code'),
            'created_date' => Yii::t('app', 'Created Date'),
            'expired_date' => Yii::t('app', 'Expired Date'),
            'sent_date' => Yii::t('app', 'Sent Date'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
}
