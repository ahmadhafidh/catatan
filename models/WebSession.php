<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "web_session".
 *
 * @property string $id
 * @property int|null $user_id
 * @property int|null $expire
 * @property string $type user login type
 * @property resource|null $data
 */
class WebSession extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'web_session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['user_id', 'expire'], 'integer'],
            [['type', 'data'], 'string'],
            [['id'], 'string', 'max' => 40],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'expire' => 'Expire',
            'type' => 'Type',
            'data' => 'Data',
        ];
    }
}
