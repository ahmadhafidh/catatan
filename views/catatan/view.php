<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Users;

/* @var $this yii\web\View */
/* @var $model app\models\MasterProvinsi */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Catatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
$this->registerCss('
    ol.custom-list {
        margin: 0;
        padding-left: 14px;
    }
    ol.custom-list li {
        margin: 5px 0;
        padding-left: 0;
        line-height: 1rem;
    }
');
?>
<div class="catatan-view">

    <p>
        <?= Html::a('< List Catatan', ['index'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nama',
            'nominal',
            'status',
            [
                'label'=>'Teman Dari',
                'attribute' => 'user_id',
                'value' => function($model) {
                    $user = Users::findOne($model->user_id);
                    if($user) {
                        return $user->username;
                    } else {
                        return $model->user_id;
                    }
                }
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary pull-right']) ?>
    <!-- <?= Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Apakah anda yakin untuk menghapus data ini?',
            'method' => 'post',
        ],
    ]) ?> -->

</div>