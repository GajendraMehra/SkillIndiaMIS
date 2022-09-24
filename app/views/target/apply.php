<?php
use unclead\multipleinput\MultipleInput;
use kartik\form\ActiveForm;
use app\models\Tcdetail;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use app\models\Sector;
use app\models\CommonModel;
use app\models\TargetJob;
use app\models\TargetDistrict;

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Apply Target');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Targets'), 'url' => ['assigned-index','filter'=>'all']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="targets-apply">

<div class="card card-primary border-info">
    <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
    <h5><?= $this->title ?></h5>
    </div>

    <div class="card-body">
    <div class="row">
    <div class="col-md-8">
    <?= DetailView::widget([
        'model' => $model1,
        'attributes' => [
            // 'id',

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

            // 'scheme.short_name',
            [
                'attribute'=>'tp.tp_name',
                'label'=>"Assigned Training Partner",
                'format'=>'html',
                // 'value'=>TpartnerDetail::findOne($model->tp_id)['tp_name']
            ],
          
            [
                'attribute'=>'status',
                'format'=>'html',
                'value'=>function($model){
                    return CommonModel::labelsStatus($model->status);
                  },
                ],
             [
                'attribute'=>'number',
                'label'=>"Targets ",
                'format'=>'html',
                'value'=>function($model){
                    return '<span class="total_targets">'.$model->number.'</span>';
                }
            ], [
                'attribute'=>'number',
                'label'=>"Remaining Targets ",
                'format'=>'html',
                'value'=>function($model){

                    return '<h3><span class="remaining_targets badge badge-success ">'.$model->number.'</span></h3>';
                }
            ],






        ],
    ]) ?>
    </div>
    <div class="col-md-4 text-center">
    <h3 class="text-primary mb-2">Workorder</h3>
   
    <h5 class="mt-2 mb-2">  
        <?=  Html::a(Yii::t('app', 'Download'), 'index.php?r=site/getfile&name='.$model1->work_order_file, ['class' => 'btn btn-primary']);  ?>
  
    </div>
    </div>


<div class="card card-info border-info">
    <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
    <h5>Assign Centers  </h5>
    </div>

    <div class="card-body">
 <!-- <h4 class="badge badge-success mb-2">A </h4> -->

    <?php
     $tpdetails=CommonModel::getTpdetailbyuserid();
$tcenters=ArrayHelper::map(Tcdetail::find()->where(['tp_id'=>$tpdetails['id']])->all(), 'id', 'name');
$tcenters[0]="-----Select Training Center----";
$jobs=ArrayHelper::map(TargetJob::find()
->select('tbl_jobs.*')
->innerJoin('tbl_jobs','tbl_target_job.job_id=tbl_jobs.id')
->where(['target_id'=>$model1->id])->asArray()->all(), 'id', 'job_name');

$districts=ArrayHelper::map(TargetDistrict::find()
->select('districts.*')
->innerJoin('districts','tbl_target_district.district_id=districts.id')
->where(['target_id'=>$model1->id])->asArray()->all(), 'id', 'name');
$districts[0]="-----Select District ----";
$jobs[0]="-----Select Job----";
// echo "<pre>";
// print_r((sizeof($jobs)-1)*(sizeof($districts)-1)*(sizeof($tcenters)-1));
$form = ActiveForm::begin(['id' => 'target-response',]);
echo $form->field($model, 'target_response')->widget(MultipleInput::className(), [
//    'max' => sizeof($jobs)-1*sizeof($districts)-1*sizeof($tcenters)-1,
   // 'theme'=>'bs',

   'addButtonPosition' => MultipleInput::POS_FOOTER,
   'addButtonOptions'=>[
       'label'=>'<i class="fa fa-plus mr-1"></i>Add More',
       'class'=>"btn btn-info"
   ],'removeButtonOptions'=>[
       'label'=>'<i class="fa fa-times mr-1"></i>Remove',
       'class'=>"btn btn-danger"
   ],
   'columns' => [
       [
           'name'  => 'tc_id',
           'type'  => 'dropDownList',
           'title' => 'Training Center',
           'enableError' => true,
           'defaultValue' => 0,
           'items' =>  $tcenters,
           'options' => [

            'class' => 'input-center',
            'required'=>'required',
            // 'placeholder'=>'dfs',
            'onchange' => 'checkduplicate(this)',
        ]
       ],
       [
           'name'  => 'district_id',
           'type'  => 'dropDownList',
           'title' => 'Select District ',
           'enableError' => true,
           'defaultValue' => 0,
           'items' =>  $districts,
           'options' => [
            'class' => 'input-district',
            'required'=>'required',
            'onchange' => 'checkduplicate(this)',
        ]
       ],
       [
           'name'  => 'job_id',
           'type'  => 'dropDownList',
           'title' => 'Select Job',
           'enableError' => true,
           'defaultValue' => 0,
           'items' =>  $jobs,
           'options' => [
            'class' => 'input-job',
            'required'=>'required',
            'onchange' => 'checkduplicate(this)',
        ]
       ],
      

       [
           'name'  => 'response_number',
           'title' => 'Target',
           'enableError' => true,
           'options' => [
               'class' => 'input-response_number',
               'required'=>'required',
               'type'=>'text',
               'maxlength' => 5,
               'onkeypress'=>'return onlyNumberKey(event)',
               'onkeyup'=>'return validatertarget(this)',
            //    'max'=>7
           ]
       ]
   ]
])->label(false);
//
echo Html::hiddenInput('TargetsResponse[target_id]', $model1->id);
?>
<div class="text-center">
<?= Html::a('Cancel', ['/target/assigned-index','filter'=>'apply'], ['class'=>'btn btn-info grid-button']) ?>

