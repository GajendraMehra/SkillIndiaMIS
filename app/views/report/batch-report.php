<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\CommonModel;
use app\models\IbmResponse;
use app\models\BatchTrainingType;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TargetBatch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Summary Report';
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;
?>

<style>
#w0-container 
{
	overflow: auto;
	overflow-x: scroll;
	width: 70vw;
}
</style>
<div class="target-batch-index">


  <?= GridView::widget([
  'dataProvider'=> $dataProvider,
//   'filterModel' => $searchModel,

  'columns' => [
   [
     'class' => 'yii\grid\SerialColumn',
     'contentOptions' => ['style' => 'width:3%; white-space: normal;'],

   ],
   [
    'attribute'=> 'id',
    'label'=> 'State Name',
    'enableSorting' => false,

    'format'=>'html',
    'value'=>function($model){
      return "Uttrakhand";
    }

],
[
    'attribute'=> 'job_id',
    'enableSorting' => false,

    'label'=> 'Sector Name',
    'format'=>'html',
    'filter'=>false,
    'value'=>function($model){
      return $model->jobs->sector[0]->sector_name;
    }

    ],
 
   [
      
    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
    'label'=>'SmartTP ID',
    'filter'=>false,
     'format'=>'html',
     'value'=>function($model){
       return $model->center->parenttp->tp_sdms_id;
     }

 ],
 [
      
    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
    'label'=>'Parent Training Partner',
    'filter'=>false,
     'format'=>'html',
     'value'=>function($model){
       return $model->center->parenttp->tp_name;
     }

 ],
 [
      
    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
    'label'=>'TP Spoc Email',
    'filter'=>false,
     'format'=>'html',
     'value'=>function($model){
       return $model->center->parenttp->tpspoc->email;
     }

 ],  [
      
    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
    'label'=>'TP Spoc Mobile',
    'filter'=>false,
     'format'=>'html',
     'value'=>function($model){
       return $model->center->parenttp->tpspoc->mobile_no;
     }

 ],  [
      
    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
    'label'=>'TP Spoc Name',
    'filter'=>false,
     'format'=>'html',
     'value'=>function($model){
       return $model->center->parenttp->tpspoc->name;
     }

 ], [
      
    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
    'label'=>'TP Address',
    'filter'=>false,
     'format'=>'html',
     'value'=>function($model){
       return $model->center->parenttp->tpaddress->address_line;
     }

 ], 
   [
      
      //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
      'label'=>'Training Center',
      'filter'=>false,
       'format'=>'html',
       'value'=>function($model){
         return $model->center->name;

       }

   ], [
      
      //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
      'label'=>'CentreID',
      'filter'=>false,
       'format'=>'html',
       'value'=>function($model){
         return $model->center->id;

       }

   ], [
      
      //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
      'label'=>'SmartTC ID',
      'filter'=>false,
       'format'=>'html',
       'value'=>function($model){
         return $model->center->smart_tcid;

       }

   ],
   [
      
    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
    'label'=>'TC Spoc Email',
    'filter'=>false,
     'format'=>'html',
     'value'=>function($model){
       return $model->center->tcspoc->email;
     }

 ],  [
      
    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
    'label'=>'TC Spoc Mobile',
    'filter'=>false,
     'format'=>'html',
     'value'=>function($model){
       return $model->center->tcspoc->mobile_no;
     }

 ],  [
      
    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
    'label'=>'TC Spoc Name',
    'filter'=>false,
     'format'=>'html',
     'value'=>function($model){
       return $model->center->tcspoc->name;
     }

 ], [
      
    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
    'label'=>'TC Address',
    'filter'=>false,
     'format'=>'html',
     'value'=>function($model){
       return $model->center->tcaddress->address_line;
     }

 ],
 [
      
    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
    'label'=>'JobRole',
    'filter'=>false,
     'format'=>'html',
     'value'=>function($model){
       return $model->jobs->job_name;
     }

 ],  [
      
    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
    'label'=>'JobRoleCode',
    'filter'=>false,
     'format'=>'html',
     'value'=>function($model){
       return $model->jobs->qp_code;
     }

 ],  [
      
    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
    'label'=>'Category',
    'filter'=>false,
     'format'=>'html',
     'value'=>function($model){
       return $model->jobs->nsqf_level;
     }

 ],  
 [
      
    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
    'label'=>'Total Hour',
    'filter'=>false,
     'format'=>'html',
     'value'=>function($model){
       return $model->jobs->net_hours;
     }

 ],  [
      
    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
    'label'=>'Batch Name',
    'filter'=>false,
     'format'=>'html',
     'value'=>function($model){
       return $model->batch_name;
     }

 ], 
 
   
  
  


   [
       'attribute'=> 'start_date',
        'label'=>"Batch Status",
       'enableSorting' => false,

       'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
       'format'=>'html',
       'value'=>function($model){
         $data=IbmResponse::find()->where(['batch_id'=>$model->id])->orderBy(['id' => SORT_DESC])->one();
          if (!$data) {
            return '<span class="badge badge-danger">Not Sent for Assesment</span>';
            # code...
          }
        return @$data->message;
     
       }

   ],
   [
    'attribute'=>   'start_date',
    'contentOptions' => ['style' => 'width:5%; white-space: normal;'],
    'enableSorting' => false,

    // 'contentOptions' => ['style' => 'width:10%; white-space: normal;'],

    'format'=>'html',
    'value'=>function($model){
        return date('d M yy',strtotime($model->start_date));
      }

],   [
    'attribute'=>   'end_date',
    'contentOptions' => ['style' => 'width:5%; white-space: normal;'],
    'enableSorting' => false,

    // 'contentOptions' => ['style' => 'width:10%; white-space: normal;'],

    'format'=>'html',
    'value'=>function($model){
        return date('d M yy',strtotime($model->end_date));
      }

],
   [
       'attribute'=>'start_time',
       'label'=>"Start Time",
      //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
      'enableSorting' => false,

       'format'=>'html',
       'value'=>function($model){
         return date('h:i A',strtotime($model->start_time));
       }
   ], [
       'attribute'=>'start_time',
       'label'=>"End Time",
       'enableSorting' => false,
      //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
     'filter'=>false,
       'format'=>'html',
       'value'=>function($model){
         return date('h:i A',strtotime($model->end_time));
       }
   ],
   [
       'attribute'=>   'assesment_date',
       'contentOptions' => ['style' => 'width:5%; white-space: normal;'],

       // 'contentOptions' => ['style' => 'width:10%; white-space: normal;'],

       'format'=>'html',

   ],
   // 'end_time',


   // 'trainer_name',
   // 'created_at',
   // 'updated_at',
   // 'editedBy.username',
          
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
<script>
$('#w0-container').width($('.target-batch-index').width())

</script>