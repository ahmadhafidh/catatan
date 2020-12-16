<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FeeMonitoringSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaksi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'no_tilang') ?>

    <?= $form->field($model, 'nomor_transaksi') ?>

    <?= $form->field($model, 'tgl_sidang') ?>

    <?= $form->field($model, 'nama') ?>

    <?php // echo $form->field($model, 'kejaksaan_id') ?>

    <?php // echo $form->field($model, 'kendaraan') ?>

    <?php // echo $form->field($model, 'fee_spe') ?>

    <?php // echo $form->field($model, 'fee_bni') ?>

    <?php // echo $form->field($model, 'fee_total') ?>

    <?php // echo $form->field($model, 'denda') ?>

    <?php // echo $form->field($model, 'biaya_admin') ?>

    <?php // echo $form->field($model, 'biaya_total') ?>

    <?php // echo $form->field($model, 'jml_titipan') ?>

    <?php // echo $form->field($model, 'jml_pengembalian') ?>

    <?php // echo $form->field($model, 'no_va') ?>

    <?php // echo $form->field($model, 'va_expired_date') ?>

    <?php // echo $form->field($model, 'payment_date') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'latitude') ?>

    <?php // echo $form->field($model, 'longitude') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_date') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
