<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AccountantData */

$this->title = 'Add New File';
$this->params['breadcrumbs'][] = ['label' => 'Manage Drive', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accountant-data-create">

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
