<?php
use yii\helpers\Html;
use kartik\grid\GridView;
// use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\Sector;
use app\models\CommonModel;
use app\models\TargetsResponse;
use kartik\widgets\FileInput;


/* @var $this yii\web\View */
/* @var $model app\models\Targets */

$this->title = Yii::$app->params['target_prefix'].$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Targets'), 'url' => ['index','filter'=>'all']];
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
    <p>
        <!-- <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> -->
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?> 
         <?php
         if ($model->status==1) {
           echo   Html::a(Yii::t('app', 'Mark as Closed'), ['target-close', 'id' => $model->id], [
            'class' => 'btn btn-info',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to close this target. By closing the target users will not able to create the batches  ?'),
                'method' => 'post',
            ],
        ]);
         }
        ?>
    </p>

    <div class="row">
    <div class="col-md-8">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',

            [
                'attribute'=> 'year',
                'format'=>'html',
                'value'=>function($model){
                    return (String)$model->year."-".(String)(($model->year%100)+1);
                }
            ],
            [
                'attribute'=> 'scheme.full_name',
                'label'=>"Target for Scheme",
                'format'=>'html',
                // 'value'=>function($model){
                //     return Sector::findOne($model->sector->sector_id)->sector_name;
                // }
                // return

            ],
           

            // 'scheme.short_name',
            [
                'attribute'=>'tp.tp_name',
                'label'=>"Assigned Training Partner",
                'format'=>'html',
                // 'value'=>TpartnerDetail::findOne($model->tp_id)['tp_name']
            ],
          
           
            [
                'attribute'=>'number',
                'label'=>"Total Targets ",
                'format'=>'html',
                'value'=>function($model){
                    return '<span class="total_targets">'.$model->number.'</span>';
                }
            ], 
            [
                'attribute'=>'status',
                'format'=>'html',
                'value'=>function($model){
                    return CommonModel::labelsStatus($model->status);
                  },
            ],
            [
                'attribute'=>'id',
                'label'=>"TP Response",
                'format'=>'html',
                'value'=>function($model){
                    return (TargetsResponse::find()->where(['target_id'=>$model->id])->all())? Html::a('View Response', ['/target/view-response','id'=>$model->id], ['class'=>'btn btn-sm btn-success']) :"No Response ";
                }
            ],




        ],
    ]) ?>
    </div>
    <div class="col-md-4 text-center">
    <h3 class="text-primary mb-2">Workorder</h3>
    <h5 class="mt-2 mb-2">  
    <?=  Html::a(Yii::t('app', 'Download'), 'index.php?r=site/getfile&name='.$model->work_order_file, ['class' => 'btn btn-primary']);  ?>

    </div>
    </div>
    <div class="row">

    <div class="col-md-6">
    <?= GridView::widget([
    'dataProvider'=> $dataProvider,

    'columns' => [

        [
            'attribute'=>  'cities.name',
          'label' => false


        ],
    ],
    'panel' => [
      'type'=> Yii::$app->config->get('panel-theme','primary'),
        'heading'=>'<h5>'.Html::encode(mb_strtoupper("Targets for Districts ")).'</h5>',

      ],
      'toolbar' => []


]);
?>
    </div>
    <div class="col-md-6">
    <?= GridView::widget([
    'dataProvider'=> $dataProvider1,

    'columns' => [

        [
            'attribute'=>  'jobs.job_name',
          'label' => false


        ],
    ],
    'panel' => [
      'type'=> Yii::$app->config->get('panel-theme','primary'),
        'heading'=>'<h5>'.Html::encode(mb_strtoupper("Associated Jobs  ")).'</h5>',

      ],
      'toolbar' => [],



]);
?>
    </div>

    </div>


</div>
</div>
</div>
