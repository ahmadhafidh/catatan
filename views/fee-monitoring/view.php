<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\components\CustomForm as ActiveForm;
use app\components\CustomGridView as GridView;
use app\models\MasterKejaksaan;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FeeMonitoringSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$queryKejaksaan = MasterKejaksaan::find()->where(['status' => '1'])->asArray()->all();
$this->title = 'List Fee Monitoring Detail';
$this->params['breadcrumbs'][] = $this->title;
$exportUrl = '?bulan='.$bulan.'&export=xlsx'.'&start_date='.$start_date.'&end_date='.$end_date;
?>
<div class="transaksi-index">
    <div class="row" id="sidebar-render">
        <div class="col-xl-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body pt-2 pb-2">
                        <div class="media">
                            <div class="media-body text-left">
                                <span>Fee BNI</span>
                                <h3 class="font-large-1 mb-0">Rp<?= number_format($total[0]['fee_bni'], 2) ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body pt-2 pb-2">
                        <div class="media">
                            <div class="media-body text-left">
                                <span>Fee SPE</span>
                                <h3 class="font-large-1 mb-0">Rp<?= number_format($total[0]['fee_spe'], 2) ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-xl-6" style="margin: auto;">
                <div class="pull-right">
                    <?= Html::a('<i class="fa fa-download"></i> '.Yii::t('app', 'Download List'), $exportUrl, ['class' => 'btn btn-block btn-success']) ?>
                </div>
            </div>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'No'
            ],
            [
                'label'=>'Bulan',
                'filter' => false,
                "filterInputOptions" => ['class' => "form-control pickadate",],
                'attribute' => 'created_date',
                'value' => function ($data) {
                    return $data->bulan;
                }
            ],
            [
                'attribute' => 'kejaksaan_id',
                'filter' => Html::activeDropDownList($searchModel, 'kejaksaan_id', ArrayHelper::map($queryKejaksaan,'id','name'),['class'=>'form-control select2Cad','data-plugin' => 'select2','prompt' => 'Kejaksaan']),
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->name;
                }
            ],
            [
                'header'=>'Nomor Tilang',
                'attribute'=>'no_tilang'
            ],
            [
                'header' => 'Fee BNI',
                'attribute' => 'fee_bni',
                'filter' => false,
                'value' => function ($data) {
                    return 'Rp'.number_format($data->fee_bni, 2);
                }
            ],
            [
                'header' => 'Fee SPE',
                'attribute' => 'fee_spe',
                'filter' => false,
                'value' => function ($data) {
                    return 'Rp'.number_format($data->fee_spe, 2);
                }
            ],
            [
                'header' => 'Fee Total',
                'attribute' => 'fee_total',
                'filter' => false,
                'value' => function ($data) {
                    return 'Rp'.number_format($data->fee_total, 2);
                }
            ],
            //'kejaksaan_id',
            //'kendaraan',
            //'fee_spe',
            //'fee_bni',
            //'fee_total',
            //'denda',
            //'biaya_admin',
            //'biaya_total',
            //'jml_titipan',
            //'jml_pengembalian',
            //'no_va',
            //'va_expired_date',
            //'payment_date',
            //'status',
            //'latitude',
            //'longitude',
            //'created_date',
            //'created_by',
            //'updated_date',
            //'updated_by',
        ],
    ]); ?>
</div>
