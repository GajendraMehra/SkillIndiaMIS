<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Sector;
use app\models\CommonModel;
use app\models\TargetsResponse;
use app\models\Cities;
use app\models\Job;
use app\models\TpartnerDetail;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Targets */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Targets');
$this->params['breadcrumbs'][] = $this->title;
?>

<style>

</style>
<div class="targets-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,

    'columns' => [
        ['class' => '\kartik\grid\CheckboxColumn'],


        [
            'attribute'=> 'id',
            'label'=>"Target ID",
              'contentOptions' => ['style' => 'width:10%'],

            'format'=>'html',
            'value'=>function($model){
                return Yii::$app->params['target_prefix'].$model->id;
            }
        ],
        
            // 'id',



            [
                'attribute'=>  'tp_id',
                'label'=>"Assigned Training Partner",
                'filter' => ArrayHelper::map(TpartnerDetail::find()->where(['is_approved'=>1])->all(), 'id', 'tp_name'),
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
              'attribute'=>  'jobs',
              'label'=>"Jobs",
              'filter'=>false,
              'format'=>'html',
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
              'filter' => ArrayHelper::map(Cities::find()->where(['state_id'=>33])->all(), 'id', 'city'),
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
              'attribute'=> 'id',
              'header'=>false,
              'label'=>false,
              'filter'=>false,
    
              'format'=>'html',
              'value'=>function($model){
               if (@TargetsResponse::find()->where(['status'=>0,'target_id'=>$model->id])->one()->target_id) {
                return '<div class="spinner-grow text-danger" role="status"> <span class="sr-only">Loading...</span> </div>';
               }
               return "";
              }
            ],
            [
              'class' => 'kartik\grid\ActionColumn',
              'dropdown' => false,
              'width'=>'30',
            //   'contentOptions' => ['style' => 'width:400px'],

              // 'contentOptions' => ['style' => 'width:20%'],
              'hAlign'=>'middle',
              'template' => ' {viewresponse}  ',
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
                'viewresponse' => function($url, $model){
                    return Html::a('View Respnse', ['view-response', 'id' => $model->id], [
                        'class' => 'btn btn-success btn-sm',

                    ]);
                },

              ],
              'urlCreator' => function($action, $model, $key, $index) {
                      return Url::to([$action,'id'=>$key]);
              },
              'viewOptions'=>['role'=>'modal-local' ,
              'icon'=>'glyphicon glyphicon-trash',
              'label' => 'View Response',['viewresponse'],'class' => 'btn btn-success btn-sm','title'=>'View'],
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
      'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['index'], ['class' => 'btn btn-info btn-sm']),
    ],

]);
   ?>


</div>
