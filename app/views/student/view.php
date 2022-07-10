<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Student */

$this->title = $model->student_name;
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="student-view">
  <div class="card card-primary border-info">
          <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
          <h5><?= $this->title ?></h5>
          </div>
          <div class="card-body">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to Delete this Student ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'hope_id',
            'employment_id',
            'sip_id',
            'student_name',
            [
                'attribute'=>    'email',
                // 'label'=>"Registered at",
                'format'=>'html',
                // 'value'=>Html::a($model->student_name, ['student/view','id'=>$model->id], ['target'=>'_blank','class'=>'text-primary'])
            ],

            'mother_name',
            'father_name',
            'dob',
            [
              'attribute'=>  'aadhar_no',
              // 'label'=>"A",
              'value'=>function($model){
                return   $model->aadhar_no[0].$model->aadhar_no[1]."XXXXXXXXX".substr($model->aadhar_no,-2);
              }
            ],
            [
              'attribute'=>  'aaadhar_no',
              'attribute'=>  'Aadhar File Image',
              // 'label'=>"A",
              'format'=>'raw',
              'value'=>function($model){
                if($model->adhar_file_name)
                return Html::a('View',$model->adhar_file_name, ['target'=>'_blank', 'data-pjax'=>"0",'class'=>'btn btn-sm btn-success']);
                return "No File Uploaded";
              }
            ],
            'address',
            'block.name',
            'phone_no:ntext',
            'educationlevel.education',
            'categoryname.category',
            'trainingcenters.name',
            'job.job_name',
            [
                'attribute'=>'created_at',
                'label'=>"Registered at",
                'format'=>'html',
                'value'=>date('d F Y',strtotime($model->created_at)) ." at ".date('h:i:s A',strtotime($model->created_at))
            ],

            [
                'attribute'=>  'updated_at',
                'label'=>"Last Updated",
                'format'=>'html',
                'value'=>date('d F Y',strtotime($model->updated_at)) ." at ".date('h:i:s A',strtotime($model->updated_at))
            ],
            [
                'attribute'=>  'editedby.username',
                'label'=>"Registered By",
                'format'=>'html',
                'value'=>function($model){
                  if ($model->edited_by) {
                    return $model->editedby->username;
                  }
                  return "Self Registered Via Portal";

                }
            ],
        ],
    ]) ?>
  </div>
  </div>
</div>
<object
  data="https://example.com/test.pdf#page=2"
  type="application/pdf"
  width="100%"
  height="100%">
  <p>Your browser does not support PDFs.
    <a href="https://example.com/test.pdf">Download the PDF</a>.</p>
</object>