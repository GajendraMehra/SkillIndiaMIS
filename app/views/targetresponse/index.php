<?php

use yii\helpers\Html;
use kartik\grid\GridView;

use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Sector;
use app\models\Job;
use app\models\CommonModel;
use app\models\TpartnerDetail;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TargetsResponse */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Acknowledged Targets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="targets-response-index">


    <?= GridView::widget([
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,

    'columns' => [
        ['class' => '\kartik\grid\CheckboxColumn'],


        [
            'attribute'=> 'target_id',
            'label'=>"Target ID",
              'contentOptions' => ['style' => 'width:10%'],

            'format'=>'html',
            'value'=>function($model){
                return Yii::$app->params['target_prefix'].$model->target_id;
            }
        ],



            'center.name',
            'center.smart_tcid',
            'job.job_name',
            'district.name',

            // 'created_at',
            [
              'attribute'=> 'response_number',
              'label'=>"Targets",
              'format'=>'html',
              // 'value'=>function($model){
              //   return CommonModel::labelsTargetApprovedstatus($model->status);
              // }
          ],
            [
              'attribute'=> 'status',
              'label'=>"Status",
              'format'=>'html',
              'filter' =>['Waiting for Admin Response','Approved By Admin','Declined By Admin'],
              'filterType' => GridView::FILTER_SELECT2,
              'filterWidgetOptions' => [
              'options' => ['prompt' => 'All'],
              'pluginOptions' => [
              'allowClear' => true,
              'format'=>'html',

              ]
              ],
              'value'=>function($model){
                return CommonModel::labelsTargetApprovedstatus($model->status);
              }
          ],
            // 'id',
            // [
            //     'attribute'=>  'sector_id',
            //     'label'=>"Sector",
            //     'filter' => ArrayHelper::map(Job::find()->all(), 'id', 'job_name'),
            //     'filterType' => GridView::FILTER_SELECT2,
            //     'filterWidgetOptions' => [
            //     'options' => ['prompt' => 'All'],
            //     'pluginOptions' => [
            //     'allowClear' => true,
            //     'format'=>'html',

            //     ]
            //     ],
            //     'value'=>function($model){
            //         // echo "<pre>";
            //         return Sector::findOne($model->sector->sector_id)->sector_name;

            //         // die;
            //      }
            // ],
            // [
            //     'attribute'=>  'job_id',
            //     'label'=>"Job Name",
            //     'filter' => ArrayHelper::map(Job::find()->all(), 'id', 'job_name'),
            //     'filterType' => GridView::FILTER_SELECT2,
            //     'filterWidgetOptions' => [
            //     'options' => ['prompt' => 'All'],
            //     'pluginOptions' => [
            //     'allowClear' => true,
            //     'format'=>'html',

            //     ]
            //     ],
            //     'value'=>function($model){
            //         return $model->job->job_name;
            //      }
            // ],
            // [
            //     'attribute'=>  'qp_code',
            //     'label'=>"QP code",

            //     'value'=>function($model){
            //         return $model->job->qp_code;
            //      }
            // ],
            // [
            //     'attribute'=>  'tp_id',
            //     'label'=>"Assigned Training Partner",
            //     'filter' => ArrayHelper::map(TpartnerDetail::find()->all(), 'id', 'tp_name'),
            //     'filterType' => GridView::FILTER_SELECT2,
            //     'filterWidgetOptions' => [
            //     'options' => ['prompt' => 'All'],
            //     'pluginOptions' => [
            //     'allowClear' => true,
            //     'format'=>'html',

            //     ]
            //     ],
            //     'value'=>function($model){
            //        return $model->tp->tp_name;
            //     }
            // ],
            // // 'scheme.full_name',
            // // 'tp.tp_name',
            // 'number',
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
              'class' => 'kartik\grid\ActionColumn',
              'dropdown' => false,
              'width'=>'20',
              // 'contentOptions' => ['style' => 'width:20%'],
              'hAlign'=>'middle',
              'template' => ' {view}  ',
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
      'heading'=>'<h5>'.Html::encode(mb_strtoupper($title)).'</h5>',
    //   'before'=>Html::a('<i class="fa fa-plus"></i> Create ', ['create'], ['class' => 'btn btn-success btn-sm']) .'&nbsp&nbsp'.Html::button('<i class="fa fa-trash"></i> Delete Selected ',  ['class' => 'btn btn-danger btn-sm','id'=>'delete-all','data-attrib-name'=>'target']),
      'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['index'], ['class' => 'btn btn-info btn-sm']),
    ],

]);
   ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



</div>
