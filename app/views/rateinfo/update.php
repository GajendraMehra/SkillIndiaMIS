<?php

use yii\helpers\Html;
use app\models\Rate;

/* @var $this yii\web\View */
/* @var $model app\models\RateInfo */

$this->title = Yii::t('app', 'Update Rate Amount: {name}', [
    'name' => $model->rate->rate_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rates'), 'url' => ['/rate/index']];

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->rate->rate_name), 'url' => ['/rate/view','id'=>$model->rate->id]];

$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="rate-info-update">
    <div class="card card-primary border-info">
        <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
        <h5><?= $this->title ?></h5>
        </div>
        <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
           
        ]) ?>
        </div>
    </div>
</div>
