<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Scheme */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Training Partner');
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" crossorigin="anonymous"></script> -->
<div class="scheme-index">

   
    
<!-- <?php Pjax::begin(); ?> -->
    <?= GridView::widget([
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,
   
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'contentOptions' => ['style' => 'width:10px; white-space: normal;'],
           
        ],
        [  'attribute'=>'tp_name',],
        [  'attribute'=>'tp_sdms_id',],
        [  
        'attribute'=>'is_approved',
        'format' => 'html',
        'filter' => ['Not Approved ','Approved' , 'Pending'],
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
        'options' => ['prompt' => 'All'],
        'pluginOptions' => [
        'allowClear' => true,
        ]
        ],
        'contentOptions' => ['style' => 'width:10%'],
             'value'=> function ($model, $key, $index, $grid){
                 if ($model->is_approved==1) {
                  return '<span class="badge badge-success">Approved   </span>';
                 }
                 else  if ($model->is_approved==2) {
                    return '<span class="badge badge-info">Pending   </span>';
                   }
                 return '<span class="badge badge-danger">Not Approved</span>';

         // return ;
         },
    
    ],
        [  
            'attribute'=>'edited_by',
            'format'=>'html',
            'value'=> function ($model, $key, $index, $grid){
                return  Html::a($model->createdBy->username, ['user/view', 'id' => $model->createdBy->id], [
                    'class'=>'text-primary'
                ]);
           
            },
    
    ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'dropdown' => false,
            'width'=>'20',
            'contentOptions' => ['style' => 'width:20%'],
            'hAlign'=>'middle',
            'template' => ' {view} {summary} ',
            'buttons' => [
              'delete' => function($url, $model){
                  return Html::a('Delete', ['delete', 'id' => $model->id], [
                      'class' => 'btn btn-danger',
                      'data' => [
                          'confirm' => 'Are you absolutely sure ? You will lose all the related information  with this action.',
                          'method' => 'post',
                          'class' => 'danger'
                      ],
                  ]);
              },
              
              'summary' => function($url, $model){
                return Html::a('Summary', ['report/json-tp', 'id' => $model->id], [
                    'class' => 'btn btn-warning btn-sm',
                   
                ]);
            },
            ],
            'urlCreator' => function($action, $model, $key, $index) { 
                    return Url::to([$action,'id'=>$key]);
            },
            'viewOptions'=>['role'=>'modal-local' ,
            'icon'=>'glyphicon glyphicon-trash',
            'label' => 'View','class' => 'btn btn-info ','title'=>'View'],
            'updateOptions'=>['role'=>'modal-remote',
            'label' => '<i class="glyphicon glyphicon-remove"></i>',
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
    //   'before'=>Html::a('<i class="fa fa-plus"></i> Create ', ['create'], ['class' => 'btn btn-success btn-sm']) .'&nbsp&nbsp'.Html::button('<i class="fa fa-trash"></i> Delete Selected ',  ['class' => 'btn btn-danger btn-sm','id'=>'delete-all','data-attrib-name'=>'sales']),
      'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['index'], ['class' => 'btn btn-info btn-sm']),
    ],
   
]);

// Pjax::end(); ?>

</div>
