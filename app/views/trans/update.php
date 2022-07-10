<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TransDetail */

$this->title = 'Update Trans Detail: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trans Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trans-detail-update">

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
