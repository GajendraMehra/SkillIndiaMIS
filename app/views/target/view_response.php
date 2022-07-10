<?php
use unclead\multipleinput\MultipleInput;
use kartik\form\ActiveForm;
use app\models\Tcdetail;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use app\models\Sector;
use app\models\TargetsResponse;
use kartik\grid\GridView;
use kartik\widgets\FileInput;
use yii\helpers\Url;

use yii\helpers\Html;
// use yii\helpers\Url;
use app\models\search\TargetsResponse as TargetsResponseSearch;

use kartik\dialog\Dialog;
use yii\web\JsExpression;

$this->title = "Acknowledgement";

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Targets'), 'url' => ['index','filter'=>'all']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app',  Yii::$app->params['target_prefix'].$model1->id), 'url' => ['view','id'=>$model1->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
.see-detail{
    cursor:pointer;
}
.swal-overlay {
  background-color: rgba(43, 165, 137, 0.45);
}
</style>
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
                'attribute'=>  'work_order_file',
                'label'=>"Work Order ",
                'format'=>'html',
                'value'=>function($model){
                    return '<a class="btn btn-sm btn-warning" href="'.Yii::getAlias('@web/').$model->work_order_file.'" target="_blank" download>View WorkOrder</a>';
                }
            ],
             [
                'attribute'=>'number',
                'label'=>"Total Targets ",
                'format'=>'html',
                'value'=>function($model){
                    return '<span class="total_targets">'.$model->number.'</span>';
                }
            ]
            ,[
                'attribute'=>'id',
                'label'=>"Remaining Target",
                'value'=>function($model){
                    $response=TargetsResponse::find()->where(['target_id'=>$model->id])->andWhere(['!=', 'status', 2])->sum('response_number');
                    $per=(($model->number-$response)/$model->number)*100;
                    return $model->number-$response .' ('.round($per,2) .'%)';
                }
            ],
           
            
          
           
        ],
    ]) ?>
    </div>
    <div class="col-md-4 text-center">
    <h3 class="text-primary mb-2">Workorder</h3>

   
    <h5 class="mt-2 mb-2">  <a class="text-primary" href="<?php echo Yii::getAlias('@web/').$model1->work_order_file ?>" target="_blank" download> Download Here</a></h5>
    
    </div>
    </div>
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Training Center Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body ">

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Send message</button> -->
    </div>
  </div>
  </div>    
</div>



<div class="modal fade " id="centerModal" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Training Center Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body " id="centerModalBody">

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Send message</button> -->
    </div>
  </div>
  </div>    
</div>



<div class="modal fade approve-modal" id="decesionModal" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLongTitle">LOR File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body " id="decesionModalBody">
<?php
    $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data','id'=>'upload-form']]); //important
    echo  $form->field($model, 'file')->widget(FileInput::classname(), [
      'name'=>'imageFile',
      'options' => ['accept' => ['image/*','/pdf','required'=>true]],
      'pluginOptions'=>['allowedFileExtensions'=>['jpg','jpeg','png','pdf'],'showUpload' => false,
      
      'showCaption' => false,
      'showRemove' => true,
      'showUpload' => false,
      'showCancel' => false,
      'browseClass' => 'btn btn-primary',
      //  'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
      'browseLabel' =>  'Select LOR file'
      ],
    ])->label("Upload LOR File ");?>


    </div>

    <div class="modal-footer">
    <div class="spinner-border " role="status">
      <span class="sr-only">Loading...</span>
    </div>
    <?php echo Html::submitButton('Approve', ['class'=>'btn btn-primary upload-file','id'=>'approveBtn']);?>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <?php ActiveForm::end();?>
    </div>
  </div>
  </div>    
