<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Scheme;
use app\models\CommonModel;
use app\models\Sector;
use app\models\Job;
use app\models\UkDistrict;
use app\models\TpartnerDetail;
use app\models\TargetsResponse;


/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Targets */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', $title);
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
          'attribute'=> 'id',
          'label'=>"Target ID",
            'contentOptions' => ['style' => 'width:10%'],

          'format'=>'html',
          'value'=>function($model){
              return Yii::$app->params['target_prefix'].$model->id;
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
                'filter' => ArrayHelper::map(UkDistrict::find()->all(), 'id', 'name'),
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
      'heading'=>'<h5>'.Html::encode(mb_strtoupper($this->title)).'</h5>',
    //   'before'=>Html::a('<i class="fa fa-plus"></i> Create ', ['create'], ['class' => 'btn btn-success btn-sm']) .'&nbsp&nbsp'.Html::button('<i class="fa fa-trash"></i> Delete Selected ',  ['class' => 'btn btn-danger btn-sm','id'=>'delete-all','data-attrib-name'=>'target']),
    //   'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['index'], ['class' => 'btn btn-info btn-sm']),
    ],
   
]);
   ?>


</div>
