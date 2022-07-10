<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;

use app\models\search\TargetsResponse as TargetsResponseSearch;
use app\models\TargetsResponse;
use app\models\Student;
use app\models\TargetBatch;
use app\models\Sector;
use app\models\search\Student as StudentsSearch;

/* @var $this yii\web\View */
/* @var $model app\models\TargetBatch */
$this->title = $model->batch_name . " Attendance";
$this->params['breadcrumbs'][] = ['label' => 'Running Batches', 'url' => ['index','type'=>1]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
use kartik\form\ActiveForm;

?>
<style media="screen">

.modal-content {
 ;
  /* margin: 30px auto; */
}
</style>
<div class="target-batch-view">


  <div class="card card-primary border-info">
          <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
          <h5><?= $this->title ?></h5>
          </div>
        <div class="card-body">

          <div class="row">
            <div class="col-md-6">



              <?= DetailView::widget([
                  'model' => $model,
                  'attributes' => [
                      // 'id',
                      'batch_name',
                      'jobs.job_name',
                      [
                          // 'attribute'=>'jobs.job_name',
                          'label'=>"Associate Sub Sector",
                          'format'=>'html',
                          'value'=>function($model){
                            return $model->subSector->sub_sector_name;
                          }
                      ],
                      [
                          'attribute'=>'jobs.job_name',
                          'label'=>"Total Duration",
                          'format'=>'html',
                          'value'=>function($model){
                            return $model->jobs->net_hours ." Hours";
                          }
                      ],
                      [
                          'attribute'=>'training_type',
                          // 'label'=>"Assigned Training Partner",
                          'format'=>'html',
                          'value'=>function($model){
                            return $model->trainingType->type_name;
                          }
                      ],
                      [
                          'attribute'=> 'start_date',
                           'label'=>"Batch Status",

                      

                          'format'=>'html',
                          'value'=>function($model){

                            if (new DateTime(date('Y-m-d')) <=new DateTime($model->end_date)&&new DateTime(date('Y-m-d')) >= new DateTime($model->start_date)) {
                             return '<span class="badge badge-success"> Running </span>';

                             }elseif(new DateTime(date('Y-m-d')) < new DateTime($model->start_date)){
                             return '<span class="badge badge-warning">Upcoming</span>';


                             }else{
                               return '<span class="badge badge-danger">Passed</span>';

                             }
                          }

                      ],
                      'min_size',
                      'max_size',
                      [
                          'attribute'=>'start_date',
                          // 'label'=>"Assigned Training Partner",
                          'format'=>'html',
                          'value'=>date('d F Y',strtotime($model->start_date))
                      ],
                      [
                          'attribute'=>'end_date',
                          // 'label'=>"Assigned Training Partner",
                          'format'=>'html',
                          'value'=>date('d F Y',strtotime($model->end_date))
                      ],
                      [
                          'attribute'=>'start_time',
                          // 'label'=>"Assigned Training Partner",
                          'format'=>'html',
                          'value'=>date('h:i A',strtotime($model->start_time))
                      ],
                      [
                          'attribute'=>'end_time',
                          // 'label'=>"Assigned Training Partner",
                          'format'=>'html',
                          'value'=>date('h:i A',strtotime($model->end_time))
                      ],
                      [
                          'attribute'=>  'assesment_date',
                          // 'label'=>"Assigned Training Partner",
                          'format'=>'html',
                          'value'=>date('d F Y',strtotime($model->assesment_date))
                      ],

                      'trainer_name',
                      [
                          'attribute'=>'created_at',
                          // 'label'=>"Assigned Training Partner",
                          'format'=>'html',
                          'value'=>date('d F Y',strtotime($model->created_at)) ." at ".date('h:i:s A',strtotime($model->created_at))
                      ],
                      [
                          'attribute'=>  'updated_at',
                          // 'label'=>"Assigned Training Partner",
                          'format'=>'html',
                          'value'=>date('d F Y',strtotime($model->updated_at)) ." at ".date('h:i:s A',strtotime($model->updated_at))
                      ],
                      [
                          'attribute'=>  'editedBy.username',
                          'label'=>"Created By",
                          'format'=>'html',
                          // 'value'=>
                      ],
                  ],
              ]) ?>
            </div>

            <div class="col-md-6">
              <!-- Student Information Goes here  -->

              <?php
              $modifyButtons='';
              if (!$model->final_submit) {
              $modifyButtons=Html::a('<i class="fa fa-plus"></i> Add New Student ', 'javascript:void(0)', ['class' => 'btn btn-success btn-sm','id'=>"add-new-student",'']) .'&nbsp&nbsp'.Html::button('<i class="fa fa-trash"></i> Remove Selected ',  ['class' => 'btn btn-danger btn-sm','id'=>'delete-all','data-attrib-name'=>'batch']);
            }else{
              $modifyButtons=Html::a('<i class="fa fa-plus"></i>Mark Attendance ', ['mark-attendance','id'=>$model->id], ['class' => 'btn btn-success btn-sm','id'=>"mark-attendance"]);

            }
              ?>
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
                        return Student::findOne($model->student_id)->student_name;
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
                        return $model->student->sip_id;
                      }

                  ],

                  [
                      'class' => 'kartik\grid\ActionColumn',
                      'dropdown' => false,
                      'width'=>'20',
                      'header'=>  (!TargetBatch::findOne($_GET['id'])->final_submit) ? "Action" : false,                   'vAlign'=>'middle',
                      'template' => '{delete}',
                      'buttons' => [
                        'delete' => function($url, $model){
                          if (!TargetBatch::findOne($model->batch_id)->final_submit) {
                            return Html::a('Remove', ['removestudent', 'id' => $model->id,'batchId' => $model->batch_id], [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => 'Are you absolutely sure ? You will lose all the related information  with this action.',
                                    'method' => 'post',
                                    'class' => 'danger'
                                ],
                            ]);
                          }
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
                'heading'=>'<h5>Students </h5>',
                'before'=>$modifyButtons,
              //   'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['index'], ['class' => 'btn btn-info btn-sm']),
              ],

              ]);
              ?>
            </div>
          </div>

  </div>
</div>




<div class="modal fade bd-example-modal-lg" tabindex="-1" role="document" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header bg-info text-white">
    <h5 class="modal-title" id="exampleModalLongTitle">Select Students</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php $form = ActiveForm::begin(); ?>


<div class="modal-body ">

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <?= Html::a('Add Selected', ['view','id'=>$_GET['id']], [
           'class' => 'btn btn-success',
           // 'disabled'=>'disabled',
           'data' => [
               // 'confirm' => 'Are you sure you want to add Students?',
               'method' => 'post',
           ],
       ]) ?>
    <!-- <button type="submitt"  class="btn btn-primary">Add Selected </button> -->
</div>
<?php ActiveForm::end(); ?>


</div>
</div>
</div>

</div>



<script type="text/javascript">
$('#add-new-student').on('click',function(){
// alert()
$('.bd-example-modal-lg').modal({show:true});

    $('.modal-body').load('index.php?r=batch%2Fadd-student&bid=<?= $_GET['id']?>',function(){
    });
});

$("#selectall").click(function(){
    $('input[name="selectedStudents[]"]').not(this).prop('checked', this.checked);
});
</script>
