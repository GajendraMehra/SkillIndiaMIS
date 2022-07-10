<?php


use yii\helpers\Html;
use kartik\grid\GridView;
// use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\CommonModel;

use yii\widgets\DetailView;
use app\models\Sector;
use app\models\TargetsResponse;
use kartik\widgets\FileInput;


/* @var $this yii\web\View */
/* @var $model app\models\Targets */

$this->title = Yii::$app->params['target_prefix'].$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Targets'), 'url' => 'index.php?r=target/assigned-index'];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sub Targets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="targets-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <div class="card card-primary border-info">
        <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
        <h5><?= $this->title ?></h5>
        </div>
        <div class="card-body">


    <div class="row">
    <div class="col-md-8">
    <?= DetailView::widget([
        'model' => $model,
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
            ],



        ],
    ]) ?>
    </div>
    <div class="col-md-4 text-center">
    <h3 class="text-primary mb-2">Workorder</h3>
 

    <h5 class="mt-2 mb-2"> <a class="text-primary" href="<?php echo Yii::getAlias('@web/').$model->work_order_file ?>" target="_blank" download> Download Here</a></h5>

    </div>
    </div>


</div>




</div>




<div class="row">
<div class="col-md-12">

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
              ],
              [
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


      ],
      'toolbar' => [

          '{export}',
          '{toggleData}'
      ],
      'toggleDataContainer' => ['class' => 'btn-group-sm'],
      'exportContainer' => ['class' => 'btn-group-sm'],
      'panel' => [
          'type'=> Yii::$app->config->get('panel-theme','primary'),
        'heading'=>'<h5>Center </h5>',
      //   'before'=>Html::a('<i class="fa fa-plus"></i> Create ', ['create'], ['class' => 'btn btn-success btn-sm']) .'&nbsp&nbsp'.Html::button('<i class="fa fa-trash"></i> Delete Selected ',  ['class' => 'btn btn-danger btn-sm','id'=>'delete-all','data-attrib-name'=>'target']),
      //   'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['index'], ['class' => 'btn btn-info btn-sm']),
      ],

  ]);
     ?>
</div>

</div>
</div>
