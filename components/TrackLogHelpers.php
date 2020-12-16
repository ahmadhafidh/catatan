<?php
namespace app\components;

use Yii;
use yii\db\Query;
use app\models\log\AppAuditTrail;

class TrackLogHelpers {

    public static function insertTrailUser($data_insert, $data_user = null) {
        $user_id = '';
        $email = '';
		if (isset(Yii::$app->user->identity->username)) {
            $user_id = (string)Yii::$app->user->identity->username;
            
            $email = (string)Yii::$app->user->identity->email;
        }
        else if ($data_user != null) {
            $user_id = (string)$data_user[0];
            $email = $data_user[1];
        } else if (isset(Yii::$app->user->identity->user_id)) {
            $user_id = (string)Yii::$app->user->identity->user_id;
            $email = (string)Yii::$app->user->identity->email;
        }

        $user_id = (string)Yii::$app->user->identity->username;            
        $email = (string)Yii::$app->user->identity->email;
  
       
        $data_insert['user_id'] = $user_id;
        $data_insert['email'] = $email;
        $data_insert['activity'] = $data_user != null ? 'Reset Password' : $data_insert['activity'];
        $data_insert['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $data_insert['browser'] = $_SERVER['HTTP_USER_AGENT'];
        $data_insert['stamp'] = date('Y-m-d H:i:s');
        $data_insert['is_error'] = 0;

        $model = new AppAuditTrail();
        $model_auditTrail = new AppAuditTrail();
        $model->setAttributes($data_insert);
        
        if ($model->validate()) {
            $model->save();
          
        } else {
           
            $error_data = [
                'activity' => $data_insert['activity'],
                'action' => $data_insert['action'],
                'model' => $data_insert['model'],
                'stamp' => date('Y-m-d H:i:s'),
                'is_error' => 1,
                'user_id' => $data_insert['user_id'],
                'email' => $data_insert['email'],
                'url_referer' => $data_insert['url_referer'],
                'error_desc' => json_encode($model->errors),
            ];

            $model_auditTrail->setAttributes($error_data);
            $model_auditTrail->save(false);
        }
        // die;
    }


    public static function getDifferentAttributes($model, $attributes, $action)
    {
        $diff = [];
        $old_data = [];

        $action = explode(" ",$action);
        foreach ($attributes as $key => $value) {
            $new_value = $model->$value;
            if ($action[0] == 'Create') {
                $diff[$value] = $new_value;
            } else if ($action[0] == 'Update') {
                $old_value = $model->getOldAttribute($value);
                if ($old_value != $new_value){
                    $diff[$value] = $new_value;
                    $old_data[$value] = $old_value;
                }
            } else if ($action[0] == 'Delete') {
                $old_data[$value] = $new_value;
            }
        }
        return ['old_value' => $old_data, 'new_value' => $diff];
    }

    public static function detailList($model, $key)
    {
        $old_value = $model->old_value;
        
        $new_value = $model->new_value;

        // $dbChooser = Yii::$app->params['log_mode']['audit_trail'];
        // if($dbChooser == "db"){

            $value_old = json_decode($old_value, TRUE);
            $value_new = json_decode($new_value, TRUE);
            

        // }elseif($dbChooser == "mongo"){
           
            // $value_old = json_decode($old_value, TRUE);
            // $value_new = json_decode($new_value, TRUE);
        // } 

        return '<tr class="hidden" id="detail-'.$key.'">
                    <td colspan=10 style = "max-height : 400px;">
                        <div style="text-align:left;">
                            <table width="100%">
                                <tr>
                                    <td>Old Value</td>
                                    <tr>
                                        <td width="100%">
                                    <pre style="white-space: pre-wrap; word-wrap: break-word;height: 300px;">'.json_encode($value_old, JSON_PRETTY_PRINT).'</pre>
                                    </td>
                                    </tr>
                                    
                                </tr>
                                <tr>
                                    <td>New Value</td>
                                    <tr>
                                        <td width="100%">
                                        <pre style="white-space: pre-wrap; word-wrap: break-word;height: 300px;">'.json_encode($value_new, JSON_PRETTY_PRINT).'</pre>
                                        </td>
                                    </tr>
                                    <td width="30%"></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>';
    }
}