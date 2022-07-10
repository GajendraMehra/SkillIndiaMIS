<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\CommonModel;
use app\models\BatchStudents    ;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TransDetail */
/* @var $dataProvider yii\data\ActiveDataProvider */
use app\models\TransDetail;
use app\models\search\TransDetail as TransDetailSearch;
$searchModel = new TransDetailSearch(['tc_id'=>$model->tc_id,'batch_id'=>$model->batch_id]);

$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        'columns' => [
             
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
      
                    //  'contentOptions => ['style' => 'width:10%; white-space: normal;'],
                    'label'=> 'Rate Amount',
                     'format'=>'html',
                     
                     'value'=>function($model){
                        if(@$model->rateinfo->rate->rate_name)
                      return "Rate ".@$model->rateinfo->rate->rate_name."  &#8377;".round(@$model->rateinfo->rate_amount,2) ;
                
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
           
            ],
           
           
        ]);
    ?>
</div>
