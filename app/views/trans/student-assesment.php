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

$this->title = "Today's Attendance";
$this->params['breadcrumbs'][] = ['label' => 'Target Batches', 'url' => ['index','type'=>3]];
$this->params['breadcrumbs'][] = ['label' => $model->batch_name, 'url' => ['view','id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


?>

<?php
$modifyButtons="";
if( $dataProvider->getTotalCount()==0){
  echo "<h5>No Student Found</h5>"
  die;
}
?>
    <?php $form = ActiveForm::begin(['id'=>'attendanceform']); ?>
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
    [
       'attribute'=>   'id',
      'label'=>"SIP ID",
      'header' => false,
      'encodeLabel' => false,
        // 'contentOptions' => ['style' => 'display:none   '],

        'format'=>"html",
        'value'=>function($model){
          return @$model->student->sip_id;
        }

    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'width'=>'20',

        'vAlign'=>'middle',
        'template' => '{status}',
        'buttons' => [
          'status' => function($url, $model){
              return Html::activeDropDownList($model, 'student_id',  ArrayHelper::map(AttendanceLabel::find()->all(), 'id', 'label_name'), ['prompt'=>'Attendance Status','id'=>'attendance'.$model->id,'name'=>'attendance['.$model->student_id.']'] );
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
       // ]
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
  'before'=>'<select id="bulkselector" name="bulkselector"> <option value="0">Bulk Action</option> <option value="1">Present all</option> <option value="2">Absent All</option> <option value="3">Present Selected</option> <option value="4">Absent Selected</option> </select>',
  'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', 'javascript:void(0)', ['class' => 'btn btn-info btn-sm','onclick'=>'reset()']).'<div class="text-center">'.Html::submitButton(Yii::t('app', 'Final submit'), ['class' => 'btn btn-sm btn-success',]).'</div>',
],

]);
?>



<?php ActiveForm::end(); ?>


<script type="text/javascript">


$("form[id=attendanceform]").submit(function(e){
  e.preventDefault()
   e.stopImmediatePropagation();
 var data=[];
  var allAttendance = $("[name^=attendance]").map(function(){
    data.push(this.value)
  }).get();
  console.log(data);
  if (data.indexOf("")>=0) {

    toastr.error("Please Mark All Student Attendance")

  }else{
    swal("Are you sure you want to save the attendance ? Please Review Carefully. Once Submitted can not be changed in future ", {
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
    e.currentTarget.submit();

      break;

    default:
    //   swal("Got away safely!");
  }
});

  }

});
function reset(){
  $("#bulkselector").val('0')
  $("[name^=attendance]").val("")
  $('tr').removeAttr('class');
  $('tr').addClass('bg-white')
  $("input[name='selection[]']").prop('checked', false)
  $("input[name='selection_all']").prop('checked', false)
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
  switch (valueSelected) {
    case 1:
    $('tr').removeAttr('class');
    $('tr').addClass('bg-white')
    $("input[name='selection[]']").prop('checked', false)
    $("input[name='selection_all']").prop('checked', false)
    $('tr').removeAttr('class');
    $('tr').addClass('bg-white')
    var color='table-success'
    $("[name^=attendance]").val(1)
    $('tr').removeAttr('class');
      $('tr').addClass(color)

      break;
    case 2:
    $('tr').removeAttr('class');
    $('tr').addClass('bg-white')
    $("input[name='selection[]']").prop('checked', false)
    $("input[name='selection_all']").prop('checked', false)

    var color='table-danger'
    $("[name^=attendance]").val(2)
    $('tr').removeAttr('class');
      $('tr').addClass(color)
      break;
    case 3:
    var color='table-success'

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
    $("#attendance"+item/1).val(2)

      $("tr[data-key="+item/1+"]").removeAttr('class')
        $("tr[data-key="+item/1+"]").addClass(color)
  });

      break;

    default:
    $("[name^=attendance]").val('')

    var color='bg-white'
    $('tr').removeAttr('class');
      $('tr').addClass(color)
  }

  $('thead').find('tr').removeAttr('class');
    $('tr').addClass('bg-white')
      $("input[name='selection[]']").prop('checked', false)
  $("input[name='selection_all']").prop('checked', false)
})
$("[name^=attendance]").on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value/1;

    switch (valueSelected) {
      case 1:
      var color='table-success'
        break;
      case 2:
      var color='table-danger'

        break;
      case 3:
      var color='table-warning'


        break;

      default:
      var color='bg-white'

    }

    $(this).parent().parent().removeAttr('class');
    $(this).parent().parent().addClass(color)
          $("input[name='selection[]']").prop('checked', false)
  $("input[name='selection_all']").prop('checked', false)
});
</script>
