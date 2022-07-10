<?php


use yii\helpers\Html;
use kartik\grid\GridView;
// use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\CommonModel;

use yii\widgets\DetailView;
use app\models\Sector;
use app\models\Job;
use app\models\TargetsResponse;
use kartik\widgets\FileInput;


/* @var $this yii\web\View */
/* @var $model app\models\Targets */

$this->title = Yii::$app->params['target_prefix'].$model->target_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Assigned Targets'), 'url' => 'index.php?r=tcenter/targets'];
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sub Targets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="targets-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <div class="card card-primary border-info">
        <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
        <h5><?= $this->title ?></h5>
        </div>
        <div class="card-body">


    <div class="row">
    <div class="col-md-8">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' =>[
                      // 'id',
                      // 'target_id',
        [
          'attribute'=> 'year',
          'label'=>"Finanace Year",
          'format'=>'html',
          'value'=>function($model){
              return (String)$model->target->year."-".(String)(($model->target->year%100)+1);
          }
      ],
      [
          'label'=>"Target for Scheme",
          'format'=>'html',
          'value'=>function($model){
              return $model->target->scheme->short_name;
          }
          

      ],
                      [
                          'attribute'=>    'center.name',
                          'label'=>"Assigned Center",
                          // 'label'=>"Registered at",
                          'format'=>'html',
                          // 'value'=>Html::a($model->student_name, ['student/view','id'=>$model->id], ['target'=>'_blank','class'=>'text-primary'])
                      ],


                      // [
                      //     'attribute'=>    'status',
                      //     // 'label'=>"Registered at",
                      //     'format'=>'html',
                      //     'value'=>function($model){
                      //       return CommonModel::labelsTargetApprovedstatus($model->status);
                      //     }
                      //
                      // ],
                      [
                          'attribute'=>    'district.name',
                          'label'=>"Target for District",
                          'format'=>'html',
                          // 'value'=>Html::a($model->student_name, ['student/view','id'=>$model->id], ['target'=>'_blank','class'=>'text-primary'])
                      ],
                      [
                          'attribute'=>'response_number',
                          'label'=>"Targets",
                          'format'=>'html',
                          // 'value'=>Html::a($model->student_name, ['student/view','id'=>$model->id], ['target'=>'_blank','class'=>'text-primary'])
                      ],


                      // 'district_id',
                      'job.job_name',
                      [
                        // 'attribute'=>'jobs.job_name',
                        'label'=>"Associate Sub Sector",
                        'format'=>'html',
                        'value'=>function($model){
                          return $model->subSector->sub_sector_name;
                        }
                    ],
                      [
                          'attribute'=>  'updated_at',
                          'label'=>"Assigned at",
                          'format'=>'html',
                          'value'=>date('d F Y',strtotime($model->updated_at)) ." at ".date('h:i:s A',strtotime($model->updated_at))
                      ],

                      [
                          'attribute'=>   'editedBy.username',
                          'label'=>"Assigned by",
                          'format'=>'html',
                          // 'value'=>Html::a($model->student_name, ['student/view','id'=>$model->id], ['target'=>'_blank','class'=>'text-primary'])
                      ],

        ],
    ]) ?>
    </div>
    <div class="col-md-4 text-center">
    <h3 class="text-primary mb-2">LOR</h3>
    <?php
       
        echo '<a class="btn btn-sm btn-warning" href="'.Yii::getAlias('@web/').$model->action_id.'" target="_blank" download>Download</a>';
    // ?>



    </div>
    </div>


</div>




</div>




<div class="row">

</div>
