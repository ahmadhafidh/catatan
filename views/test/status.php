<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TechnicalDocuments */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Bulk Upload Pelanggar';
?>

<div class="row">
	<div class="col-md-8 bulk-upload">
		<div class="col-md-12 form-group-tap">
		    <br>
		    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>	  

			<ul class="list-number">

				<li class="step-done">
					<h3 class="upload-text">Upload File &nbsp;<a class="upl-sm-text" href="/files/template/template_tilang.xlsx">Download Template</a></h3> 
					
					<div class="row">
						
						<div class="col-md-9">
							<br>
							<div class="input-group">
								<?= $form->field($model, 'file_data', 
									['labelOptions' => [ 'class' => 'custom-file-label', 'style' => 'text-transform: none !important; opacity: 0.7;' ]])
									->fileInput(['id' => 'file_data', 'class' => 'custom-file-input'])->label('Hanya support file dengan format .xlsx') ?>
							</div>
						</div>
						<div>
							<br>
							<?= Html::submitButton('Upload File', ['class' => 'btn btn-primary']) ?>
						</div>
					</div>
					<br>
				</li>
				<li class="step-end">
					<h3 class="upload-text">Status Upload</h3>
					<div class="row">
						<div class="col-md-4">
							<div class="card bulk-status-box">
								<div>
									<p style="color: green">Berhasil Upload</p>
									<p style="font-weight: bold">10000</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card bulk-status-box">
								<div>
									<p style="color: red">Gagal Upload</p>
									<p style="font-weight: bold">100</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card bulk-status-box">
								<div>
									<p style="color: black">Total Data</p>
									<p style="font-weight: bold">10000</p>
								</div>
							</div>
						</div>

					</div>
					<br>
				</li>
			</ul>

			<div class="row">
				<div class="col-md-6 btn-bulk-trx">
					<?= Html::a('Lihat Transaksi', '/transaksi', ['class'=>'btn btn-large-white']) ?>
				</div>
			</div>
			
		    <?php ActiveForm::end(); ?>
		</div>
	</div>
	<div class="col-md-4 card" style="height: -webkit-fill-available">
		<br>
		<h5 class="upload-text">Log Gagal Upload</h5>
	</div>
</div>