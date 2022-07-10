<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\CommonModel;
use app\models\BatchTrainingType;
use app\models\BatchStudents;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\IbmResponse;


/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TargetBatch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Batches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="target-batch-index">


  <?= GridView::widget([
  'dataProvider'=> $dataProvider,
  'filterModel' => $searchModel,

  'columns' => [
  [
     'class' => 'yii\grid\SerialColumn',
     'contentOptions' => ['style' => 'width:3%; white-space: normal;'],

  ],

  [
       'attribute'=>  'batch_name',
      //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
  ],


   'sip_id',
   [
      
    //  'contentOptions => ['style' => 'width:10%; white-space: normal;'],
    'label'=>'No of Students',
     'format'=>'html',
     'value'=>function($model){
      return BatchStudents::find()->where(['batch_id'=>$model->id])->count();

     }

    ],
  [
       'attribute'=> 'job_id',
      //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],

       'filterType' => GridView::FILTER_SELECT2,
       'filter' =>   ArrayHelper::map(CommonModel::getTcAlljobs(), 'id', 'job_name'),

       'filterType' => GridView::FILTER_SELECT2,
       'filterWidgetOptions' => [
         'options' => ['prompt' => 'All'],
         'pluginOptions' => [
         'allowClear' => true,
          ]
        ],

       'format'=>'html',
       'value'=>function($model){
         return $model->jobs->job_name;
       }

   ],
  //  [
  //      'attribute'=>'training_type',
  //      'filterType' => GridView::FILTER_SELECT2,
  //      'filter' =>   ArrayHelper::map(BatchTrainingType::find()->all(), 'id', 'type_name'),
  //     //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],

  //      'filterType' => GridView::FILTER_SELECT2,
  //      'filterWidgetOptions' => [
  //        'options' => ['prompt' => 'All'],
  //        'pluginOptions' => [
  //        'allowClear' => true,
  //         ]
  //       ],

  //      'format'=>'html',
  //      'value'=>function($model){
  //        return $model->trainingType->type_name;
  //      }
  //  ],
  //  [
  //      'attribute'=>'min_size',
  //      'contentOptions' => ['style' => 'width:5%; white-space: normal;'],

  //      'label'=>"Batch Size",
  //      'format'=>'html',
  //      'value'=>function($model){
  //        return $model->max_size - $model->min_size;
  //      }
  //  ],


   
  //  [
  //      'attribute'=>'end_time',
  //      // 'label'=>"Batch Time",
  //      'contentOptions' => ['style' => 'width:10%; white-space: normal;'],

  //      'format'=>'html',

  //  ],
  //  [
  //      'attribute'=>'start_time',
  //      'label'=>"Batch Time",
  //     //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],

  //      'format'=>'html',
  //      'value'=>function($model){
  //        return date('h:i A',strtotime($model->start_time)) . " to ".date('h:i A',strtotime($model->end_time));
  //      }
  //  ],
  //  [
  //      'attribute'=>   'assesment_date',
  //      'contentOptions' => ['style' => 'width:5%; white-space: normal;'],

  //      // 'contentOptions' => ['style' => 'width:10%; white-space: normal;'],

  //      'format'=>'html',

  //  ],
   // 'end_time',

   [
       'attribute'=>'final_submit',
       'label'=>"Status",
       'contentOptions' => ['style' => 'width:5%; white-space: normal;'],

       'filterType' => GridView::FILTER_SELECT2,
       'filter' => ['Not Submitted','Submitted'],

       'filterType' => GridView::FILTER_SELECT2,
       'filterWidgetOptions' => [
         'options' => ['prompt' => 'All'],
         'pluginOptions' => [
         'allowClear' => true,
          ]
        ],

       'format'=>'html',
       'value'=>function($model){
         return CommonModel::labelsBatchStatus($model->final_submit);
       }
   ],
   [
    'attribute'=> 'start_date',
     'label'=>"Center  Status",

    'contentOptions' => ['style' => 'width:10%; white-space: normal;'],

    'format'=>'html',
    'value'=>function($model){
     $data=IbmResponse::find()->where(['batch_id'=>$model->id])->orderBy(['id' => SORT_DESC])->one();
     if (!$data) {
       return '<span class="badge badge-danger">Not Sent for Assesment</span>';
       # code...
     }
   return @$data->message;
     //  if (new DateTime(date('Y-m-d')) <=new DateTime($model->end_date)&&new DateTime(date('Y-m-d')) >= new DateTime($model->start_date)) {
     //   return '<span class="badge badge-success"> Running </span>';

     //   }elseif(new DateTime(date('Y-m-d')) < new DateTime($model->start_date)){
     //   return '<span class="badge badge-warning">Upcoming</span>';


     //   }else{
     //     return '<span class="badge badge-danger">Passed</span>';

     //   }
    }

],
  // [
  //      'attribute'=>   'id',
  //      'contentOptions' => ['style' => 'width:5%; white-space: normal;'],

  //      // 'contentOptions' => ['style' => 'width:10%; white-space: normal;'],

  //      'format'=>'html',
  //      'value'=>function($model){
  //      }

  //  ],
   // 'trainer_name',
   // 'created_at',
   // 'updated_at',
   // 'editedBy.username',
              [
                  'class' => 'kartik\grid\ActionColumn',
                  'dropdown' => false,
                  // 'width'=>'30',

                  'vAlign'=>'middle',
                  'template' => '{delete} {view} {update}',
                  'buttons' => [
                    'delete' => function($url, $model){
                        return Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
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
                  'viewOptions'=>['role'=>'modal-local' ,
                  'icon'=>'glyphicon glyphicon-trash',
                  'label' => 'View','class' => 'btn btn-success btn-sm','title'=>'View'],
                  'updateOptions'=>['role'=>'modal-remote',
                  'label' => 'Update','class' => 'btn btn-info btn-sm','title'=>'Update',
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
