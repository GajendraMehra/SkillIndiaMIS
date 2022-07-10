<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\CommonModel;
use app\models\IbmResponse;
use app\models\BatchTrainingType;
use app\models\BatchStudents;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\TpartnerDetail;
use app\models\Tcdetail;


/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TargetBatch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Target Batches';
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
      'format'=>'html',
      'value'=>function($model){
       return   Html::a($model->batch_name, ['view','id'=>$model->id], ['target'=>'_blank','class'=>'text-primary']);
 
      }
      
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

   // 'trainingType.type_name',

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

   ],[  
    'contentOptions' => ['style' => 'width:30%; white-space: normal;'],
      
      //  'contentOptions => ['style' => 'width:10%; white-space: normal;'],
      'attribute'=> 'tc_id',
      'label'=>'Training Center',
      'filter' => ArrayHelper::map(Tcdetail::find()->all(), 'id', function($model){
        return $model->name .$model->smart_tcid ;
      }),
      'filterType' => GridView::FILTER_SELECT2,
      'filterWidgetOptions' => [
        'options' => ['prompt' => 'All',
        ],
        'pluginOptions' => [
        'allowClear' => true,
        'format'=>'html',
        'multiple' => false

        ]
        ],
       'format'=>'html',
       'value'=>function($model){
        return '<input type="hidden" name="centerid" value="'.$model->center->id.'"><a style="cursor:pointer" class="text-primary see-detail" data-id="2" href="javascript:void(0);">'.$model->center->name.'</a>';

       }

   ],[
      
       'contentOptions' => ['style' => 'width:30%; white-space: normal;'],
      'label'=>'Parent Training Partner',
      'filter' => ArrayHelper::map(TpartnerDetail::find()->all(), 'id', function($model){
        return $model->tp_name ." - ".$model->tp_sdms_id;
      }),
      'filterType' => GridView::FILTER_SELECT2,
      'filterWidgetOptions' => [
        'options' => ['prompt' => 'All',
        ],
        'pluginOptions' => [
        'allowClear' => true,
        'format'=>'html',
        'multiple' => false

        ]
        ],
      'attribute'=>'tp_id',
       'format'=>'html',
       'value'=>function($model){
         return $model->center->parenttp->tp_name;
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
  //      'attribute'=> 'start_date',
  //       'label'=>"Batch Status",
  //      'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
  //      'format'=>'html',
  //      'value'=>function($model){
  //        $data=IbmResponse::find()->where(['batch_id'=>$model->id])->orderBy(['id' => SORT_DESC])->one();
  //         if (!$data) {
  //           if ($model->final_submit==2) {
  //             return '<span class="badge badge-primary">Data Sent for Assesment</span>';

  //           }else{
  //             return '<span class="badge badge-danger">Not Sent for Assesment</span>';

  //           }
  //           # code...
  //         }
  //       return @$data->message;
  //       //  if (new DateTime(date('Y-m-d')) <=new DateTime($model->end_date)&&new DateTime(date('Y-m-d')) >= new DateTime($model->start_date)) {
  //       //   return '<span class="badge badge-success"> Running </span>';

  //       //   }elseif(new DateTime(date('Y-m-d')) < new DateTime($model->start_date)){
  //       //   return '<span class="badge badge-warning">Upcoming</span>';


  //       //   }else{
  //       //     return '<span class="badge badge-danger">Completed</span>';

  //       //   }
  //      }

  //  ],
  //  [
  //      'attribute'=>'end_time',
  //      // 'label'=>"Batch Time",
  //      'contentOptions' => ['style' => 'width:10%; white-space: normal;'],

  //      'format'=>'html',

  //  ],
   [
       'attribute'=>'start_time',
       'label'=>"Batch Time",
      //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],

       'format'=>'html',
       'value'=>function($model){
         return date('h:i A',strtotime($model->start_time)) . " to ".date('h:i A',strtotime($model->end_time));
       }
   ],
  //  [
  //      'attribute'=>   'assesment_date',
  //      'contentOptions' => ['style' => 'width:5%; white-space: normal;'],

  //      // 'contentOptions' => ['style' => 'width:10%; white-space: normal;'],

  //      'format'=>'html',

  //  ],
   // 'end_time',


   // 'trainer_name',
   // 'created_at',
   // 'updated_at',
   // 'editedBy.username',
              [
                  'class' => 'kartik\grid\ActionColumn',
                  'dropdown' => false,
                  // 'width'=>'30',

                  'vAlign'=>'middle',
                  'template' => ' {update} {summary}',
                  'buttons' => [
                    'delete' => function($url, $model){
                        return Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you absolutely sure ?You will lose all the related information  with this action.',
                                'method' => 'post',
                                'class' => 'danger'
                            ],
                        ]);
                    },
                    'summary' => function($url, $model){
                      return Html::a('Summary', ['report/json-tp', 
                      'id' => $model->center->parenttp->id], [
                          'class' => 'btn btn-warning mt-1 btn-sm',
                         
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
    // 'before'=>Html::a('<i class="fa fa-plus"></i> Create ', ['create'], ['class' => 'btn btn-success btn-sm']) .'&nbsp&nbsp',
    'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['index'], ['class' => 'btn btn-info btn-sm']),
  ],

]);

?>


</div>

<!-- modal Start -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Training Center Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body ">

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Send message</button> -->
    </div>
  </div>
  </div>    
</div>
<!-- modal End -->
<script>

$('.see-detail').on('click',function(){
   
   $('.bd-example-modal-lg').modal({show:true});
   var id = $(this).parent().parent().attr('data-key');
   console.log(id);
   $('.modal-body').text('Loading...')

   $('.modal-body').load('index.php?r=target%2Fcenter-view-by-id&id='+id,function(){
   });
});
</script>