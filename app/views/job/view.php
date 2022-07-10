<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Job */

$this->title = $model->job_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Jobs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="job-view">

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
                    'job_name',
                    [
                        'attribute'=>'subSector.sub_sector_name',
                        'label'=>"Related Sub Sector",
                        'format'=>'html',
                        // 'value'=>date('d F Y',strtotime($model->created_at)) ." at ".date('h:i:s A',strtotime($model->created_at))
                    ], [
                        'attribute'=>'sector',
                        'label'=>"Related Sector",
                        'format'=>'html',
                        'value'=>function($model){
                           return $model->sector[0]->sector_name;
                        }
                    ],
                    // '',
                    // 'sector_id',
                    'qp_code',
                    'nsqf_level',
                    'qualification',
                    'theory_hour',
                    'practical_hour',
                    'softskill_hour',
                    'not_payable',
                    'net_hours',
                    [
                        'attribute'=>'created_at',
                        // 'label'=>"Assigned Training Partner",
                        'format'=>'html',
                        'value'=>date('d F Y',strtotime($model->created_at)) ." at ".date('h:i:s A',strtotime($model->created_at))
                    ],
                    [
                        'attribute'=>  'updated_at',
                        // 'label'=>"Assigned Training Partner",
                        'format'=>'html',
                        'value'=>date('d F Y',strtotime($model->updated_at)) ." at ".date('h:i:s A',strtotime($model->updated_at))
                    ],
                    [
                        'attribute'=>  'editedBy.username',
                        'label'=>"Created By",
                        'format'=>'html',
                        // 'value'=>
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
