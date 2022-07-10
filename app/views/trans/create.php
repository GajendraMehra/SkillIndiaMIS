<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TransDetail */

$this->title = 'New Claim';
$this->params['breadcrumbs'][] = ['label' => 'Claim Tranche', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trans-detail-create">

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