<?= Html::submitButton('Send for Approval', ['class' => 'btn btn-success','onclick'=>'']);?>
<?php ActiveForm::end();?>
</div>
    </div>
</div>
</div>
</div>

</div>
<script>
   function checkduplicate(params="") {


$(".input-district option[value='0']").attr('disabled', true);
$(".input-job option[value='0']").attr('disabled', true);
$(".input-center option[value='0']").attr('disabled', true);


       var flag=true;
       var isNull=false;
       console.log("fds");
       var jobs=[];
       var centers=[];
       var districts=[];
    $(".input-district").each(function() {

        if (!$(this).val()) { flag= false;isNull=true;}
        districts.push($(this).val())

    });

    $(".input-center").each(function() {
        if (!$(this).val()) { flag= false;isNull=true;}

        centers.push($(this).val())

    });
    $(".input-job").each(function() {
        if (!$(this).val()) { flag= false;isNull=true;}


        jobs.push($(this).val())



    //
    });
    if (isNull&&!params) {
        swal({
            title:'Missing Info',
            text:'Select all fields'
        })
    }

    var comb=[];
    centers.forEach((element,index )=> {
        comb.push(centers[index]+"|"+districts[index]+"|"+jobs[index])
    });
console.log(centers);
if(!((centers.some(function (value) { return value=="0"  }))
   ||(districts.some(function (value) { return value=="0"  }))
   ||(jobs.some(function (value) { return value=="0"  })))
){
    console.log(checkIfDuplicateExists(comb));

    if ((checkIfDuplicateExists(comb))){

        flag=false;
        swal({
            title:'Duplicate ',
            text:'Duplicate Entry '
        })
        // $(".input-district").val("0");
    }
}
   return flag;

}



function checkIfDuplicateExists(w){
    return new Set(w).size !== w.length
}
$( "#target-response" ).submit(function( event ) {
//   alert( "Handler for .submit() called." );
  event.preventDefault();

if(checkduplicate()){
swal({
         title: "Are you sure?",
            text: "Once Submitted, you will not be able to modify targets to your centers .",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
           event.currentTarget.submit();

            } else {
                // event.preventDefault();

            }
            });
}
});


function validatertarget(param) {
   if (param.value==0) {
    param.value=''
       return false

   }
var total=0;
var remaining=$('.total_targets').text();
    $(".input-response_number").each(function() {
        total+=($(this).val())/1;
});
console.log(total);
if (total>remaining/1) {
    swal({
        title:'Total Target Exceed'
    })
    $('.remaining_targets').text(remaining-total+param.value/1)
    param.value=''

    // return false

}else{
    $('.remaining_targets').text(remaining-total)
}
    // console.log();
    // alert()
}
toastr.success($('.remaining_targets').text() ," Remaing Targets ")
$('.multiple-input').on('afterInit', function(){
    console.log('calls on after initialization event');
}).on('beforeAddRow', function(e, row, currentIndex) {
    console.log(e);
    console.log(currentIndex);
   var flag=true;
         $(".input-response_number").each(function() {

       if ($(this).val()=="") {
        swal({
            title:'Missing Info',
            text:'Before adding more, Add target number first '
        })
        flag=false;
        // return false

       }
});
 $(".input-center").each(function() {
     console.log($(this).val());
       if ($(this).val()==0||$(this).val()==null) {
        swal({
            title:'Missing Info',
            text:'Before adding more, Select Training Center  first '
        })
        flag=false;
        // return false

       }
}); $(".input-job").each(function() {
     console.log($(this).val());
       if ($(this).val()==0||$(this).val()==null) {
        swal({
            title:'Missing Info',
            text:'Before adding more, Select Job first '
        })
        flag=false;
        // return false

       }
}); $(".input-district").each(function() {
     console.log($(this).val());
       if ($(this).val()==0||$(this).val()==null) {
        swal({
            title:'Missing Info',
            text:'Before adding more, Select District  first '
        })
        flag=false;
        // return false

       }
});


    if ($('.remaining_targets').text()/1==0) {
        swal({
            title:'Total Target Exceed.',
            text:'Can not add more'
        })

        flag=false;
    }
   return flag
    console.log('calls on before add row event');
}).on('afterAddRow', function(e, row, currentIndex) {
//     $('select[name^=Targets').each(function() {
//         $(`#targets-target_response-${currentIndex}-tc_id option[value=${$(this).val()}]`).attr('disabled','disabled')

// });

    console.log('calls on after add row event');
}).on('beforeDeleteRow', function(e, row, currentIndex){
    // row - HTML container of the current row for removal.
    // For TableRenderer it is tr.multiple-input-list__item
    console.log('calls on before remove row event.');
    return confirm('Are you sure you want to delete row?')
}).on('afterDeleteRow', function(e, row, currentIndex){
var total=0;

    var remaining=$('.total_targets').text();
    $(".input-response_number").each(function() {
        total+=($(this).val())/1;
});
$('.remaining_targets').text(remaining-total)

    console.log(row);
}).on('afterDropRow', function(e, item){
    console.log('calls on after drop row', item);
});

</script>
