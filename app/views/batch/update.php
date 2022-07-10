<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TargetBatch */

$this->title = 'Update Target Batch: ' . $model->batch_name;
$this->params['breadcrumbs'][] = ['label' => 'Target Batches', 'url' => ['index','type'=>3]];

$this->params['breadcrumbs'][] = ['label' => $model->batch_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="target-batch-update">
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
