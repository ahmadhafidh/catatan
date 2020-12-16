<?php

namespace app\models;

use Yii;
use yii\base\Model;

class UserRegisterForm extends Model
{
    public $id;
    public $username;
    public $password_new;
    public $auth_key;
    public $email;
    public $kejaksaan_id;
    public $role;
    public $status;
    public $password_confirm;

    public function rules()
    {
        return [
            [['kejaksaan_id'], 'each', 'rule' => ['string']],
            [['email'], 'email'],
            [['status'], 'default', 'value' => Users::STATUS_INACTIVE],
            [['username', 'role', 'auth_key'], 'string'],
            [['password_new', 'password_confirm'], 'string', 'min' => 8],
            [['password_new', 'password_confirm'], 
                'match',
                'pattern' => '/^.*(?=.*\d)(?=.*[\W])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/',
                'message' => Yii::t("app","Password must fullfill following criteria : One Uppercase, One Symbol and One Number")
            ],
            [['password_confirm'],
                'compare',
                'compareAttribute' => 'password_new',
                'message' => Yii::t("app","Passwords do not match")
            ],
            [['status'], 'integer'],
            [['role'], 'in', 'range' => Users::getRoleAsArray()],
            [['username', 'email', 'role', 'password_new', 'password_confirm'], 'required'],
            ['role', 'checkRole'],
            ['username', 'unique', 'targetClass' => '\app\models\Users', 'message' => Yii::t("app","This username has already been taken")],
            ['email', 'unique', 'targetClass' => '\app\models\Users', 'message' => Yii::t("app","This email has already been taken")],
            [['username'], 
                'match',
                'pattern' => '/^\\S*$/',
                'message' => Yii::t("app","Cannot use whitespace")
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'password_new' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'kejaksaan_id' => Yii::t('app', 'Kejaksaan'),
            'role' => Yii::t('app', 'Role'),
            'status' => Yii::t('app', 'status'),
        ];
    }
    
    public function checkRole($attribute)
    {
        if (!$this->hasErrors())
        {
            if ($this->role != 'superadmin' && empty($this->kejaksaan_id))
                $this->addError('kejaksaan_id', 'Harap pilih kejaksaan');
        }
    }

    public function signup()
    {
        if (!$this->validate()) {
            
            return false;
        }
        $model = new Users();
        $model->generateAuthKey();
        $model->setAttributes([
            'username' => $this->username,
            'password' => Yii::$app->security->generatePasswordHash($this->password_new),
            'email' => $this->email,
            'kejaksaan_id' => ($this->kejaksaan_id) ? $this->kejaksaan_id : '0',
            'role' => $this->role,
            'status' => '1'
        ]);
        
        if ($model->save(false))
        {
            $auth_assignment = new AuthAssignment();
            $auth_assignment->item_name = $this->role;
            $auth_assignment->user_id = $model->id;
            $auth_assignment->created_at = time();
            $auth_assignment->save();

            $this->id = $model->id;

            return true;
        }

        return false;
    }
}
