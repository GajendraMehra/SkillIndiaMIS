<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\SubSector;
use app\models\Sector;
use app\models\TargetBatch;
use yii\helpers\ArrayHelper;

// use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Job */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app',  'Student Placements');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
#w0-container {
	overflow: auto;
	overflow-x: scroll;
	width: 980px;
}
</style>
<div class="job-index">

   

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,
   
    'columns' => [
        ['class' => '\kartik\grid\CheckboxColumn'],


        [
            'attribute'=>    'batch_id',
            'label'=>"Batch Name",
            'format'=>'html',
            'filter' =>   ArrayHelper::map(TargetBatch::find()->where(['tc_id'=>$tc['id']])->all(), 'id', 'batch_name'),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
            'options' => ['prompt' => 'All'],
            'pluginOptions' => [
            'allowClear' => true,
            'format'=>'html',
           
            ]
            ],
            'value'=>function($model){
               return $model->batch->batch_name;
            }
        ],
         
        [
            'attribute'=>    'student_id',
            'label'=>"Student Name",
            'format'=>'html',
            'filter' => false,
            // 'filterType' => GridView::FILTER_SELECT2,
            // 'filterWidgetOptions' => [
            // 'options' => ['prompt' => 'All'],
            // 'pluginOptions' => [
            // 'allowClear' => true,
            // 'format'=>'html',
           
            // ]
            // ],
            'value'=>function($model){
               return $model->student->student_name;
            }
        ], 
        [
            'attribute'=>    'batch_id',
            'label'=>"SIP ID",
            'format'=>'html',
            // 'filter' => ArrayHelper::map(Sector::find()->all(), 'nsdc_sector_id', 'sector_name'),
            // 'filterType' => GridView::FILTER_SELECT2,
            // 'filterWidgetOptions' => [
            // 'options' => ['prompt' => 'All'],
            // 'pluginOptions' => [
            // 'allowClear' => true,
            // 'format'=>'html',
           
            // ]
            // ],
            'value'=>function($model){
               return $model->student->sip_id;
            }
        ],
         
  [
                'attribute'=>  'placed_organisation',
                
                'format'=>'html',
             
                'value'=>function($model){
                   return $model->placed_organisation;
                }
            ],
            [
                'attribute'=> 'package_pm',
                'format'=>'html',
                'value'=>function($model){
                   return '&#8377; '.$model->package_pm;
                }
            ],
            [
              'class' => 'kartik\grid\ActionColumn',
              'dropdown' => false,
              // 'width'=>'20',
              // 'contentOptions' => ['style' => 'width:20%'],
              'hAlign'=>'middle',
              'template' => ' {view}',
              'buttons' => [
                'delete' => function($url, $model){
                    return Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-danger',
                        'data' => [
                            'confirm' => 'Are you absolutely sure ? You will lose all the related information  with this action.',
                            'method' => 'post',
                            'class' => 'danger'
                        ],
                    ]);
                },
                
              ],
              'urlCreator' => function($action, $model, $key, $index) { 
                      return Url::to([$action,'id'=>$key]);
              },
              'viewOptions'=>['role'=>'modal-local',
              'icon'=>'glyphicon glyphicon-trash',
              'label' => 'Upload Appointment','class' => 'btn btn-sm btn-success ','title'=>'View'],
              'updateOptions'=>['role'=>'modal-remote',
              'label' => 'Update',
              'class' => 'btn btn-sm btn-info ',
              'icon'=>'fa fa-trash',
              'title'=>'Update', 'data-toggle'=>'tooltip'],
            ],
     
    ],
    'toolbar' => [
       
        '{export}',
        '{toggleData}'
    ],
    'toggleDataContainer' => ['class' => 'btn-group-sm'],
    'exportContainer' => ['class' => 'btn-group-sm'],
    'panel' => [
    'type'=> Yii::$app->config->get('panel-theme','primary'),
      'heading'=>'<h5>'.Html::encode(mb_strtoupper($this->title)).'</h5>',
      'before'=>Html::a('<i class="fa fa-plus"></i> Create ', ['create'], ['class' => 'btn btn-success btn-sm']) .'&nbsp&nbsp',
      'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['index'], ['class' => 'btn btn-info btn-sm']),
    ],
   
]);
?>

</div>
<script>
$('#w0-container').width($('.job-index').width())

</script>