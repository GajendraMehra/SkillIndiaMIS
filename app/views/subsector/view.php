<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SubSector */

$this->title = $model->sub_sector_name;
$this->params['breadcrumbs'][] = ['label' => 'Sub Sectors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sub-sector-view">
  <div class="card card-primary border-info">
      <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
      <h5><?= $this->title ?></h5>
      </div>
      <div class="card-body">
      <p class="">
          <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
          <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
              'class' => 'btn btn-danger',
              'data' => [
                  'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                  'method' => 'post',
              ],
          ]) ?>
      </p>

      <?= DetailView::widget([
          'model' => $model,
          'attributes' => [
            'id',
            'sub_sector_name:ntext',
            [
                'attribute'=>'sector.sector_name',
                'label'=>"Parent Sector",
                'format'=>'html',
                // 'value'=>date('d F Y',strtotime($model->created_at)) ." at ".date('h:i:s A',strtotime($model->created_at))
            ],
            'nsdc_sub_sector_id',
          ],
      ]) ?>
      </div>
  </div>



</div>
