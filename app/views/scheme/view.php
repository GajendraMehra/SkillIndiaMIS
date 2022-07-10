<?php
use kartik\grid\GridView;

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Job;
/* @var $this yii\web\View */
/* @var $model app\models\Scheme */

$this->title = $model->short_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Schemes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
// print_r($model1);
?>
<div class="scheme-view">
    <div class="col-md-12">
    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
<div class="card card-primary border-info">

    <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
        <h5><?= $this->title ?></h5>
        </div>
        <div class="card-body">
    <p>
        <?= Html::a(Yii::t('app', '<i class="fa fa-pencil"></i>&nbsp&nbspUpdate'), ['update', 'id' => $model->id], ['class' => 'btn btn-outline-info']) ?>
        <?= Html::a(Yii::t('app', '<i class="fa fa-trash"></i>&nbsp&nbspDelete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-outline-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
                // 'type'=>'danger'
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'short_name:ntext',
            'full_name',
            'description',
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
                'value'=>date('d F Y',strtotime($model->created_at)) ." at ".date('h:i:s A',strtotime($model->created_at))
            ],
           
            [
                'attribute'=>'edited_by',
                'attribute'=>'Created By',
                'format'=>'html',
                'value'=>function($model){
                    // echo "<pre>";
                    return $model->editedBy->username;
                    if ($model->edited_by==1) {
                        return '<span class="badge badge-success">Approved   </span>';
                       }
                       else  if ($model->edited_by==2) {
                          return '<span class="badge badge-info">Pending </span>';
                         }
                       return '<span class="badge badge-danger">Not Approved</span>';
                }
            ]
        ],
    ]) ;
// echo "<pre>";
// print_r($model1);
// die;
?>
  
   </div>
    </div>
    </div>
</div>
