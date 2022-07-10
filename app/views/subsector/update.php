<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubSector */

$this->title = 'Update Sub Sector: ' . $model->sub_sector_name;
$this->params['breadcrumbs'][] = ['label' => 'Sub Sectors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sub_sector_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sub-sector-update">
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
