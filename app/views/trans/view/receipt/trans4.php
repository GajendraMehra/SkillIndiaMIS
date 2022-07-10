<?php
use yii\grid\GridView;
use app\models\CommonModel;
use app\models\TransDetail;
use yii\helpers\Html;
?>

<h5 class="mb-2 text-uppercase">Candidate Detail</h5>
<?= GridView::widget([
       'dataProvider' => $dataProvider,
       'summary'=>false,
       'showFooter'=>TRUE,
    //    'title'=>'Student',   
     
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'attribute' => 'sip_id',
                'label'=>"Candidate ID",
                'enableSorting' => false,
                'value'=>function($model){
                    return $model->student->sip_id;
                  }
            ], 
       
            [
                'attribute' => 'student_id',
                'label'=>"Candidate Name",
                'format'=>"html",
                'enableSorting' => false,
                'value'=>function($model){
                    return Html::a( $model->student->student_name,['student/view','id'=>$model->student->id], ['target'=>'_blank', 'data-pjax'=>"0",'class'=>'text-primary']);

                  }
            ], 
            [
                'attribute' => 'aadhar_no',
                // 'label'=>"Candidate ID",
                'enableSorting' => false,
                'value'=>function($model){
                    return $model->student->aadhar_no;
                  }
            ], 
            [
                'attribute' => 'student_id',
                'label'=>"Gender",
                'enableSorting' => false,
                'value'=>function($model){
                  return CommonModel::labelsGender($model->student->gender);
                  }
            ],
            [
                'attribute' => 'student_id',
                'label'=>"Base Cost ",
                'enableSorting' => false,
                'value'=>function($model){
                   
                    return round($model->trans[1]->rateinfo->rate_amount,2);
                  },
                  'footer'=>"<strong>Total</strong>",

            ], [
                'attribute' => 'student_id',
                'label'=>"Gross Payable Amount",
                'enableSorting' => false,
                'value'=>function ($model, $key, $index, $widget) use (&$tptotal) {
                    $tpamount=$model->trans[1]->rateinfo->rate_amount*$model->trans[1]->batch->jobs->net_hours;
                    $tptotal +=$tpamount;
                    $widget->footer = "&#x20B9; ".$tptotal;
                    return $tpamount ;
                },     
              
            ], [
                'attribute' => 'student_id',
                'label'=>"First Tranche Amount",
                'enableSorting' => false,
                'value'=>function ($model, $key, $index, $widget) use (&$total) {
                    if ($model->studentresult->result2==1) {
                        
                    $famount=($model->trans[0]->rateinfo->rate_amount*$model->trans[0]->batch->jobs->net_hours)*($model->trans[0]->trans_percent/100);
                    $total +=$famount;
                    $widget->footer =  "&#x20B9; ".$total;
                    return $famount ;
                    } else {
                       return "0";
                    }
                  
                  
                },       
                
            ],
            [
                'attribute' => 'student_id',
                'label'=>"Result",
                'enableSorting' => false,
                'format'=>'html',
                'value'=>function ($model, $key, $index, $widget1) use (&$fTranTotal,&$failStudentTotal,&$sTranTotal) {
                  if ($model->studentresult->result2==1) {
                     return '<span class="badge badge-success"> Pass </span>';
                  }else{
                    return '<span class="badge badge-danger"> Fail </span>';

                  }
                },       
                // 'value'=>function($model){
                //     return ($model->trans[1]->rateinfo->rate_amount*$model->trans[1]->batch->jobs->net_hours)*($model->trans[0]->trans_percent/100);
                //   },
                //   'footer'=>120,
            ], 
            [
                'attribute' => 'student_id',
                'label'=>"Reassesment Tranche Amount (".$model->trans_percent ." %)",

                'enableSorting' => false,
                'format'=>'html',
                'value'=>function ($model, $key, $index, $widget2) use (&$fTranTotal,&$failStudentTotal,&$sTranTotal) {
                    $famount2=0;
                    $damount2=0;
                    $famount1=($model->trans[0]->rateinfo->rate_amount*$model->trans[0]->batch->jobs->net_hours)*($model->trans[0]->trans_percent/100);
                    $fTranTotal +=$famount1;
                
                    if ($model->studentresult->result2==1) {
                        $damount2=($model->trans[0]->rateinfo->rate_amount*$model->trans[0]->batch->jobs->net_hours)*($model->trans[0]->trans_percent/100);

                        $famount2=($model->trans[1]->rateinfo->rate_amount*$model->trans[1]->batch->jobs->net_hours)*($model->trans[1]->trans_percent/100);
                        $sTranTotal +=($famount2+$damount2);
                        $netAmount=$sTranTotal;
                        $widget2->footer =  "<input type='hidden' value=".$netAmount." name='TotalAmount'>&#x20B9;  ".($netAmount) ."";

                    }else{
                        $damount2=0;
                        $failStudentTotal +=$damount2;
                        $netAmount=$sTranTotal-$failStudentTotal;
                        $widget2->footer =  "<input type='hidden' value=".$netAmount." name='TotalAmount'>&#x20B9;  ".($netAmount) ."";
                        return ''.$damount2;
                    }
                   
                    return $famount2."+".$damount2."=".$famount2+$damount2;
                },       
                // 'value'=>function($model){
                //     return ($model->trans[1]->rateinfo->rate_amount*$model->trans[1]->batch->jobs->net_hours)*($model->trans[0]->trans_percent/100);
                //   },
                //   'footer'=>120,
            ], 
          
            // 'student_id',
            // 'created_at',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); 

    ?>