<?php
use unclead\multipleinput\MultipleInput;
use kartik\form\ActiveForm;
use app\models\Tcdetail;
use app\models\CommonModel;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use app\models\Sector;
use kartik\grid\GridView;
use yii\helpers\Url;

use yii\helpers\Html;
use app\models\TargetDistrict;
use app\models\TargetsResponse;

use app\models\TargetJob;

// use yii\helpers\Url;

$this->title = Yii::$app->params['target_prefix'].$model1->id;

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
                'attribute'=>  'work_order_file',
                'label'=>"Work Order ",
                'format'=>'html',
                'value'=>function($model){
                    return '<a class="btn btn-sm btn-warning" href="'.Yii::getAlias('@web/').$model->work_order_file.'" target="_blank" download>View WorkOrder</a>';
                }
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
                'label'=>"Total Targets ",
                'format'=>'html',
                'value'=>function($model){
                    return '<span class="total_targets">'.$model->number.'</span>';
                }
            ],[
                'attribute'=>'number',
                'label'=>"Remaining  ",
                'format'=>'html',
                'value'=>function($model){
                    return '<span class="total_targets">'.((Integer)$model->number-(Integer)TargetsResponse::find()->andWhere(['!=','status',2])->andWhere(['target_id'=>$model->id])->sum('response_number')).'</span>';
                }
            ]




        ],
    ]) ?>
    </div>
    <div class="col-md-4 text-center">
    <h3 class="text-primary mb-2">Workorder</h3>
 
    <h5 class="mt-2 mb-2"> <a class="text-primary" href="<?php echo Yii::getAlias('@web/').$model1->work_order_file ?>" target="_blank" download> Download Here</a></h5>

    </div>
    </div>

    <?= GridView::widget([
    'dataProvider'=> $dataProvider,
    // 'filterModel' => $searchModel,

    'columns' => [
        ['class' => '\kartik\grid\CheckboxColumn'],




            'center.name',
            'center.smart_tcid',
            [
                'attribute'=>  'job.job_name',
                'label'=>"Job",
            ],
            [
                'attribute'=> 'district.name',
                'label'=>"District",
            ], [
                'attribute'=>'response_number',
                'label'=>"Target",
            ],
            [
                'attribute'=>'action_id',
                'label'=>  "LOR / Reason",
                  'format'=>'html',
                'value'=>function($model){
                  if ($model->status==1) {
                      return '<a class="btn btn-sm btn-success" href="'.Yii::getAlias('@web/').$model->action_id.'" target="_blank" download>View LOR</a>';
                  }else{
                    $text=explode('|',$model->action_id);
                    return @$text[1];
                  }

                }
            ],
            [
                'attribute'=> 'status',
                'label'=>"Status",
                'format'=>'html',
                'value'=>function($model){
                  return CommonModel::labelsTargetApprovedstatus($model->status);
                }
            ],

            // ,
            // 'created_at',
            // 'id',
            // [
            //     'attribute'=>  'sector_id',
            //     'label'=>"Sector",
            //     'filter' => ArrayHelper::map(Job::find()->all(), 'id', 'job_name'),
            //     'filterType' => GridView::FILTER_SELECT2,
            //     'filterWidgetOptions' => [
            //     'options' => ['prompt' => 'All'],
            //     'pluginOptions' => [
            //     'allowClear' => true,
            //     'format'=>'html',

            //     ]
            //     ],
            //     'value'=>function($model){
            //         // echo "<pre>";
            //         return Sector::findOne($model->sector->sector_id)->sector_name;

            //         // die;
            //      }
            // ],
            // [
            //     'attribute'=>  'job_id',
            //     'label'=>"Job Name",
            //     'filter' => ArrayHelper::map(Job::find()->all(), 'id', 'job_name'),
            //     'filterType' => GridView::FILTER_SELECT2,
            //     'filterWidgetOptions' => [
            //     'options' => ['prompt' => 'All'],
            //     'pluginOptions' => [
            //     'allowClear' => true,
            //     'format'=>'html',

            //     ]
            //     ],
            //     'value'=>function($model){
            //         return $model->job->job_name;
            //      }
            // ],
            // [
            //     'attribute'=>  'qp_code',
            //     'label'=>"QP code",

            //     'value'=>function($model){
            //         return $model->job->qp_code;
            //      }
            // ],
            // [
            //     'attribute'=>  'tp_id',
            //     'label'=>"Assigned Training Partner",
            //     'filter' => ArrayHelper::map(TpartnerDetail::find()->all(), 'id', 'tp_name'),
            //     'filterType' => GridView::FILTER_SELECT2,
            //     'filterWidgetOptions' => [
            //     'options' => ['prompt' => 'All'],
            //     'pluginOptions' => [
            //     'allowClear' => true,
            //     'format'=>'html',

            //     ]
            //     ],
            //     'value'=>function($model){
            //        return $model->tp->tp_name;
            //     }
            // ],
            // // 'scheme.full_name',
            // // 'tp.tp_name',
            // 'number',
            // [
            //     'attribute'=>  'updated_at',
            //     'label'=>"Last Updated",
            //     'filter'=>false,
            //     'format'=>'html',
            //     'value'=>function($model){
            //        return  date('d F Y',strtotime($model->created_at)) ." at ".date('h:i:s A',strtotime($model->created_at));
            //     }
            // ],


    ],
    'toolbar' => [

        '{export}',
        '{toggleData}'
    ],
    'toggleDataContainer' => ['class' => 'btn-group-sm'],
    'exportContainer' => ['class' => 'btn-group-sm'],
    'panel' => [
        'type'=> Yii::$app->config->get('panel-theme','primary'),
      'heading'=>'<h5>Alloted Centers Status</h5>',
    //   'before'=>Html::a('<i class="fa fa-plus"></i> Create ', ['create'], ['class' => 'btn btn-success btn-sm']) .'&nbsp&nbsp'.Html::button('<i class="fa fa-trash"></i> Delete Selected ',  ['class' => 'btn btn-danger btn-sm','id'=>'delete-all','data-attrib-name'=>'target']),
    //   'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['index'], ['class' => 'btn btn-info btn-sm']),
    ],

]);
   ?>

<?php if ($model1->status==1): ?>

<div class="card card-info border-info">
    <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
    <h5>Assign New Centers  </h5>
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


<?php endif; ?>
</div>
    </div>


</div>
</div>

</div>
