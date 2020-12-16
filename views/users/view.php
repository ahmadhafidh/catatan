<?php

// use yii\helpers\Html;
use yii\helpers\Url;
// use yii\widgets\DetailView;
// use app\components\DetailView;

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Transaksi */

// $this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="users-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
        [
            'label'=>'Nama User',
            'attribute'=>'username'
        ],
            'email:email',
            'role',
        [
            'label'=>'kejaksaan name',
            'attribute'=>'kejaksaan.name',
        ],
        [   'attribute' => 'status',
            'value'=> function($data){
                return $data->status == 1 ? 'activate' : 'inactivate';
            }
        ]
        ],
    ]) ?>

    <?= Html::a('Kembali ke Halaman List User', ['users/index'], ['class' => 'btn btn-primary']) ?>


</div>
