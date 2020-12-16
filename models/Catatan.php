<?php

namespace app\models;

use Yii;
use app\components\TrackLogHelpers;
/**
 * This is the model class for table "catatan".
 *
 * @property int $id
 * @property string|null $nama
 * @property string|null $nominal
 * @property int|null $status
 * @property int|null $user_id
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Catatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const STATUS_INACTIVE = 0;	
    const STATUS_ACTIVE = 1;
    
    public static function tableName()
    {
        return 'catatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id','nominal'], 'integer'],
            ['status', 'default', 'value' => 0],
            [['created_at', 'updated_at'], 'safe'],
            [['nama'], 'string', 'max' => 255],
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
            'nama' => 'Nama',
            'nominal' => 'Nominal',
            'status' => 'Status',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function beforeSave($insert)	
    {	
        //AUDIT TRAIL	
        $attributes = $this->attributes();	
        $primary_key = $this->id;	
        if (parent::beforeSave($insert)) {	
            if ($insert) { //insert action	
                $action = 'Create Catatan';	
                $getDifferentAttributes = TrackLogHelpers::getDifferentAttributes($this, $attributes, $action);	
            }else{	
                $action = 'Update Catatan';	
                $getDifferentAttributes = TrackLogHelpers::getDifferentAttributes($this, $attributes, $action);	
            }	
            $data = [	
                'user_id'=> Yii::$app->user->identity->id,	
                'activity' => $action. ' '.Yii::$app->controller->id,	
                'old_value' => count($getDifferentAttributes['old_value']) > 0 ? json_encode($getDifferentAttributes['old_value']) : NULL,	
                'new_value' => count($getDifferentAttributes['new_value']) > 0 ? json_encode($getDifferentAttributes['new_value']) : NULL,	
                'action' => $action,	
                'model' => Yii::$app->controller->id,	
                'model_id' => (string)$primary_key,	
                'url_referer' => Yii::$app->request->url,	
            ];	
            $getDifferentAttributes = TrackLogHelpers::insertTrailUser($data);	
				
            return true;	
        } else {	
            return false;	
        }	
        return true;
    }

    public static function getStatusList()	
    {	
        return [	
            ['id' => self::STATUS_ACTIVE, 'name' => 'Activate'],	
            ['id' => self::STATUS_INACTIVE, 'name' => 'Inactivate'],	
        ];	
    }
}
