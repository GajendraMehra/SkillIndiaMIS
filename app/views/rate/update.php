<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rate */

$this->title = Yii::t('app', 'Update Rate: {name}', [
    'name' => $model->rate_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rate_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="rate-update">

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
