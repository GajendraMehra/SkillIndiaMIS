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
                'format'=>'raw',
                'enableSorting' => false,
                'value'=>function($model){
                  return Html::a( $model->student->student_name,['student/view','id'=>$model->student->id], ['target'=>'_blank', 'data-pjax'=>"0",'class'=>'text-primary']);

                  }
            ],
           
            [
              'label'=>"Aadhar No.",
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
                    return round(@$model->trans[2]->rateinfo->rate_amount,2);
                  },
                  'footer'=>"<strong>Total</strong>",

            ], [
                'attribute' => 'student_id',
                'label'=>"Gross Payable Amount ",
                'enableSorting' => false,
                'value'=>function ($model, $key, $index, $widget) use (&$tptotal) {
                    $tpamount=@$model->trans[0]->rateinfo->rate_amount*@$model->trans[0]->batch->jobs->net_hours;
                    $tptotal +=$tpamount;
                    $widget->footer = "&#x20B9; ".$tptotal;
                    return $tpamount ;
                },     
              
            ], [
                'attribute' => 'student_id',
                'label'=>"First Tranche Amount",
                'enableSorting' => false,
                'value'=>function ($model, $key, $index, $widget) use (&$total) {
                    $famount=(@$model->trans[0]->rateinfo->rate_amount*@$model->trans[0]->batch->jobs->net_hours)*(@$model->trans[0]->trans_percent/100);
                    $total +=$famount;
                    $widget->footer =  "&#x20B9; ".$total;
                    return $famount ;
                },       
                // 'value'=>function($model){
                //     return (@$model->trans[0]->rateinfo->rate_amount*@$model->trans[0]->batch->jobs->net_hours)*0.30;
                //   },
                //   'footer'=>120,
            ],
           
            [
                'attribute' => 'student_id',
                'label'=>"Second Tranche Amount",
                'enableSorting' => false,
                'format'=>'html',
                'value'=>function ($model, $key, $index, $widget1) use (&$fTranTotal,&$failStudentTotal,&$sTranTotal) {
                    $famount2=0;
                    $damount2=0;
                    $famount1=(@$model->trans[0]->rateinfo->rate_amount*@$model->trans[0]->batch->jobs->net_hours)*(@$model->trans[0]->trans_percent/100);
                    $fTranTotal +=$famount1;
                
                    if ($model->studentresult->result==1) {
                        $famount2=(@$model->trans[1]->rateinfo->rate_amount*@$model->trans[1]->batch->jobs->net_hours)*(@$model->trans[1]->trans_percent/100);
                        $sTranTotal +=$famount2;

                    }else{
                      $damount2=(@$model->trans[0]->rateinfo->rate_amount*@$model->trans[0]->batch->jobs->net_hours)*(@$model->trans[0]->trans_percent/100);

                        $failStudentTotal +=$damount2;
                        return '-'.$damount2;
                    }
                    $netAmount=$sTranTotal-$failStudentTotal;
                    $widget1->footer =  "&#x20B9;  ".($netAmount) ."";
                    return $famount2;
                },       
                // 'value'=>function($model){
                //     return (@$model->trans[0]->rateinfo->rate_amount*@$model->trans[0]->batch->jobs->net_hours)*0.30;
                //   },
                //   'footer'=>120,
            ], 
            [
                'attribute' => 'student_id',
                'label'=>"Result",
                'enableSorting' => false,
                'format'=>'html',
                'value'=>function ($model, $key, $index, $widget1) use (&$passCount,&$failCount,&$ncount) {
                    $pc=0;
                    $fc=0;
                    $nc=0;
                    // echo $model->studentresult->result;
                

                  if (@$model->studentplacement->result===0) {
                    $fc++;
                    $failCount+=$fc;
                      $widget1->footer =round(@$passCount*100/(($passCount+$failCount/1)?($passCount+$failCount):1),2) ." %";
                     return '<span class="badge badge-danger"> Not Placed </span>';
                  }
                  else if (@$model->studentplacement->result==1) {
                      $pc++;
                      $passCount+=$pc;
                      $widget1->footer =round(@$passCount*100/(($passCount+$failCount/1)?($passCount+$failCount):1),2) ." %";


                    return '<span class="badge badge-success"> Placed </span>';
                 }
                  else{
                    $nc++;
                    $ncount+=$nc;

                    $widget1->footer =round(@$passCount*100/(($passCount+$failCount/1)?($passCount+$failCount):1),2) ." %";


                    return '<span class="badge badge-warning"> Not Eligible </span>';

                  }
                  
                },     
             
                // 'value'=>function($model){
                //     return (@$model->trans[0]->rateinfo->rate_amount*@$model->trans[0]->batch->jobs->net_hours)*0.30;
                //   },
                //   'footer'=>120,
            ], 
            [
                'attribute' => 'student_id',
                'label'=>"Third Tranche Amount (".@$model->trans_percent ." %)",
                'enableSorting' => false,
                'format'=>'html',
                'value'=>function ($model, $key, $index, $widget1) use (&$passCount,&$failCount,&$ncount,&$amount) {
                    $pc=0;
                    $fc=0;
                    $nc=0;
                    $a=0;
                    $marker=0;
                    $netAmount=0;
                    // echo $model->studentresult->result;          Trans

                  if (@$model->studentplacement->result===0) {
                    $pc++;
                    $failCount+=$fc;
                    $a=(@$model->trans[2]->rateinfo->rate_amount*@$model->trans[2]->batch->jobs->net_hours)*(@$model->trans[2]->trans_percent/100);
                    // $a=0;
                    $amount+=$a;
                  }
                  else if (@$model->studentplacement->result==1) {
                      $pc++;
                      $passCount+=$pc;
                      $a=(@$model->trans[2]->rateinfo->rate_amount*@$model->trans[2]->batch->jobs->net_hours)*(@$model->trans[2]->trans_percent/100);
                      $amount+=$a;
                 }
                  else{
                        $nc++;
                        $ncount+=$nc;
                    
                  }
                  $marker=round(@$passCount*100/(($passCount+$failCount/1)?($passCount+$failCount):1),2);
                  if ($marker>=70) {
                    $netAmount =round(@$amount,2);
                  }else{
                    $netAmount = round(@$amount*$marker/100,2);

                  }
                  $widget1->footer = "<input type='hidden' value=".$netAmount." name='TotalAmount'>&#x20B9;".($netAmount) ."";
                
                  return round(@$a,2);
                 
                  
                },     
             
                // 'value'=>function($model){
                //     return (@$model->trans[0]->rateinfo->rate_amount*@$model->trans[0]->batch->jobs->net_hours)*0.30;
                //   },
                //   'footer'=>120,
            ], 
            // 'student_id',
            // 'created_at',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); 

    ?>