</div>
    <?= GridView::widget([
    'dataProvider'=> $dataProvider,
    // 'filterModel' => $searchModel,
   
    'columns' => [
        // ['class' => '\kartik\grid\CheckboxColumn'],

     
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
            $searchModel = new TargetsResponseSearch(['target_id'=>$model->target_id,'tc_id'=>$model->tc_id]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
            return $this->render('_expandrcenterresponse.php', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
           }
        ], 
        [
            'attribute'=>   'center.id',
          'label'=>"Center ID",
          'header' => false,
          'encodeLabel' => false,
            // 'contentOptions' => ['style' => 'display:none   '],

            'format'=>"html",
           
        ], 
            [
                'attribute'=>   'center.name',
                'label'=>"Center Name",
                'format'=>"html",
                'value'=>function($model){
                    
                    return '<input type="hidden" name="centerid" value="'.$model->center->id.'"><a style="cursor:pointer" class="text-primary see-detail" data-id="2" href="javascript:void(0);">'.$model->center->name.'</a>';
                }
            ], 
           
            'center.smart_tcid',
          
            [
               
              'label'=>"Action",
              'filter'=>false,
              'format'=>'html',
              'value'=>function($model){
                  
                  if (TargetsResponse::find()->where(['target_id'=>$model->target_id,'tc_id'=>$model->center->id,'status'=>0])->all()) {
                      return '<a href="javascript:void(0);" id='.$model->id.' class="btn btn-sm btn-success approve"><span class="fa fa-check-square"></span> Approve</a> <a href="javascript:void(0);" class="btn btn-sm btn-danger ml-3 dis-approve"><span class="fa fa-window-close"></span> Decline</a>';
                      # code...
                  }else{
                      return "<span class='badge badge-info'>No Action Required </span>";
                  }
              }
          ]
    ],
    'toolbar' => [
       
        '{export}',
        '{toggleData}'
    ],
    'toggleDataContainer' => ['class' => 'btn-group-sm'],
    'exportContainer' => ['class' => 'btn-group-sm'],
    'panel' => [
        'type'=> Yii::$app->config->get('panel-theme','primary'),
      'heading'=>'<h5>Training Centers </h5>',
    //   'before'=>Html::a('<i class="fa fa-plus"></i> Create ', ['create'], ['class' => 'btn btn-success btn-sm']) .'&nbsp&nbsp'.Html::button('<i class="fa fa-trash"></i> Delete Selected ',  ['class' => 'btn btn-danger btn-sm','id'=>'delete-all','data-attrib-name'=>'target']),
    //   'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['index'], ['class' => 'btn btn-info btn-sm']),
    ],
   
]);
   ?>


</div>
</div>

</div>

<script>
var id ;
var ids;
$('.spinner-border').hide()

$('.upload-file').click(function(e){
  $('.spinner-border').show()
  $('#approveBtn').attr('disabled', true);
  e.preventDefault();
    var formData = new FormData($('#upload-form')[0]);
    console.log(formData);
    $.ajax({
        url: "index.php?r=target%2Fupload",  //Server script to process data
        type: 'POST',

        // Form data
        data: formData,

        // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(response) {
          $('.spinner-border').hide()
          if (response.code) {
          
                setStatus(id,ids,1,response.name)
          }else{
            swal(response.message)
          }
            console.log(response);
        },

        error: function(){
          $('.spinner-border').hide()

            alert('ERROR ');
        },

        complete: function(){
          $('#approveBtn').attr('disabled', false);
          $('.spinner-border').hide()

          
        },


        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
    });
});
$('.see-detail').on('click',function(){
   
    $('#centerModal').modal({show:true});
    var id = $(this).parent().parent().attr('data-key');
    console.log(id);
  //  $('.modal-body').text('Loading...')

    $('#centerModalBody').load('index.php?r=target%2Fcenter-view&id='+id,function(){
    });
});
$('.approve').on('click',function(){
     id = $(this).parent().parent().attr('data-key');
     id = $(`tr[data-key=${id}]`).children('td').eq(2).text();
     ids=$('input[name="selection[]"]').map(function() {
			if(this.checked){
      return this.value;
        
      }
    }).get()
    console.log(id);
    console.log(ids.length);
    if (ids.length==0) {
       
        swal("Please Select job first");
    }else{
    console.log(ids);
    var dataURL = $(this).attr('data-href');
    swal("Are you sure you want to approve selected jobs.", {
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
      $('.approve-modal').modal('show')
      break;
 
    default:
    //   swal("Got away safely!");
  }
});
    }
});
$('.dis-approve').on('click',function(){
     id = $(this).parent().parent().attr('data-key');
     id = $(`tr[data-key=${id}]`).children('td').eq(2).text();
     ids=$('input[name="selection[]"]').map(function() {
			if(this.checked){
      return this.value;
        
      }
    }).get()
    console.log(id);
    console.log(ids.length);
    if (ids.length==0) {
       
        swal("Please Select job first");
    }else{
    console.log(ids);
    var dataURL = $(this).attr('data-href');
    swal("Are you sure you want to decline this job.", {
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
        swal("Reason to Decline ", {
             content: "input",
        })
        .then((value) => {
            if (value) {
              var d = new Date();
              var n = d.getTime()/1000;
                setStatus(id,ids,2,n+'|'+value)
            }else{

                swal("Canceled (No action taken due to  reason missing.)",{
                   
                });
            }
        });
      break;
 
    default:
    //   swal("Got away safely!");
  }
});
    }
});

function setStatus(centerId,ids,status,actionId="") {
  $('.spinner-border').show()
  $('#approveBtn').attr('disabled', true);
    // var qID = $(this).attr('questionId');
 $.ajax({
     type: "POST",
     url: "index.php?r=target%2Fset-status", //Your required php page
     data: {
         centerId:centerId,
         responseId:ids,
         status:status,
         actionId:actionId
     }, //pass your required data here
     success: function (response) { //You obtain the response that you echo from your controller
       if(response.code){
        $('.spinner-border').hide()
        location.reload(); 
       }

     },
     error: function () {
         alert("Failed to get the members");
         $('.spinner-border').hide()
     },
     complete: function () {
      $('#approveBtn').attr('disabled', false);
         $('.spinner-border').hide()
     }
 });
}


</script>
