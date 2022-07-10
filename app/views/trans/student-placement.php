<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use app\models\search\TargetsResponse as TargetsResponseSearch;
use app\models\TargetsResponse;
use app\models\Student;
use app\models\Sector;
use app\models\AttendanceLabel;
use app\models\search\Student as StudentsSearch;

/* @var $this yii\web\View */
/* @var $model app\models\TargetBatch */
use kartik\form\ActiveForm;

$this->title = "Placement Result";
$this->params['breadcrumbs'][] = ['label' => 'Target Batches', 'url' => ['index','type'=>3]];
$this->params['breadcrumbs'][] = ['label' => $model->batch_name, 'url' => ['view','id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
if ( $dataProvider->getTotalCount()==0) {
  echo "<h5>No Student Found<h5>";
} else {
  # code...

?>

<style>
  #progress-wrp {
  border: 1px solid #0099CC;
  padding: 1px;
  position: relative;
  height: 30px;
  border-radius: 3px;
  margin: 10px;
  text-align: left;
  background: #fff;
  box-shadow: inset 1px 3px 6px rgba(0, 0, 0, 0.12);
}

#progress-wrp .progress-bar {
  height: 100%;
  border-radius: 3px;
  background-color: #f39ac7;
  width: 0;
  box-shadow: inset 1px 1px 10px rgba(0, 0, 0, 0.11);
}

#progress-wrp .status {
  top: 3px;
  left: 50%;
  position: absolute;
  display: inline-block;
  color: #000000;
}
input:focus {
  background-color: yellow;
}
  </style>
<div class="row">
<div class="col-md-12">
<!-- <div id="progress-wrp">
    <div class="progress-bar"></div>
    <div class="status">0%</div>
</div> -->
</div>

</div>
<?php
$modifyButtons="";

?>
<p>File Size should be less than 1 Mb</p>
    <?php $form = ActiveForm::begin(['id'=>'attendanceform',
    'action'=>'index.php?r=trans/third-claim&id='.$model->id]); ?>
