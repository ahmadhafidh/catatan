<?php

use yii\helpers\Html;
use app\components\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\log\AppAuditTrail */

$this->title = $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Yii Log', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="yii-log-view">
<?= 
    DetailView::modal([
        'model' => $model,
        'attributes' => [
            'message'
        ]
    ])
     ?>
</div>