<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\DetailView;

$this->title = 'My Profile';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'group' => 'user_information',
            'items' => [
                // 'id',
                'username',
                'email:email',
                'kejaksaan_id+name:kejaksaan',
                // 'auth_key',
                'role',
                // 'status',
                // 'verification_token',
                // 'password_reset_token',
                // 'created_date',
                // 'created_by',
                // 'created_by_name',
                // 'updated_date',
                // 'updated_by',
                // 'updated_by_name',
                // 'login_failed',
                // 'last_login_attempt',
                // 'penalty_time',
            ],
        ],
    ],
]) ?>
