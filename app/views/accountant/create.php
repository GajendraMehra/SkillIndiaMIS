<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Add New Accountant';
$this->params['breadcrumbs'][] = ['label' => 'Accountants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create">
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
