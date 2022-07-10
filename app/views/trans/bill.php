<?php
   use yii\helpers\Html;
   use yii\widgets\DetailView;
   use app\models\CommonModel;
   use kartik\select2\Select2;
   use yii\helpers\ArrayHelper;
   use app\models\BatchStudents;
   use app\models\search\BatchStudents as BatchStudentsSearch;
   /* @var $this yii\web\View */
   use yii\helpers\Url;
   
   /* @var $model app\models\TransDetail */
   use kartik\form\ActiveForm;
   use yii\grid\GridView;
   $status=[
       '1'=>"Yes",
       "2"=>"No"
   ];
   $bScount=BatchStudents::find()->where(['batch_id'=>$model->batch_id])->count();
   switch ($model->claim_type) {
       case 0:
       $sup="st";
           break;
          case 1:
       $sup="nd";
           break;
          case 2:
       $sup="rd";
           break;
       
       default:
       $sup="";

           break;
   }
   function AmountInWords(float $amount)
{
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $x < $count_length ) {
      $get_divider = ($x == 2) ? 10 : 100;
      $amount = floor($num % $get_divider);
      $num = floor($num / $get_divider);
      $x += $get_divider == 10 ? 1 : 2;
      if ($amount) {
       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
       $string [] = ($amount < 21) ? @$change_words[$amount].' '. @$here_digits[$counter]. @$add_plural.' 
       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
   else $string[] = null;
   }
   $implode_to_Rupees = implode('', array_reverse($string));
   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
   return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise ." Only ";
}
   $this->title = $model->batch->batch_name;
   $this->params['breadcrumbs'][] = ['label' => 'Tranche Details', 'url' => ['index']];
   $this->params['breadcrumbs'][] = $this->title;
   \yii\web\YiiAsset::register($this);
   ?>
   <style type="text/css">
   .tg  {border-collapse:collapse;border-spacing:0;}
   .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Ubuntu;
   overflow:hidden;padding:10px 5px;word-break:normal;}
   .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Ubuntu;
   font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
   .tg .border border-dark{text-align:left;vertical-align:top}
   .table-bordered > tbody > tr > th {
     border: 1px solid blue;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js" integrity="sha512-d5Jr3NflEZmFDdFHZtxeJtBzk0eB+kkRXWFQqEc1EKmolXjHm2IKCA7kTvXBNjIYzjXfD5XzIjaaErpkZHCkBg==" crossorigin="anonymous"></script>
<div class="trans-detail-view">
   <div class="card card-primary border-info">
      <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
         <h5><?= $this->title ?></h5>
      </div>
      <div class="card-body" >
       
         <div id="">
           

            <!-- Bill of Supply  -->
            <div class="row">
                <div class="col-12">
                <div class="text-right">
                
            <?= Html::a(Yii::t('app', '<i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print'), 'javascript:void(0)', ['class' => 'btn btn-primary','onclick'=>'printData()']) ?>
         </div>
       
         <div id="printarea">
       
  
            <table class="table  border border-dark" style=" width: 100%">
            <colgroup>
            <col style="">
            <col style="">
            <col style="">
            <col style="">
            <col style="">
            <col style="">
            </colgroup>
            <thead>
            <tr class=" border border-dark">
                <th class="border border-dark border border-dark " colspan="6">  
                <h2 class="text-uppercase text-center">Bill Of Supply </h2>
                    <h5  class="text-right font-weight-normal"> Invoice No. - <?= Yii::$app->config->get('invoice_pre','UK/IN/0/00') .$model->id; ?></h5>
                    <h5  class="text-right font-weight-normal"> Tranche Stage - <?= $model->claim_type+1 ."<sup>".$sup."</sup> (".$model->trans_percent. " %)" ?></h5>
            </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="border border-dark " colspan="6"><h4 class="" ><b><?=  $model->tc->parenttp->tp_name ."</b> - ".  $model->tc->parenttp->tpaddress->address_line ." - ". $model->tc->parenttp->tpaddress->city->city." - ". $model->tc->parenttp->tpaddress->city->state->name?></h4></td>
            </tr>
            <tr>
                <td class="border border-dark border border-dark"  colspan="6"><h4  class="font-weight-normal">To, <br> <br> Member Secretary <br> Uttarakhand Skill Development Society <br>26.E.C. Road, Near Survey Chowk <br> Dehradun, Uttarakhand, India Pin 248001</h4></td>
            </tr>
            <tr class="border border-dark">
                <td class="border border-dark" colspan="3"><h4 class="text-right font-weight-bold">Date</h4></td>
                <td class="border border-dark" colspan="3"><h4  class="font-weight-normal"><?= date('d F Y',strtotime($model->updated_at))?></h4></td>
            </tr>
            <tr class="border border-dark">
                <td class="border border-dark">
                <h4  class="font-weight-bold" > Bank Name </h4>
                </td>
                <td class="border border-dark">
                <h4 class="font-weight-normal"><?= $model->tcbank->bank_name?></h4>
                </td>
                <td class="border border-dark">

                <h4  class="font-weight-bold" > Account Number</h4>
                </td>
                <td class="border border-dark">
                <h4 class="font-weight-normal"><?= $model->tcbank->account_number?></h4>
                
                </td>
                <td class="border border-dark">
                <h4  class="font-weight-bold" >IFSC</h4>
                </td>
                <td class="border border-dark">
                <h4 class="font-weight-normal"><?= $model->tcbank->ifsc_code?></h4>
                    
                </td>
            </tr>
            <tr class="border border-dark">
                <td class="border border-dark">
                    <h4  class="font-weight-bold" >Training Centre</h4>
                </td>
                <td class="border border-dark">
                    <h4 class="font-weight-normal"><?=  $model->tc->name ?> <br>
                <?= $model->tc->tcaddress->address_line ." - ". $model->tc->tcaddress->trainingcenters->name ." Uttarakhand" ?>
                </h4>
                </td>
                <td class="border border-dark">
                    <h4  class="font-weight-bold" >Batch No.</h4>
                </td>
                <td class="border border-dark">
                    <h4 class="font-weight-normal"><?=  Yii::$app->config->get('batch-prefix','UK/SK/B00').$model->batch_id ?></h4>
                </td>
                <td class="border border-dark">
                    <h4  class="font-weight-bold" >Batch SIP ID</h4>
                </td>
                <td class="border border-dark">
                    <h4 class="font-weight-normal"><?=  $model->batch->sip_id ?></h4>
                </td>
            </tr>
            <tr>
                <td class="border border-dark">
                    <h4  class="font-weight-bold" >Job Role</h4>
                </td>
                <td class="border border-dark">
                    <h4 class="font-weight-normal"><?=  $model->batch->jobs->job_name . " (".$model->batch->jobs->qp_code .") " ?></h4>
                </td>
                <td class="border border-dark">
                    <h4  class="font-weight-bold" > Bill of Supply </h4>
                </td>
                <td class="border border-dark">
                    <h4 class="font-weight-normal"><?=  Yii::$app->params['bill_prefix'].$model->id ?></h4>
                </td>
                <td class="border border-dark">
                    <h4 class="font-weight-bold"> No of Student</h4>
                </td>
                <td class="border border-dark">
                    <h4 class="font-weight-normal"><?= $bScount ?></h4>
                </td>
            </tr>
            
            <tr>
                <td class="border border-dark"><h4  class="font-weight-bold" >S.No</h4></td>
                <td class="border border-dark" colspan="4"><h4  class="font-weight-bold" >Description</h4></td>
                <td class="border border-dark"><h4  class="font-weight-bold" ><?= CommonModel::getTransStage()[$model->claim_type] ?> Trans Amount</h4></td>
            </tr>
            <tr>
                <td class="border border-dark"><h4  class="font-weight-bold" >1. </h4></td>
                <td class="border border-dark" colspan="4"><h4 class="font-weight-normal"> Total Payable Amount (Subject to change as per terms And Condition).</h4></td>
                <td class="border border-dark"><h4 class="font-weight-normal"><?= $model->net_amount ?></h4></td>
            </tr>
            <tr>
                <td class="border border-dark"><h4  class="font-weight-bold" >2.</h4></td>
                <td class="border border-dark" colspan="4"><h4 class="font-weight-normal">TDS Deduction 10.00 %</h4></td>
                <td class="border border-dark"><h4 class="font-weight-normal">-<?= ($model->is_tds_deduct )? round($model->net_amount*0.1,2):0 ?></h4></td>
            </tr>
            <tr>
                <td class="border border-dark" colspan="5"><h4 class="text-right font-weight-bold">Net Payable</h4></td>
                <td class="border border-dark"><h4 class="font-weight-normal">&#x20B9; <?= ($model->is_tds_deduct)?round($model->net_amount-$model->net_amount*0.1,2): round($model->net_amount,2)?></h4></td>
            </tr>
            <tr>
                <td class="border border-dark" colspan="6"><h4 class="text-center"><?= AmountInWords(round($model->is_tds_deduct)?round($model->net_amount-$model->net_amount*0.1,0): round($model->net_amount,0)) ?></h4></td>
            </tr>
            </tbody>
            </table>
            </div>
                </div>          
            </div>
      </div>
   </div>
</div>
<?php
   $a= Url::base().'/'."custom/images/header.png";
   ?>
<script>

function printData(){
    $("#printarea").printThis({ 
        importCSS: true, 
        loadCSS: "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css",
        // header: '<img src="<?= $a?>" height="" alt="" srcset="">',
        footer: $('.hidden-print-header-content'),
        removeScripts: false, 
        pageTitle: "Bill_of_Supply",          
        copyTagClasses: true,      
    })
}
$("input[name='TransDetail[net_amount]']").val($("input[name=TotalAmount]").val());
</script>
