<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TargetBatch */

$this->title = 'Create  Batch';
$this->params['breadcrumbs'][] = ['label' => 'All Batches', 'url' => ['index','type'=>3]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="target-batch-create">

      <div class="card card-primary border-info">
          <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
          <h5><?= $this->title ?></h5>
          </div>
          <div class="card-body">
          <?= $this->render('_form', [
              'model' => $model,
              'tc'=>$tc
          ]) ?>
          </div>
      </div>

</div>
