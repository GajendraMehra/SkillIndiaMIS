<?php
use yii\grid\GridView;
use app\models\CommonModel;

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
                'enableSorting' => false,
                'format'=>'html',
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
                'label'=>"Base Cost (In Rs.)",
                'enableSorting' => false,
                'value'=>function($model){
                    return round($model->trans[0]->rateinfo->rate_amount,2);
                  },
                  'footer'=>"<strong>Total</strong>",

            ], [
                'attribute' => 'student_id',
                'label'=>"Gross Payable Amount ",
                'enableSorting' => false,
                'value'=>function ($model, $key, $index, $widget) use (&$tptotal) {
                    $tpamount=$model->trans[0]->rateinfo->rate_amount*$model->trans[0]->batch->jobs->net_hours;
                    $tptotal +=$tpamount;
                    $widget->footer = "&#x20B9; ".$tptotal;
                    return $tpamount ;
                },     
              
            ], [
                'attribute' => 'student_id',
                'label'=>"First Tranche Amount (".$model->trans_percent ." %)",
                'enableSorting' => false,
                'value'=>function ($model, $key, $index, $widget) use (&$total) {
                    $famount=($model->trans[0]->rateinfo->rate_amount*$model->trans[0]->batch->jobs->net_hours)*($model->trans[0]->trans_percent/100);
                    $total +=$famount;
                    $widget->footer =  "&#x20B9; ".$total;
                    $widget->footer =  "<input type='hidden' value=".$total." name='TotalAmount'>&#x20B9;  ".($total) ."";
                    return $famount ;
                },       
                // 'value'=>function($model){
                //     return ($model->trans[0]->rateinfo->rate_amount*$model->trans[0]->batch->jobs->net_hours)*0.30;
                //   },
                //   'footer'=>120,
            ], 
            // 'student_id',
            // 'created_at',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>