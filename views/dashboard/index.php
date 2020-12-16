<?php  
use yii\helpers\Html;
use app\components\CustomForm as ActiveForm;
use app\assets\ChartAsset;
use yii\helpers\Url;

$this->title = 'Dashboard';
?>

<div class="row">
	<div class="col-md-3">

	<?php
		date_default_timezone_set("Asia/Jakarta");
		$time = explode(':', date('H:i'));
		$hour = (int) $time[0];
		$mins = (int) $time[1];
		$greet = 'Malam';

		if($hour >= 4 && $hour <= 9) // 04.00 - 09.59
		{
			$greet = 'Pagi';
		}
		elseif($hour >= 10 && $hour <= 13) // 10.00 - 13.59
		{
			$greet = 'Siang';
		}
		elseif($hour >= 14 && $hour <= 18) // 14.00 - 18.29
		{
			$greet = 'Sore';
			if($hour == 18 && $mins > 29) // 18.30 - 03.59
			{
				$greet = 'Malam';
			}
		}
		echo "<h2><b>Selamat $greet</b></h2>";

	?>
	</div>
	<div class="col-md-9">
		<?php $form = ActiveForm::begin([
			'action' => ['dashboard/index'],
			'method' => 'get',
		]); ?>
		<?php ActiveForm::end(); ?>
	</div>
</div>

<!--Statistics cards Starts-->
<div class="row" id="sidebar-render"></div>
<!--Statistics cards Ends-->

<!--Line with Area Chart 2 Starts-->
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-content">
				<div class="card-body pt-5">
					<!-- <div id="line-area2" class="height-350 lineArea2"> -->
					<!-- </div> -->
					<center>
						<img src="<?= Url::to('@web/img/admindashboard.png')?>">
					</center>
					<br>
					<center>
						<h4 class="card-title">Welcome Dashboard</h4>
					</center>

				</div>
			</div>
		</div>
	</div>
</div>
<!--Line with Area Chart 2 Ends-->

<?php ChartAsset::register($this); ?>