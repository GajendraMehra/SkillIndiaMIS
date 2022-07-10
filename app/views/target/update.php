<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Targets */


$this->title = Yii::t('app', 'Update Target: {name}', [
    'name' =>  "UK/TR00".$model->id
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Targets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>  "UK/TR00".$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="targets-update">

    <div class="card card-primary border-info">
            <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
            <h5><?= $this->title ?></h5>
            </div>
            <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'model1' => $model1,
                'model2' => $model2,
            ]) ?>
            </div>
    </div>
</div>