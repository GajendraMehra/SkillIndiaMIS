<?php
// use Yii;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\UkBlocks;
use app\models\CommonModel;
use app\models\Job;
use app\models\Category;
use app\models\Tcdetail;
use app\models\EducationLevel;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Student */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Students';
$this->params['breadcrumbs'][] = $this->title;
?>

<style media="screen">
#w0-container {
	overflow: auto;
	overflow-x: scroll;
	width: 75vw;

}


</style>

<div class="row">
  <div class="col-12">


<div class="student-index">

<!-- <?php Pjax::begin(); ?> -->

    <?= GridView::widget([
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,

    'columns' => [
      'id',
              
                [
                  'attribute'=> 'student_name',
                  'format'=>"html",
                  'value'=>function($model){
                    return   Html::a($model->student_name, ['student/view','id'=>$model->id], ['target'=>'_blank','class'=>'text-primary']);
                  }
                ],
                'hope_id',
                'employment_id',
                'sip_id',
                'email',
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
                [
                  'attribute'=>  'block_id',
                  'label'=>"Blocks",


                  'filter' => ArrayHelper::map(UkBlocks::find()->all(), 'id', 'name'),
                  'filterType' => GridView::FILTER_SELECT2,
                  'filterWidgetOptions' => [
                  'options' => ['prompt' => 'All'],
                  'pluginOptions' => [
                  'allowClear' => true,
                  // 'format'=>'html',

                  ]
                  ],
                  'value'=>function($model){
                      return $model->block->name;
                   }
              ],

              [
                'attribute'=>'gender',
                'format'=>'html',
                'filter' => ["Female","Male","Other"],
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                'options' => ['prompt' => 'All'],
                'pluginOptions' => [
                'allowClear' => true,
                ]
                ],
                'value'=>function($model){
                  return CommonModel::labelsGender($model->gender);
                }
            ],
                'phone_no',


                [
                  'attribute'=>'max_edu',
                  'format'=>'html',
                  'filter' => ArrayHelper::map(EducationLevel::find()->all(), 'id', 'education'),

                  'filterType' => GridView::FILTER_SELECT2,
                  'filterWidgetOptions' => [
                  'options' => ['prompt' => 'All'],
                  'pluginOptions' => [
                  'allowClear' => true,
                  ]
                  ],
                  'value'=>function($model){
                    return $model->educationlevel->education;
                  }
              ],  [
                  'attribute'=>'category',
                  'format'=>'html',
                  'filter' => ArrayHelper::map(Category::find()->all(), 'id', 'category'),

                  'filterType' => GridView::FILTER_SELECT2,
                  'filterWidgetOptions' => [
                  'options' => ['prompt' => 'All'],
                  'pluginOptions' => [
                  'allowClear' => true,
                  ]
                  ],
                  'value'=>function($model){
                    return $model->categoryname->category;
                  }
              ],
              [
                'attribute'=>'selected_tc',
                'format'=>'html',
                'filter' => (Yii::$app->user->identity->role==1) ? (ArrayHelper::map(Tcdetail::find()->all(), 'id', 'name')) : false ,

                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                'options' => ['prompt' => 'All'],
                'pluginOptions' => [
                'allowClear' => true,
                ]
                ],
                'value'=>function($model){
                  return $model->trainingcenters->name;
                }
              ],
                [
                  'attribute'=>'prefrence_job',
                  'format'=>'html',
                  'filter' => ArrayHelper::map(Job::find()->all(), 'id', 'job_name'),

                  'filterType' => GridView::FILTER_SELECT2,
                  'filterWidgetOptions' => [
                  'options' => ['prompt' => 'All'],
                  'pluginOptions' => [
                  'allowClear' => true,
                  ]
                  ],
                  'value'=>function($model){
                    return $model->job->job_name;
                  }
              ],

                'created_at',
                // 'updated_at',
                [
                  'attribute'=>'edited_by',
                  'label'=>"Registered By ",
                  'format'=>'html',

                  'value'=>function($model){
                    if ($model->edited_by==0) {
                      return "Self";
                    }
                    return "Training Partner";
                  }
              ],

                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => false,
                    'width'=>'20',

                    'vAlign'=>'middle',
                    'template' => '{delete} {view} {update}',
                    'buttons' => [
                      'delete' => function($url, $model){
                          return Html::a('Delete', ['delete', 'id' => $model->id], [
                              'class' => 'btn btn-danger btn-sm',
                              'data' => [
                                  'confirm' => 'Are you absolutely sure ? You will lose all the related information  with this action.',
                                  'method' => 'post',
                                  'class' => 'danger'
                              ],
                          ]);
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
      'heading'=>'<h5>'.Html::encode(mb_strtoupper($this->title)).'</h5>',
      // 'before'=>Html::a('<i class="fa fa-plus"></i> Create ', ['create'], ['class' => 'btn btn-success btn-sm']) .'&nbsp&nbsp',
      'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['index'], ['class' => 'btn btn-info btn-sm']),
    ],

]);

 ?>



</div>

</div>
</div>
