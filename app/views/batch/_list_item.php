<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


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


  <?= DetailView::widget([
      'model' => $model,
      'attributes' => [
          // 'id',
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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



</div>
