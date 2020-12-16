<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\UserPasswordForm;
use app\models\Users;

class ProfileController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Transaksi models.
     * @return mixed
     */
    public function actionIndex($export = null)
    {
        $model = Users::findOne([
            'id' => Yii::$app->user->identity->id
        ]);

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionChangePassword()
    {
        $result = [];
        $model = new UserPasswordForm([
            'scenario' => 'change'
        ]);
        $model->email = Yii::$app->user->identity->email;

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if ($model->change())
            {
                $result = [
                    'type' => 'success',
                    'message' => 'Sukses, password telah diganti. Silakan logout dan login kembali dengan password baru'
                ];
            } else {
                $result = [
                    'type' => 'danger',
                    'message' => 'Gagal, password tidak berhasil diubah.'
                ];
            }
        }

        return $this->render('change_password', [
            'model' => $model,
            'result' => $result,
        ]);
    }
}
