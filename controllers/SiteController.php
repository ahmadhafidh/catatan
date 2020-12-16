<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\UserPasswordForm;
use yii\web\NotFoundHttpException;
use yii\web\NotAcceptableHttpException;
use app\components\EmailHelpers;
use app\components\TrackLogHelpers;
use app\models\MasterKotakab;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout', 'localization'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get','post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action) 
    { 
        $ai = $action->id;
        $arr = [
            'login',
            'reset-password',
            'forgot-password',
            'change-password'
        ];
        if(!in_array($ai, $arr)) {
            if (Yii::$app->user->isGuest){
                $this->redirect(Url::base(true).'/'.Yii::$app->controller->id.'/login');
            }
        }

        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect('dashboard');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'login_layout';
        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->role == 'staff') {
                return $this->redirect('/pelanggar');
            }
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $data = self::getTrailUser($model->username);
            TrackLogHelpers::insertTrailUser($data);
            if (Yii::$app->user->identity->role == 'staff') {
                return $this->redirect('/pelanggar');
            }
            return $this->redirect('/dashboard');
        } else {
            $model->password = '';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        $log = Yii::$app->user->identity->username;
    	$data = self::getTrailUserLogout($log);
        $insert = TrackLogHelpers::insertTrailUser($data);
        
        Yii::$app->user->logout();
        
        return $this->goHome();
    }

    public function actionForgotPassword()
    {
        $result = [];
        $this->layout = 'login_layout';

        $model = new UserPasswordForm([
            'scenario' => 'forgot'
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($model->forgot())
            {
                // Yii::$app->session->setFlash('success', 'Silahkan periksa email anda untuk informasi lebbih lanjut.');

                // return $this->render('flash_message');
                $data['type'] = 'mail';
                return $this->render('success_page', ['data' => $data]);
            } else {
                $result = [
                    'type' => 'danger',
                    'message' => 'Maaf, kami tidak dapat mengatur ulang kata sandi untuk alamat email anda. Silahkan coba lagi dalam beberapa menit.',
                ];
            }

            $model->email = null;
        }

        return $this->render('forgot_password', [
            'model' => $model,
            'result' => $result,
        ]);
    }

    public function actionResetPassword($token = null)
    {
        $result = [];
        $this->layout = 'login_layout';
        $redirect = 'Silakan request ulang <u>' . Html::a('disini', Url::to(['site/forgot-password']), ['class' => 'alert-link']) . '</u>';

        if (empty($token) || !is_string($token))
            return $this->render('error_page');
            // throw new NotAcceptableHttpException('Invalid request');

        $model = new UserPasswordForm([
            'scenario' => 'reset'
        ]);

        if (empty($token) || !is_string($token))
        {
            $result = [
                'type' => 'danger',
                'message' => 'Invalid request. ' . $redirect,
            ];

            goto result;
        }
        
        $model->token = $token;

        if (!$model->getUser('token'))
        {
            $result = [
                'type' => 'danger',
                'message' => 'Link request reset password tidak valid. ' . $redirect,
            ];

            goto result;
        }

        if (!$model->isTokenValid())
        {
            $result = [
                'type' => 'danger',
                'message' => 'Link request reset password sudah kadaluarsa. ' . $redirect,
            ];

            goto result;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($model->reset())
            {
                // Yii::$app->session->setFlash('success', 'Sukses, kata sandi anda telah diperbaharui.');
                $data['type'] = 'success';
                return $this->render('success_page', ['data' => $data]);
            } else {
                $result = [
                    'type' => 'danger',
                    'message' => 'Maaf, kami tidak dapat mengatur ulang kata sandi anda. Silahkan coba lagi dalam beberapa menit.',
                ];
            }
        }

        result:
        return $this->render('reset_password', [
            'model' => $model,
            'result' => $result,
        ]);
    }
    
    private static function getTrailUserLogout($username)
    {

        $action = 'Logout';
        $data = [
            'activity' => $action. ' '.$username,
            'old_value' => NULL,
            'new_value' => NULL,
            'action' => $action,
            'model' => Yii::$app->controller->id,
            'model_id' => NULL,
            'url_referer' => Yii::$app->request->url,
        ];

        return $data;
        
    }

    private static function getTrailUser($username)
    {

        $action = 'Login';
        $data = [
            'activity' => $action. ' '.$username,
            'old_value' => NULL,
            'new_value' => NULL,
            'action' => $action,
            'model' => Yii::$app->controller->id,
            'model_id' => NULL,
            'url_referer' => Yii::$app->request->url,
        ];

        return $data;
        
    }

    public function actionLocalization($target, $id, $prompt = null)
    {
        $return = ($prompt != null) ? '<option value="" >' . $prompt . '</option>' : '';

        switch ($target)
        {
            case 'kotakab':
                $data = MasterKotakab::find()->where(['provinsi_id' => $id, 'status' => 1])->all();
                break;

            default:
                $data = [];
                break;
        }

        foreach ($data as $dt)
        {
            $return .= '<option value="' . $dt->id . '">' . $dt->nama . '</option>';
        }

        return $return;
    }
}
