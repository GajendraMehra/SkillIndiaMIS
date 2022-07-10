<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Scheme;
use app\models\Targets;
use app\models\Sector;
use app\models\Job;
use app\models\TpartnerDetail;
use app\models\TargetsResponse;


/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Targets */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Targets');
$this->params['breadcrumbs'][] = ['label' => $tpDetails['tp_name'], 'url' => ['tpartner/view-application', 'id' => $tpDetails['id'],]];

// $this->params['breadcrumbs'][] = $tpDetails['tp_name'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="targets-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,
   
    'columns' => [
        ['class' => '\kartik\grid\CheckboxColumn'],
        [
          'class' => 'kartik\grid\ExpandRowColumn',
          'width' => '50px',
          'value' => function ($model, $key, $index, $column) {
              return GridView::ROW_COLLAPSED;
           },
          'detail' => function ($model, $key, $index, $column) {
            //   print_r();
              return Yii::$app->controller->renderPartial('schemewisejob', ['model' =>2]);
           },
          'headerOptions' => ['class' => 'kartik-sheet-style'],
          'expandOneOnly' => true,
          'expandIcon' => '',
          'collapseIcon' => '',
        ],

     
        [
          'attribute'=> 'id',
          'label'=>"Target ID",
            'contentOptions' => ['style' => 'width:10%'],

          'format'=>'html',
          'value'=>function($model){
              return Yii::$app->params['target_prefix'].$model->id;
          }
        ],
            [
              'attribute'=>  'sector_id',
              'label'=>"Sector",
              'filter' => ArrayHelper::map(Job::find()->all(), 'id', 'job_name'),
              'filterType' => GridView::FILTER_SELECT2,
              'filterWidgetOptions' => [
              'options' => ['prompt' => 'All'],
              'pluginOptions' => [
              'allowClear' => true,
              'format'=>'html',
             
              ]
              ],
              'value'=>function($model){
                  // echo "<pre>";
                  return Sector::findOne($model->sector->sector_id)->sector_name;
                 
                  // die;
               }
          ], 
            // 'id',
            [
                'attribute'=>  'scheme_id',
                'label'=>"Scheme Name",
                'filter' => ArrayHelper::map(Scheme::find()->all(), 'id', 'full_name'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                'options' => ['prompt' => 'All'],
                'pluginOptions' => [
                'allowClear' => true,
                'format'=>'html',
               
                ]
                ],
                'value'=>function($model){
                    return $model->scheme->full_name;
                 }
            ], 
            [
              'attribute'=>  'job_id',
              'label'=>"Job Name",
              'filter' => ArrayHelper::map(Job::find()->all(), 'id', 'job_name'),
              'filterType' => GridView::FILTER_SELECT2,
              'filterWidgetOptions' => [
              'options' => ['prompt' => 'All'],
              'pluginOptions' => [
              'allowClear' => true,
              'format'=>'html',
             
              ]
              ],
              'value'=>function($model){
                  return $model->job->job_name;
               }
          ], 
         
            // 'scheme.full_name',
            // 'tp.tp_name',
            'number',
            // [
            //     'attribute'=>  'updated_at',
            //     'label'=>"Last Updated",
            //     'filter'=>false,
            //     'format'=>'html',
            //     'value'=>function($model){
            //        return  date('d F Y',strtotime($model->created_at)) ." at ".date('h:i:s A',strtotime($model->created_at));
            //     }
            // ],
            [
                'attribute'=>  'edited_by',
                'label'=>"Assigned By",
                'filter'=>false,
                'format'=>'html',
                'value'=>function($model){
                   return $model->editedBy->username;
                }
            ],
            [
              'class' => 'kartik\grid\ActionColumn',
              'dropdown' => false,
              'width'=>'20',
              // 'contentOptions' => ['style' => 'width:20%'],
              'hAlign'=>'middle',
              'template' => ' {apply}  ',
              'buttons' => [
                'apply' => function($url, $model){

                  if (TargetsResponse::find()->where(['target_id'=>$model->id])->one()) {
                    return Html::a('Applied', ['applied', 'id' => $model->id], [
                      'class' => 'btn btn-info btn-sm',
                      
                  ]);
                  }
                    return Html::a('Apply', ['apply', 'id' => $model->id], [
                        'class' => 'btn btn-success btn-sm',
                        
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
      'heading'=>'<h5>'.Html::encode(mb_strtoupper($tpDetails['tp_name'] ." ".$this->title)).'</h5>',
    //   'before'=>Html::a('<i class="fa fa-plus"></i> Create ', ['create'], ['class' => 'btn btn-success btn-sm']) .'&nbsp&nbsp'.Html::button('<i class="fa fa-trash"></i> Delete Selected ',  ['class' => 'btn btn-danger btn-sm','id'=>'delete-all','data-attrib-name'=>'target']),
    //   'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['index'], ['class' => 'btn btn-info btn-sm']),
    ],
   
]);
   ?>


</div>
