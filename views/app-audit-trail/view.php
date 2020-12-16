<?php

use yii\helpers\Html;
use app\components\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\log\AppAuditTrail */

$this->title = $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'App Audit Trails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="app-audit-trail-view">
<?= 
    DetailView::modal([
        'model' => $model,
        'attributes' => [
            'old_value', 'new_value', 'error_desc'
        ]
    ])
     ?>
</div>