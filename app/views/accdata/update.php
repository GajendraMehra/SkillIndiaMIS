<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccountantData */

$this->title = 'Update Accountant Data: ' . $model->file_title;
$this->params['breadcrumbs'][] = ['label' => 'Accountant Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->file_title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="accountant-data-update">
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
