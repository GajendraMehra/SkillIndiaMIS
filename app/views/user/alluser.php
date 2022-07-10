<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use app\models\CommonModel;


/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Users */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,

    'columns' => [
        // ['class' => '\kartik\grid\CheckboxColumn'],


            [
              'class' => 'yii\grid\SerialColumn',
              'contentOptions' => ['style' => 'width:10px; white-space: normal;'],

            ],
            [
              'attribute'=>  'profile_pic',
                'format'=>'html',
                'filter'=>false,
                'value'=>function($model){
                  $imageurl= Url::base().'/'.$model->profile_pic;
                   return Html::img($imageurl,['width' => '80px','class'=>'rounded-circle']);
                }
            ],
            'username',

            'email',
            [
                'attribute'=>'role',
                  'format'=>'html',
                  'filter' => [
                    1=>"Admin",
                    2=>"Training Partner",
                    3=>"Training Center",
                    4=>"Accountant",
                ],
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                'options' => ['prompt' => 'All'],
                'pluginOptions' => [
                'allowClear' => true,
                'format'=>'html',
  
                ]
                ],
                  'value'=>function($model){
                    // $imageurl= Url::base().'/'.$model->profile_pic;
                    return Yii::$app->params['role_'.$model->role];
                  }
              ],

            [
              'attribute'=>'status',
                'format'=>'html',
                'filter' => array('0'=>"Suspended",'10' => 'Active','9'=> 'Waiting for Email Verification','' ),
              'filterType' => GridView::FILTER_SELECT2,
              'filterWidgetOptions' => [
              'options' => ['prompt' => 'All'],
              'pluginOptions' => [
              'allowClear' => true,
              'format'=>'html',

              ]
              ],
                'value'=>function($model){
                  // $imageurl= Url::base().'/'.$model->profile_pic;
                   return CommonModel::UserStatus($model->status);
                }
            ],
          


            // [
            //     'attribute'=>  'created_at',
            //     'label'=>"Registerd On",
            //     'format'=>'html',
            //     'value'=>function($model){
            //         return date('d F Y',$model->created_at) ." at ".date('h:i:s A',$model->created_at);
            //     }
            // ],
            [
              'class' => 'kartik\grid\ActionColumn',
              'dropdown' => false,
              'width'=>'20',
              // 'contentOptions' => ['style' => 'width:20%'],
              'hAlign'=>'middle',
              'template' => '{view}',
              'buttons' => [
                'delete' => function($url, $model){
                    return Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-danger',
                        'data' => [
                            'confirm' => 'Are you absolutely sure ? You will lose all the related information with this action.',
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
              'label' => 'View','class' => 'btn btn-sm btn-success ','title'=>'View'],
              'updateOptions'=>['role'=>'modal-remote',
              'label' => 'Update',
              'class' => 'btn btn-sm btn-info ',
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
    //   'before'=>Html::a('<i class="fa fa-plus"></i> Create ', ['create'], ['class' => 'btn btn-success btn-sm']) .'&nbsp&nbsp',
      'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['alluser'], ['class' => 'btn btn-info btn-sm']),
    ],

]);
?>



</div>
