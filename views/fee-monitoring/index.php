<?php

use yii\helpers\Html;
use app\components\CustomForm as ActiveForm;
use app\components\CustomGridView as GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FeeMonitoringSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fee Monitoring';
$this->params['breadcrumbs'][] = $this->title;
$exportUrl = '?export=xlsx';
?>
<div class="transaksi-index">
<?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-3">
            <?= $form->field($searchModel, 'start_date')->dateInput() ?>
        </div>
        <div class="col-3">
            <?= $form->field($searchModel, 'end_date')->dateInput() ?>
        </div>
        <div class="col-3">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="col-3">
            <div class="pull-right">
                <?= Html::a('<i class="fa fa-download"></i> '.Yii::t('app', 'Download List'), $exportUrl, ['class' => 'btn btn-block btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
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

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'header' => 'Action',
                'headerOptions' => ['style' => 'width: 8%;text-align:center;color: #337ab7'],
                'contentOptions' => ['style' => 'text-align:center;'],
                'buttons' => [
                    'view' =>  function($url, $model) {
                        $queryParams = array();
                        parse_str($_SERVER['QUERY_STRING'], $queryParams);
                        $start_date = isset($queryParams['FeeMonitoringSearch']['start_date']) ? $queryParams['FeeMonitoringSearch']['start_date'] : '';
                        $end_date = isset($queryParams['FeeMonitoringSearch']['end_date']) ? $queryParams['FeeMonitoringSearch']['end_date'] : '';
                        return Html::a('<i class="fa fa-eye"></i>', $url."&bulan=".$model->bulan.
                        "&start_date=".$start_date.
                        "&end_date=".$end_date, [
                            'title' => 'View',
                            'data-pjax' => '0',
                            'class' => 'btn btn-primary btn-sm',
                        ]) . "&nbsp;";
                    }
                ],
            ],
        ],
    ]); ?>


</div>
