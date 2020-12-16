<?php

use yii\helpers\Html;
use app\components\CustomGridView as GridView;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Rules');
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"> 
                <h4 class="card-title">
                </h4>
            </div> 
            <div class="card-content"> 
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="table-responsive">
                        <p>
        <?= Html::a(Yii::t('app', 'Create Rule'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'name',
                        'label' => Yii::t('app', 'Name'),
                    ],
                    ['class' => 'yii\grid\ActionColumn',],
                ],
            ]);
            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
