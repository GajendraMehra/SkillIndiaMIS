<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\CommonModel;
use app\models\BatchStudents    ;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TransDetail */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tranche Status';
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
<div class="trans-detail-index">
    <?= GridView::widget([
        'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'contentOptions' => ['style' => 'width:3%; white-space: normal;'],

                ],
                [
                    'attribute'=> 'tc_name',
                  'label'=>"Training Center Name",

                    'format'=>'html',
                    'value'=>function($model){
                    return Html::a($model->tc->name,['view','id'=>$model->id], ['target'=>'_blank', 'data-pjax'=>"0",'class'=>'text-primary']);

                    }

                ],  [
                    'attribute'=> 'tc_sid',
                    'label'=>"Smart TC ID",
                    'format'=>'html',
                    'value'=>function($model){
                    return $model->tc->smart_tcid;
                    }

                ],  [
                    'attribute'=> 'tp_name',
                    'label'=>"Training Partner Name",
                    'format'=>'html',
                    'value'=>function($model){
                        
                        return $model->tc->parenttp->tp_name;
                    }

                ],
                [
                    'label'=> 'TP SDMS ID',
                    'attribute'=>"tp_sid",
                  

                    'format'=>'html',
                    'value'=>function($model){
                        return $model->tc->parenttp->tp_sdms_id;
                    }

                ],
                [
                    'attribute'=> 'batch_name',
                  

                    'format'=>'html',
                    'value'=>function($model){
                    return Html::a($model->batch->batch_name,['batch/view','id'=>$model->batch->id], ['target'=>'_blank', 'data-pjax'=>"0",'class'=>'text-primary']);
                    }

                ],
                [
                    'attribute'=> 'batch_sip_id',
                    'label'=> 'Batch SIP ID ',
                    'format'=>'html',
                    'value'=>function($model){
                    return $model->batch->sip_id;
                    }

                ],
                [
      
                    //  'contentOptions => ['style' => 'width:10%; white-space: normal;'],
                    'label'=>'No of Students',
                     'format'=>'html',
                     'value'=>function($model){
                      return BatchStudents::find()->where(['batch_id'=>$model->batch->id])->count();
                
                     }
                
                ],
                [
                    'attribute'=> 'claim_type',

                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' =>    CommonModel::getTransStage(),

                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                    'options' => ['prompt' => 'All'],
                    'pluginOptions' => [
                    'allowClear' => true,
                    ]
                    ],

                    'format'=>'html',
                    'value'=>function($model){
                    return  CommonModel::getTransStage()[$model->claim_type];
                    }

                ],   
                [
                    'attribute'=> 'status',

                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' =>    CommonModel::transStatus(),
                    // 'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                    'options' => ['prompt' => 'All'],
                    'pluginOptions' => [
                    'allowClear' => true,
                    ]
                    ],

                    'format'=>'html',
                    'value'=>function($model){
                    return  CommonModel::getTransStatus($model->status);
                    }

                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    // 'width'=>'30',

                    'vAlign'=>'middle',
                    'template' => ' {view} ',
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
            'before'=>(Yii::$app->user->identity->role!=3) ? '' : Html::a('<i class="fa fa-plus"></i> New Claim ', ['create'], ['class' => 'btn btn-success btn-sm']) .'&nbsp&nbsp',
            'after'=>Html::a('<i class="fa fa-redo"></i> Reload ', ['index'], ['class' => 'btn btn-info btn-sm']),
            ],
        ]);
    ?>
</div>
