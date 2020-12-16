<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\EmailHelpers;

class UserPasswordForm extends Model
{
    public $token;
    public $email;
    public $password_new;
    public $password_confirm;
    public $password_old;

    private $_user;
    private $_userUfp;

    public function rules()
    {
        return [
            [['email'], 'email'],
            [['email', 'password_new', 'password_confirm'], 'trim'],
            [['email'], 'required', 'on' => 'forgot'],
            [['email'], 
                'exist',
                'on' => 'forgot',
                'targetClass' => '\app\models\Users',
                'filter' => ['status' => Users::STATUS_ACTIVE],
                'message' => 'Tidak ada user dengan alamat email ini atau user tidak aktif.'
            ],

            [['password_new', 'password_confirm'], 'string', 'min' => 8],
            [['password_new', 'password_confirm'], 'required', 'on' => ['reset', 'change']],
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

            [['password_old'], 'required', 'on' => 'change'],
            [['password_old'], 'validatePassword'],
            [['token'], 'required', 'on' => 'reset'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'token' => Yii::t('app', 'Token'),
            'password_new' => Yii::t('app', 'Password'),
            'password_confirm' => Yii::t('app', 'Password Confirm'),
            'password_old' => Yii::t('app', 'Current Password'),
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['forgot'] = ['email'];
        $scenarios['reset']  = ['password_new', 'password_confirm'];
        $scenarios['change'] = ['password_old', 'password_new', 'password_confirm'];

        return $scenarios;
    }

    public function validatePassword($attribbute)
    {
        if (!$this->hasErrors())
        {
            //
        }
    }

    public function forgot()
    {
        if (!$this->validate())
            return false;

        $this->getUser('email');

        return $this->sendEmail();
    }

    public function reset()
    {
        if (!$this->validate())
            return false;

        $this->_user->setPassword($this->password_new);
        $this->_userUfp->verification_code = null;
        $this->_userUfp->status = 0;
        $this->_user->save();
        $this->_userUfp->save();

        return true;
    }

    public function change()
    {
        if (!$this->validate())
            return false;

        $this->getUser('email');

        if ($this->_user->validatePassword($this->password_old))
        {
            $this->_user->password = Yii::$app->security->generatePasswordHash($this->password_new);

            return $this->_user->save();
        }

        return false;
    }

    public function getUser($from = 'email')
    {
        switch ($from)
        {
            case 'token':
                $ufp = UserForgotPassword::findOne([
                    'verification_code' => $this->token,
                    'status' => 1,
                ]);
                $this->_userUfp = $ufp;
                $user = isset($ufp->user) ? $ufp->user : null;
                break;
            default:
                $user = Users::findOne([
                    'email' => $this->email,
                    'status' => Users::STATUS_ACTIVE,
                ]);
                break;
        }

        $this->_user = $user;

        return $user;
    }

    public function sendEmail()
    {
        date_default_timezone_set("Asia/Jakarta");

        if (!$this->_user)
            return false;

        $now = date('Y-m-d H:i:s');
        $expire = time() + Yii::$app->params['user.passwordResetTokenExpire'];
        $expireDate = date('Y-m-d H:i:s', $expire);
        $this->_user->generatePasswordResetToken();
        $tokenReset = $this->_user->password_reset_token;
        $request = $this->_user->userForgotPassword;

        if ($request)
        {
            if ($this->checkTime($request->created_date))
                return false;
            
            $request->verification_code = $tokenReset;
            // $request->created_date = $now;
            $request->sent_date =  $now;
            $request->expired_date = $expireDate;
            $request->status = 1;
        } else {
            $request = new UserForgotPassword();
            $request->setAttributes([
                'user_id' => $this->_user->id,
                'verification_code' => $tokenReset,
                'created_date' => $now,
                'sent_date' => $now,
                'expired_date' => $expireDate,
                'status' => 1,
            ]);
        }

        if ($request->validate() && $request->save())
        {
            $sendEmail = EmailHelpers::sendForgotPassword([
                'user' => $this->_user,
                'reset_token' => $tokenReset,
                'email' => $this->email,
                'subject' => 'Lupa Kata Sandi - ' . Yii::$app->name,
            ]);

            return $sendEmail;
        }

        return false;
    }

    public function isTokenValid()
    {
        $time = new \DateTime($this->_userUfp->expired_date);
        $stamp = $time->format('Y-m-d H:i:s');
        $now = date('Y-m-d H:i:s');

        return ($stamp < $now) ? false : true;
    }

    public function checkTime($createdDate)
    {
        $interval = 5; // minutes
        $time = new \DateTime($createdDate);
        $time->add(new \DateInterval('PT' . $interval . 'M'));

        $stamp = $time->format('Y-m-d H:i:s');
        $now = date('Y-m-d H:i:s');

        return ($stamp < $now) ? false : true;
    }
}
