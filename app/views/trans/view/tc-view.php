<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\CommonModel;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\BatchStudents;
use app\models\search\StudentResult as StudentResultSearch;
use app\models\search\StudentPlacement as StudentPlacementSearch;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\TransDetail */
use app\models\search\BatchStudents as BatchStudentsSearch;
use kartik\form\ActiveForm;
use yii\grid\GridView;
$status=[
    '1'=>"Yes",
    "2"=>"No"
];
$this->title = $model->batch->batch_name;
$this->params['breadcrumbs'][] = ['label' => 'Tranche Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js" integrity="sha512-d5Jr3NflEZmFDdFHZtxeJtBzk0eB+kkRXWFQqEc1EKmolXjHm2IKCA7kTvXBNjIYzjXfD5XzIjaaErpkZHCkBg==" crossorigin="anonymous"></script>
<div class="trans-detail-view">

    <div class="card card-primary border-info">
            <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
            <h5><?= $this->title ?></h5>
            </div>
             <div class="card-body" >
           <div class="text-right">
           <?= Html::a(Yii::t('app', '<i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print'), 'javascript:void(0)', ['class' => 'btn btn-primary','onclick'=>'printData()']) ?>
           <?php if ($model->status==3): ?>
            <?= Html::a(Yii::t('app', '<i class="fa fa-print" aria-hidden="true"></i>&nbsp;Bill of Supply'), ['bill','id'=>$model->id], ['class' => 'btn btn-warning',]) ?>
            <?php endif; ?>
           </div>
            <div id="printarea">
            <h5 class="mb-2 text-uppercase">Batch Detail   <p class="text-right font-weight-normal pull-right"> Invoice No. - <?= Yii::$app->config->get('invoice_pre','UK/IN/0/00') .$model->id; ?></p></h5>


                <div class="row">
                <div class="col-12">
                <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
         
                    
          
                    [
                        'attribute'=> 'batch_id',
                    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
        
                        'label'=>"Scheme Name ",
                        'value'=>function($model){
                            return $model->batch->subTarget->target->scheme->full_name ." (".$model->batch->subTarget->target->scheme->short_name.")";


                        }
        
                    ],
                    [
                        'attribute'=> 'batch_id',
                    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
        
                        
                        'value'=>function($model){
                       return $model->batch->batch_name .' ( '.Yii::$app->config->get('batch-prefix','UK/SK/B00').$model->batch->id." )";
                        }
        
                    ],
                    [
                        'attribute'=> 'batch_id',
                    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
        
                        'label'=>"Batch SIP Id",
                        'value'=>function($model){
                        return $model->batch->sip_id;
                        }
        
                    ],
                   
                    
                    [
                        'label'=>"Job Name",
                        'value'=>function($model){
                        return $model->batch->jobs->job_name . " (".$model->batch->jobs->qp_code .") ";
                        }
                    ],
                    [
                        'attribute'=>'start_date',
                        'label'=>"Batch Date",
                        'format'=>'html',
                        'value'=>date('d F Y',strtotime($model->batch->start_date)).'-'.date('d F Y',strtotime($model->batch->end_date))
                    ],
                    [
                        'attribute'=>'start Time',
                        'label'=>"Batch Time",
                        'format'=>'html',
                        'value'=>date('h:i a',strtotime($model->batch->start_time)).'-'.date('h:i a',strtotime($model->batch->end_time))
                    ],
                    
                    [
                        'attribute'=> 'status',
                    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
        
                        'format'=>'html',
                        'value'=>function($model){
                        return  CommonModel::getTransStatus($model->status);
                        }
        
                    ],  
                     [
                        'attribute'=> 'rate_info',
                    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
                        'label'=>"Base Cost",
                        'format'=>'html',
                        'value'=>function($model){
                                if(@$model->rateinfo->rate_amount)
                                     return  "&#x20B9; ".round(@$model->rateinfo->rate_amount,2);
                                else 
                                return "Not Set By admin";
                        }
                    ],
                    [
                        'label'=>"Net Hours",
                        'value'=>function($model){  
                        return $model->batch->jobs->net_hours ." Hours";;
                        } 
                    ],     
                    [
                        'attribute'=>   'created_at',
                        'label'=>"Requested On",
                        // 'label'=>"Assigned Training Partner",
                        'format'=>'html',
                        'value'=>date('d F Y',strtotime($model->created_at))." at ".date('h:i:a',strtotime($model->created_at))
                    ],
                 
                     
                    [
                        'attribute'=> 'tc_id',
                        'label'=>"Training Partner",
                        'format'=>'html',
                        'value'=>function($model){
                            return   Html::a( $model->tc->parenttp->tp_name, ['tpartner/view','id'=> $model->tc->parenttp->id], ['target'=>'_blank','class'=>'text-primary']);

                        // return $model->tc->parenttp->tp_name
                        }
                    ], 
                    [
                        'attribute'=> 'tc_id',
                        'label'=>"Training Center",
                        'format'=>'html',
                        'value'=>function($model){
                            return   $model->tc->name." " ." / ". $model->tc->tcaddress->address_line ." - ". $model->tc->tcaddress->trainingcenters->name;

                        // return $model->tc->parenttp->tp_name
                        }
                    ], 
                    [
                        'attribute'=> 'claim_type',
                    //  'contentOptions' => ['style' => 'width:10%; white-space: normal;'],
        
                        
                        'value'=>function($model){
			if($model->trans_percent)
                        return  CommonModel::getTransStage()[$model->claim_type] ." - ".$model->trans_percent. " %";
			else
			return "Not Set By Admin";
                        }
        
                    ]
           
          
                     ],
            ]) ?>
                
     </div>
    
</div>
<?php if ($model->status==3): ?>
<?php
 if ($model->claim_type==3) {
 
    $searchModel = new BatchStudentsSearch(['batch_id'=>$model->batch_id,'reclaim'=>1]);
}elseif ($model->claim_type==4) {
 
    $searchModel = new BatchStudentsSearch(['batch_id'=>$model->batch_id,'reclaim'=>2]);
}else{
    $searchModel = new BatchStudentsSearch(['batch_id'=>$model->batch_id,'reclaim'=>0]);
}
 $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 echo $this->render('receipt/trans'.$model->claim_type, [
    'model' => $model,
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
]);
?>
<?php endif; ?>
<?php if ($model->status!=3): ?>

<?php if ($model->claim_type==1): ?>
<!-- student result section start -->
<?php
$searchModel = new StudentResultSearch(['batch_id'=>$model->batch_id]);
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
echo $this->render('_student-result', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
]);
?>
<?php endif; ?>

<?php if ($model->claim_type==2): ?>
<!-- student placement  section start -->
<?php
$searchModel = new StudentPlacementSearch(['batch_id'=>$model->batch_id]);
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
echo $this->render('_student-placement', [
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
]);
?>
<?php endif; ?>


<?php endif; ?>


<!-- recept section end -->


    </div>
    </div>
    </div>



</div>

<?php
$a= Url::base().'/'."custom/images/header.png";
$cssFile= Url::base().'/'."css/print.css";
?>
<script>
 function printData(){
    $("#printarea").printThis({ 
        importCSS: false,
        loadCSS: [
            "<?= $cssFile?>"
        ],
        header: '<div class="image-header"><img class="" src="<?= $a?>" height="60px" width="100%" alt="Logo " srcset=""></div>',
        footer:'',
        removeScripts: false, 
        pageTitle: "Invoice",          
        copyTagClasses: true,      
        })
    }

</script>
