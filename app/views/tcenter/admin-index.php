<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\CommonModel;
use yii\helpers\ArrayHelper;
use app\models\TpartnerDetail;


/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Tcdetail */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Training Centers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tcdetail-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'name:ntext',
            'smart_tcid:ntext',
            'email',
            [
                'attribute'=>'tp_id',
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
                'format'=>'html',
                'label'=>'Parent T.P',
                //'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                'value'=> function ($model, $key, $index, $grid){
                    return  Html::a(@$model->parenttp->tp_name, ['tpartner/view', 'id' => $model->tp_id], [
                        'class'=>'text-primary',
                        'target'=>"_blank"
                    ]);
                   return @$model->parenttp->tp_name;
                    },
            ],
            
            // [
            //     'attribute'=>'is_pmkk',
            //     'label'=>'PMKK Status',
            //     'filter' => ['No','Yes'],
            //     'filterType' => GridView::FILTER_SELECT2,
            //     'filterWidgetOptions' => [
            //     'options' => ['prompt' => 'All'],
            //     'pluginOptions' => [
            //     'allowClear' => true,
            //     'width' => '100px',
               
            //     ]
            //     ],
            //     'value'=> function ($model, $key, $index, $grid){
            //         return CommonModel::labels($model->is_pmkk);
            //         },
            //     ], [
            //     'attribute'=>'tcenter_type',
            //     'filter' => CommonModel::getCeneterTypelabels(),
            //     'filterType' => GridView::FILTER_SELECT2,
            //     'filterWidgetOptions' => [
            //     'options' => ['prompt' => 'All'],
            //     'pluginOptions' => [
            //     'allowClear' => true,
            //     'width' => '100px',
               
            //     ]
            //     ],
            //     // 'label'=>'Status',
            //     //'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
            //     'value'=> function ($model, $key, $index, $grid){
            //         return CommonModel::ceneterTypelabels($model->tcenter_type);
            //         },
            // ],
            // [
            //     'attribute'=>'is_hostel',
            //     'filter' => ['No','Yes'],
            //     'filterType' => GridView::FILTER_SELECT2,
            //     'filterWidgetOptions' => [
            //     'options' => ['prompt' => 'All'],
            //     'pluginOptions' => [
            //     'allowClear' => true,
            //     'width' => '100px',
               
            //     ]
            //     ],
            //     // 'label'=>'Status',
            //     //'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
            //     'value'=> function ($model, $key, $index, $grid){
            //         return CommonModel::labels($model->is_hostel);
            //         },
            // ],
            [
                'attribute'=>'status',
                'format'=>'html',
                'filter' => ['Not active','Active'],
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                'options' => ['prompt' => 'All'],
                'pluginOptions' => [
                'allowClear' => true,
                'width' => '100px',
               
                ]
                ],
                // 'label'=>'Status',
                //'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                'value'=> function ($model, $key, $index, $grid){
                    return CommonModel::labelsStatus($model->status);
                    },
            ],
            // 'is_hostel',
            //'hostel_capacity',
            //'status',
            //'tp_id',
            //'created_at',
            //'updated_at',
            //'edited_by',

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
                    return Html::a('Summary', ['report/json-tp', 'id' => $model->tp_id], [
                        'class' => 'btn btn-warning mt-1 btn-sm',
                       
                    ]);
                },
                  
                ],
                'urlCreator' => function($action, $model, $key, $index) { 
                     $action="admin-".$action;
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
          
          'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['admin-index'], ['class' => 'btn btn-info btn-sm']),
        ],
    ]); ?>


</div>
