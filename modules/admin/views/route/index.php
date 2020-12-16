<?php
use app\assets\RBACAnimate;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\YiiAsset;

$this->title = Yii::t('app', 'Routes');
// $this->params['breadcrumbs'][] = $this->title;

RBACAnimate::register($this);
YiiAsset::register($this);
$opts = Json::htmlEncode([
    'routes' => $routes,
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="spinner-border spinner-border-sm"></i>';

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
                <div class="table-responsive">
                    <div class="tabbable-line boxless tabbable-reversed portlet light">
                 
                        <div class="input-group">
                            <input id="inp-route" type="text" class="form-control" placeholder="<?=Yii::t('app', 'New route(s)');?>">

                            <span class="input-group-btn">
                                <?=Html::a(Yii::t('app', 'Add') . $animateIcon, ['create'], [
                                    'class' => 'btn btn-success',
                                    'id' => 'btn-new',
                                ]);?>
                            </span>
                        </div>

                        <div class="tab-content">
                             <div class="row">
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input class="form-control search" data-target="available" placeholder="<?=Yii::t('app', 'Search for available');?>">
                                        <span class="input-group-btn">
                                            <?=Html::a('<span class="fa fa-refresh"></span>', ['refresh'], [
                                                'class' => 'btn btn-default',
                                                'id' => 'btn-refresh',
                                            ]);?>
                                        </span>
                                    </div>
                                    <select multiple size="20" class="form-control list" style="height:300px" data-target="available"></select>
                                </div>
                                <div class="col-sm-2 text-center" style="margin-bottom:40px">
                                    <br><br>
                                    <?=Html::a('&gt;&gt;' . $animateIcon, ['assign'], [
                                        'class' => 'btn btn-success btn-assign',
                                        'data-target' => 'available',
                                        'title' => Yii::t('app', 'Assign'),
                                    ]);?><br><br>
                                    <?=Html::a('&lt;&lt;' . $animateIcon, ['remove'], [
                                        'class' => 'btn btn-danger btn-assign',
                                        'data-target' => 'assigned',
                                        'title' => Yii::t('app', 'Remove'),
                                    ]);?>
                                </div>
                                <div class="col-sm-5">
                                    <input class="form-control search" data-target="assigned" placeholder="<?=Yii::t('app', 'Search for assigned');?>">
                                    <select multiple size="20" class="form-control list" style="height:300px" data-target="assigned"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div> 
    </div>
</div>


