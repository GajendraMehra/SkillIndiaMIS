<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubSector */

$this->title = 'Create Sub Sector';
$this->params['breadcrumbs'][] = ['label' => 'Sub Sectors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-sector-create">

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
