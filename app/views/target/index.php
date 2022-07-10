<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Sector;
use app\models\CommonModel;
use app\models\UkDistrict;
use app\models\Job;
use app\models\TpartnerDetail;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Targets */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Targets');
$this->params['breadcrumbs'][] = $this->title;
?>

<style media="screen">
#w0-container
 {
	overflow: auto;
	overflow-x: scroll;
	width: 75vw;

}


</style>

<div class="targets-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,

    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],
      
        [
          'attribute'=> 'id',
          'label'=>"Target ID",
            'contentOptions' => ['style' => 'width:10%'],

          'format'=>'html',
          'value'=>function($model){
            return   Html::a(Yii::$app->params['target_prefix'].$model->id  , ['view','id'=>$model->id], ['target'=>'_blank','class'=>'text-primary']);
          }
      ],
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
       
            // 'id',



            [
                'attribute'=>  'tp_id',
                'label'=>"Assigned Training Partner",
                'filter' => ArrayHelper::map(TpartnerDetail::find()->all(), 'id', 'tp_name'),
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                'options' => ['prompt' => 'All'],
                'pluginOptions' => [
                'allowClear' => true,
                'format'=>'html',

                ]
                ],
                'value'=>function($model){
                   return $model->tp->tp_name;
                }
            ],
            // 'scheme.full_name',
            // 'tp.tp_name',

            [
              'attribute'=>  'job_id',
              'label'=>"Jobs",
              'format'=>'html',
              'filter' => ArrayHelper::map(Job::find()->orderBy(['id'=>SORT_ASC])->all(), 'id', 'job_name'),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
            'options' => ['prompt' => 'All',
            ],
            'pluginOptions' => [
            'allowClear' => true,
            'format'=>'html',
            'multiple' => true

            ]
            ],
              'value'=>function($model){
                $html="";
                foreach ($model->getJobs($model->id) as $key => $value) {
                $html.='<span class="badge badge-primary mr-2">'.$value['job_name'].'</span>';
                }
              return $html;
              }
          ], [
              'attribute'=>  'district_id',
              'label'=>"Districts ",
              // 'filter'=>false,
              'format'=>'html',
              'filter' => ArrayHelper::map(UkDistrict::find()->orderBy(['name'=>SORT_ASC])->all(), 'id', 'name'),
              'filterType' => GridView::FILTER_SELECT2,
              'filterWidgetOptions' => [
                'options' => ['prompt' => 'All',
                ],
                'pluginOptions' => [
                'allowClear' => true,
                'format'=>'html',
                'multiple' => true

                ]
              ],
              'value'=>function($model){
                $html="";
                // echo "<pre>";
                // print_r($model->getDistricts($model->id) );
                foreach ($model->getDistricts($model->id) as $key => $value) {
                $html.='<span class="badge badge-info mr-2">'.$value['name'].'</span>';
                }
              return $html;
              }
          ],
        
            [
                'attribute'=>   'status',
                'format'=>'html',
                'filter' => ['Deactive','Active'],
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                  'options' => ['prompt' => 'All',
                  ],
                  'pluginOptions' => [
                  'allowClear' => true,
                  'format'=>'html',
                 

                  ]
                ],
                'value'=>function($model){
                  return CommonModel::labelsStatus($model->status);
                },
                'contentOptions' => ['style' => 'width:10%'],


            ], 
             [
                'attribute'=>  'number',
              'contentOptions' => ['style' => 'width:10%'],


            ],
            [
              'class' => 'kartik\grid\ActionColumn',
              'dropdown' => false,
              'width'=>'30',
            //   'contentOptions' => ['style' => 'width:400px'],

              // 'contentOptions' => ['style' => 'width:20%'],
              'hAlign'=>'middle',
              'template' => '{delete} {view}  ',
              'buttons' => [
                'delete' => function($url, $model){
                    return Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Are you absolutely sure ? You will lose all the information about this training partner  with this action.',
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
              'label' => 'Update Target','class' => 'btn btn-info btn-sm','title'=>'Update',
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
      'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['index','filter'=>'all'], ['class' => 'btn btn-info btn-sm']),
    ],

]);
   ?>


</div>