<!-- Student section -->
<?= GridView::widget([
'dataProvider'=> $dataProvider,
// 'filterModel' => $searchModel,

'columns' => [
    ['class' => '\kartik\grid\CheckboxColumn'],


    [
        'class' => 'yii\grid\SerialColumn',
        'contentOptions' => ['style' => 'width:10px; white-space: normal;'],

      ],
      'student_id',
    'ExpandRowColumn'=>
    [
      'class' =>'\kartik\grid\ExpandRowColumn',
      'value'=>function ($model, $key, $index,$column) {
                return GridView::ROW_COLLAPSED;
       },
       'detail'=>function($model){
        return $this->render('../batch/_list_item.php', [
            'model' => Student::findOne($model->student_id)
            // 'dataProvider' => $dataProvider,
        ]);
       }
    ],
    [
        'attribute'=>   'id',
      'label'=>"Student Name",
      'header' => false,
      'encodeLabel' => false,
        // 'contentOptions' => ['style' => 'display:none   '],

        'format'=>"html",
        'value'=>function($model){
          return  $model->student->student_name;
        }

    ],
    // [
    //    'attribute'=>   'id',
    //   'label'=>"HOPE ID",
    //   'header' => false,
    //   'encodeLabel' => false,
    //     // 'contentOptions' => ['style' => 'display:none   '],

    //     'format'=>"html",
    //     'value'=>function($model){
    //       return $model->student->hope_id;
    //     }

    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>"Placement Status",
        'dropdown' => false,
        'width'=>'20',

        'vAlign'=>'middle',
        'template' => '{status}{companyName}{salary}{upload}',
        'buttons' => [
          'status' => function($url, $model){
              return Html::activeDropDownList($model, 'student_id',['Not Placed','Placed',], ['prompt'=>'Placement Status','student_id'=>$model->student_id,'id'=>'attendance'.$model->id,'name'=>'result['.$model->student_id.']'] );
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
    [
      'class' => 'kartik\grid\ActionColumn',
      'header'=>"Placed Organisation ",
      'dropdown' => false,
      'width'=>'20',

      'vAlign'=>'middle',
      'template' => '{status}{companyName}{salary}{upload}',
      'buttons' => [
     
        'companyName' => function($url, $model){
          return Html::input('text','placed_organisation['.$model->student_id.']','', $options=['maxlength'=>20,'student_id'=>$model->student_id,'placeHolder'=>"Placed organisation Name",'class'=>"m-2"]);
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
  [
    'class' => 'kartik\grid\ActionColumn',
    'header'=>"Salary Details(per month)",
    'dropdown' => false,
    'width'=>'20',

    'vAlign'=>'middle',
    'template' => '{status}{companyName}{salary}{upload}',
    'buttons' => [
    
      'salary' => function($url, $model){
        return  Html::input('number','package_pm['.$model->student_id.']','', $options=['maxlength'=>10,'student_id'=>$model->student_id,'placeHolder'=>"Salary Per Month"]);
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
[
  'class' => 'kartik\grid\ActionColumn',
  'header'=>'Candidate Document (Appointment Letter)',
  'dropdown' => false,
  'width'=>'20',

  'vAlign'=>'middle',
  'template' => '{status}{companyName}{salary}{upload}',
  'buttons' => [
   
    'upload' => function($url, $model){
      return  ' <input type="file" name="file[]" student_id="'.$model->student_id.'" multiple class="uploadFile"/><br/>
      ';
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
  'heading'=>'<h5>'.$this->title.'</h5>',
  'before'=>'<select id="bulkselector" name="bulkselector"> <option value="0">Bulk Action</option> <option value="1">Placed all</option> <option value="2">Not Placed all</option> <option value="3">Placed Selected</option> <option value="4">Not Placed Selected</option> </select>',
  'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', 'javascript:void(0)', ['class' => 'btn btn-info btn-sm','onclick'=>'reset()']).'<div class="text-center">'.Html::submitButton(Yii::t('app', 'Final submit'), ['class' => 'btn btn-sm btn-success',]).'</div>',
],

]);
?>



<?php ActiveForm::end(); 
}
?>


<script type="text/javascript">

swal(`
* You can not apply for Reassesment 1 and Reassesment 2 Claim after this tranche .
* Please Proceed Carefully
* Student Appointment Letter is madatory to upload for placed students . 
* Missing Appointment letter may deduct your trans amount
`)
var package={};
  var placed_organisation={};
  var data={};
  var fileData={};
$("form[id=attendanceform]").submit(function(e){
 
  e.preventDefault()
   e.stopImmediatePropagation();

  var allAttendance = $("[name^=result]").map(function(){
    data[$(this).attr('student_id')]=this.value;
  }).get();
  console.log(data)


$('input[name^="package_pm"]' ).each(function() {
package[$(this).attr('student_id')]=this.value;
});

$('input[name^="placed_organisation"]' ).each(function() {
  placed_organisation[$(this).attr('student_id')]=this.value;
});
console.log(data);
console.log(package);
console.log(placed_organisation);
console.log(fileData);

if(Object.values(data).includes("")){
       toastr.error("Please mark all student placement");
   return 
}

for (const key in data) {
  if (Object.hasOwnProperty.call(data, key)) {
     const element=data[key];
  
       if(element==1){
      if(placed_organisation[key]==""){
        toastr.error("Please Fill Placed Organisation of Student ID "+key);
        $('input[name="placed_organisation['+key+']"]').focus();
        return 
        break;
      }
      if(package[key]==""){
        toastr.error("Please Fill Package Per Month of Student ID "+key);
        $('input[name="package_pm['+key+']"]').focus();

        return
        break;
      }  if(!fileData[key]){
        toastr.error("Please Upload File of Student ID "+key);
        // $('input[name="package['+key+']"]').focus();
        return
        break;
       
      }
       }
     

   
    
  }
}

console.log(confirmUser().then(data=>{
  if(data){
        e.currentTarget.submit();
  }
}))
});
function reset(){
  $("#bulkselector").val('0')
  $("[name^=result]").val("")
  $("[name^=package]").val("")
  $("[name^=placed_organisation]").val("")
  $("[name^=file]").val("")
  $('tr').removeAttr('class');
  $('tr').addClass('bg-white')
   fileData={};
  $("input[name='selection[]']").prop('checked', false)
  $("input[name='selection_all']").prop('checked', false)
  $('body').toggleClass('open');
  $('#right-panel').toggleClass('fullwidth');
}
reset()

$('input[type=checkbox]').change(function() {
      if($(this).is(":checked")) {
       $("#bulkselector").val('0')
}else{
    // $("#attendance"+$(this).val()).val("")
    // var item=$(this).val();
    // $("#attendance"+item).val("")

    // $("tr[data-key="+item/1+"]").removeAttr('class')
    //   $("tr[data-key="+item/1+"]").addClass('bg-white')
}

      })
$("[name=bulkselector]").on('change',function(e){


  var optionSelected = $("option:selected", this);
  var valueSelected = this.value/1;
  $('tr').removeAttr('class');
      $('tr').addClass('bg-white')
  switch (valueSelected) {
    case 1:
    // $('tr').removeAttr('class');
    // $('tr').addClass('bg-white')
    $("input[name='selection[]']").prop('checked', false)
    $("input[name='selection_all']").prop('checked', false)
    // $('tr').removeAttr('class');
    // $('tr').addClass('bg-white')
    var color='bg-white'
    $("[name^=result]").val(1)
    // $('tr').removeAttr('class');
    //   $('tr').addClass(color)

      break;
    case 2:
    // $('tr').removeAttr('class');
    // $('tr').addClass('bg-white')
    $("input[name='selection[]']").prop('checked', false)
    $("input[name='selection_all']").prop('checked', false)

    var color='table-danger'
    $("[name^=result]").val(0)
    $('tr').removeAttr('class');
      $('tr').addClass(color)
      break;
    case 3:
    var color='bg-white'

    // $("input[name='selection[]']").prop('checked', false)
    var checkedVal = $("input[name='selection[]']:checked").map(function(){
    return this.value; }).get();
    if (checkedVal.length==0) {
      $("#bulkselector").val('0')

      toastr.error("Please Select Student")
    }
    console.log(checkedVal);
  checkedVal.forEach((item, i) => {
    $("#attendance"+item).val(1)

      $("tr[data-key="+item/1+"]").removeAttr('class')
        $("tr[data-key="+item/1+"]").addClass(color)
  });

      break;
    case 4:
    var color='table-danger'


    var checkedVal = $("input[name='selection[]']:checked").map(function(){
    return this.value; }).get();
    console.log(checkedVal);
    if (checkedVal.length==0) {
      $("#bulkselector").val('0')

      toastr.error("Please Select Student")
    }
  checkedVal.forEach((item, i) => {
    $("#attendance"+item).val(0)

      $("tr[data-key="+item/1+"]").removeAttr('class')
        $("tr[data-key="+item/1+"]").addClass(color)
  });

      break;

    default:
    $("[name^=result]").val('')

    var color='bg-white'
    // $('tr').removeAttr('class');
    //   $('tr').addClass(color)
  }

  $('thead').find('tr').removeAttr('class');
    // $('tr').addClass('bg-white')
      $("input[name='selection[]']").prop('checked', false)
  $("input[name='selection_all']").prop('checked', false)
})
$("[name^=result]").on('change', function (e) {
  
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    switch (valueSelected) {

      case "0":
      var color='table-danger'
        break;

      default:
      var color='bg-white'

    }
    console.log(   $(this).parent().parent());
    $(this).parent().parent().removeAttr('class');
    $(this).parent().parent().addClass(color)
          $("input[name='selection[]']").prop('checked', false)
        $("input[name='selection_all']").prop('checked', false)
  
});


// upload file 

var Upload = function (file) {
    this.file = file;
};

Upload.prototype.getType = function() {
    return this.file.type;
};
Upload.prototype.getSize = function() {
    return this.file.size;
};
Upload.prototype.getName = function() {
    return this.file.name;
};
Upload.prototype.doUpload = function (student_id) {
  if(!student_id){
    return false;
  }
    var that = this;
    var formData = new FormData();

    // add assoc key values, this will be posts values
    formData.append("file", this.file, this.getName());
    formData.append("upload_file", true);
    formData.append("student_id", student_id);

   return $.ajax({
        type: "POST",
        url: "index.php?r=trans/upload-file",
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', that.progressHandling, false);
            }
            return myXhr;
        },
        success: function (data) {
          if(data.success){
          toastr.success("File Uploaded Successfully")
          console.log( $(this).parent().parent());

          $(this).parent().parent().removeAttr('class');
    $(this).parent().parent().addClass('table-success')
          }else{

            toastr.error(data.errors)
          }
            // your callback here
        },
        error: function (error) {
            // handle error
        },
        async: true,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 60000
    });
};

Upload.prototype.progressHandling = function (event) {
    var percent = 0;
    var position = event.loaded || event.position;
    var total = event.total;
    var progress_bar_id = "#progress-wrp";
    if (event.lengthComputable) {
        percent = Math.ceil(position / total * 100);
    }
    // update progressbars classes so it fits your code
    $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
    $(progress_bar_id + " .status").text(percent + "%");

 
};

$(".uploadFile").on("change", function (e) {
let student_id=$(this).attr('student_id');
    var file = $(this)[0].files[0];
    var upload = new Upload(file);
if(upload.getSize()>1024*1024){
  toastr.error("File Size should be less than 1 Mb")
  this.value=""
  return false;
}
    // maby check size or type here with upload.getSize() and upload.getType()
 

    // execute upload
   const res= upload.doUpload(student_id);
   console.log(res);
  //  console.log(res);
   console.log(res.then((data)=>{
     if(data.success){
      fileData[$(this).attr('student_id')]=1;
      $(this).parent().parent().removeAttr('class');
    $(this).parent().parent().addClass('table-success');
     }else{
      toastr.error("Please Reupload ")
      this.value=null;
      $(this).parent().parent().removeAttr('class');
    $(this).parent().parent().addClass('table-warning');
     }
   }));
});

function confirmUser(){
  
 return  swal("Are you sure you want to forward this result ? Please Review Carefully. Incorrect Information in the result may effect your Tranche ", {
        dangerMode: true,
        // className: "bg-primary",
  buttons: {

    yes: {
      text: "Yes",
      value: "yes",
    },
    cancel: "Cancel",
    // defeat: true,
  },
    })
.then((value) => {
  switch (value) {


    case "yes":
      return true;
    // e.currentTarget.submit();

      break;

    default:
      return false;
    //   swal("Got away safely!");
  }
});
}
</script>
