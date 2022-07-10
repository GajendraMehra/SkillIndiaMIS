<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\grid\GridView;

use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Sector;
use app\models\CommonModel;
use app\models\Job;
use app\models\TpartnerDetail;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TargetsResponse */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = Yii::t('app', 'Acknowledged Targets');
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="targets-response-index">


    <?= GridView::widget([
    'dataProvider'=> $dataProvider,
    // 'filterModel' => $searchModel,

    'columns' => [
        // ['class' => '\kartik\grid\CheckboxColumn'],
        ['class' => '\kartik\grid\CheckboxColumn',
        'checkboxOptions' => function($model) {
          if($model->status!=0){
             return ['disabled' => true];
          }else{
             return [];
          }
       },
      ],

        // [

        //     'filter'=>false,
        //     'label'=>"Target ID",
        //       'contentOptions' => ['style' => 'width:10%'],

        //     'format'=>'html',
        //     'value'=>function($model){
        //         return Yii::$app->params['target_prefix'].$model->target_id;
        //     }
        // ],


          [
              'attribute'=>  'job.job_name',
              'label'=>"Job",
          ],
          [
              'attribute'=>  'job.qp_code',
              'label'=>"QP CODE",
          ],
        //   [
        //     // 'attribute'=>'jobs.job_name',
        //     'label'=>"Associate Sub Sector",
        //     'format'=>'html',
        //     'value'=>function($model){
        //       return $model->subSector->sub_sector_name;
        //     }
        // ],
          [
              'attribute'=> 'district.name',
              'label'=>"District",
          ],
          [

            'label'=>"Approved",
            "format"=>"html",
            'value'=> function ($model, $key, $index, $grid){
              return CommonModel::labelsApprovedstatus($model->status);
              },
        ], [

            'label'=>"Target",
            "format"=>"html",
            'value'=> function ($model, $key, $index, $grid){
              return $model->response_number;
              },
        ],
        [

          'label'=>"Responded At",
          "format"=>"html",
          'value'=> function ($model, $key, $index, $grid){
            return $model->created_at;
            },
      ],
        [

          'label'=>"LOR/Remark",
          "format"=>"html",
          'value'=> function ($model, $key, $index, $grid){
            if ($model->status==1) {
              return Html::a('View LOR', Url::base('http').'/'.$model->action_id, ['class'=>'btn btn-primary btn-sm','target'=>'_blank']);

            }elseif ($model->status==2) {
              $message=explode('|',$model->action_id);
              if (sizeof($message)>1) {
              return $message[1];
              }

                return $message[0];
            }else{
              return'<span class="badge badge-warning">Action Required</span>';

            }

            },
      ],
      [

              'label'=>"Edit",
              "format"=>"raw",
              'value'=> function ($model, $key, $index, $grid){
                if ($model->status==1) {
                  // return Html::a('Edit',"javascript:void(0)", ['class'=>'btn btn-primary btn-sm',"onClick"=>"editTarget($model->id,$model->response_number)"]) ."<br/>".
                  return Html::a('Delete',"javascript:void(0)", ['class'=>'btn btn-danger mt-2 btn-sm',"onClick"=>"deleteTarget($model->id)"]);

    
                }else{
                  return Html::a('Edit',"javascript:void(0)", ['class'=>'btn btn-primary btn-sm',"onClick"=>"editTarget($model->id,$model->response_number)"]) ."<br/>".
                  Html::a('Delete',"javascript:void(0)", ['class'=>'btn btn-danger mt-2 btn-sm',"onClick"=>"deleteTarget($model->id)"])
                  
                  ;

                }
    
                },
          ],


    ],
    'toolbar' => [


    ],
    'toggleDataContainer' => ['class' => 'btn-group-sm'],

    'summary'=> "",

]);
   ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



</div>
<!-- Delete Modal -->
<div class="modal"  id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <?php $form = ActiveForm::begin(['action' => 'index.php?r=targetresponse/update-target','options' => ['method' => 'post']]); ?>

      <div class="modal-header">
        <h5 class="modal-title">Update Target</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
        <label for="exampleInputEmail1">Target</label>
        <input type="number" name="updatedTarget" min="1" required class="form-control" id="updatedTarget" aria-describedby="emailHelp" placeholder="Enter No.">
        <small id="emailHelp" class="form-text text-muted">Please fill upto remaing target.</small>
        <input type="hidden" id="targetId" name="targetId" >
      </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  
    <?php ActiveForm::end(); ?>
  </div>
</div>
<!-- Edit Modal -->


<!-- Delete Modal -->
<div class="modal"  id="deleteModal" tabindex="-2" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <?php $form = ActiveForm::begin(['action' => 'index.php?r=targetresponse/delete-target','options' => ['method' => 'post']]); ?>


      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Delete Target</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        <input type="hidden" id="deleteTargetId" name="deleteTargetId" >

        </button>
      </div>
      <div class="modal-body">
       <h5> Are you sure you want to delete this target ?
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger">Yes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
    </div>
  
    <?php ActiveForm::end(); ?>
  </div>
</div>
<!-- Edit Modal -->
<script>
function editTarget(id,responseNumber=0){
  $("#targetId").val(id)
  $("#updatedTarget").val(responseNumber)
  $('#exampleModal').modal()

}
function deleteTarget(id){
  $("#deleteTargetId").val(id)
  $('#deleteModal').modal()
}


</script>