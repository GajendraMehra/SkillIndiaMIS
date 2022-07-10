<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\SchemeJobs;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Scheme */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Schemes');
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" crossorigin="anonymous"></script> -->
<div class="scheme-index">

   
    
<!-- <?php Pjax::begin(); ?> -->
    <?= GridView::widget([
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,
   
    'columns' => [
        ['class' => '\kartik\grid\CheckboxColumn'],

     
        [
          'class' => 'yii\grid\SerialColumn',
          'contentOptions' => ['style' => 'width:10px; white-space: normal;'],
         
      ],
      [
        'attribute'=>'short_name',
       // 'contentOptions' => ['style' => 'width:9%; white-space: normal;'],
        //'filter'=>false,
      ], 
      [  'attribute'=>'full_name',],
      [  'attribute'=>'description',],

     
        [
            'class' => 'kartik\grid\ActionColumn',
            'dropdown' => false,
            'width'=>'20',

            'vAlign'=>'middle',
            'template' => ' {view} {summary} ',
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

              'summary' => function($url, $model){
                return Html::a('Summary', ['report/json', 'id' => $model->id], [
                    'class' => 'btn btn-info btn-sm',
                   
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

// Pjax::end(); ?>

</div>
