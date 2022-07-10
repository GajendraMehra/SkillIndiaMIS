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

$this->title = Yii::t('app', 'Assigned Targets');
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
          'filter'=>false,
            'format'=>'html',
            'value'=>function($model){
                return Yii::$app->params['target_prefix'].$model->target_id.'/'.$model->id;
            }
        ],
        
        [
          'attribute'=> 'year',
          'label'=>"Finanace Year",

          'format'=>'html',
          'value'=>function($model){
              return (String)$model->target->year."-".(String)(($model->target->year%100)+1);
          }
      ],
      [
          'label'=>"Target for Scheme",
          'format'=>'html',
          'value'=>function($model){
              return $model->target->scheme->short_name;
          }
          

      ],



            // 'center.name',
            // 'center.smart_tcid',
            'job.job_name',
            [
              'attribute'=> 'district.name',
              'label'=>"District",
              'format'=>'html',
              // 'value'=>function($model){
              //   return CommonModel::labelsTargetApprovedstatus($model->status);
              // }
          ],

            // 'created_at',
            [
              'attribute'=> 'response_number',
              'label'=>"Targets",
              'format'=>'html',
              // 'value'=>function($model){
              //   return CommonModel::labelsTargetApprovedstatus($model->status);
              // }
          ],
           // [
          //     'attribute'=> 'status',
          //     'label'=>"Status",
          //     'filter'=>false,
          //     'format'=>'html',

          //     'value'=>function($model){
          //       return CommonModel::labelsTargetApprovedstatus($model->status);
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
                            'confirm' => 'Are you absolutely sure ? You will lose all the information about this training partner  with this action.',
                            'method' => 'post',
                            'class' => 'danger'
                        ],
                    ]);
                },


              ],
              'urlCreator' => function($action, $model, $key, $index) {
                      return Url::to(['target-view','id'=>$key]);
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
      'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['targets'], ['class' => 'btn btn-info btn-sm']),
    ],

]);
   ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



</div>
