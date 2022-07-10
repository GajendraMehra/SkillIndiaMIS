<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Job */

$this->title = $model->batch->batch_name;
$this->params['breadcrumbs'][] = ['label' => 'Student Placements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="job-view">

<div class="card card-primary border-info">
        <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
        <h5><?= $this->title ?></h5>
        </div>
        <div class="card-body">

            

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute'=>    'batch_id',
                        'label'=>"Batch Name",
                        'format'=>'html',
                        // 'filter' => ArrayHelper::map(Sector::find()->all(), 'nsdc_sector_id', 'sector_name'),
                        // 'filterType' => GridView::FILTER_SELECT2,
                        // 'filterWidgetOptions' => [
                        // 'options' => ['prompt' => 'All'],
                        // 'pluginOptions' => [
                        // 'allowClear' => true,
                        // 'format'=>'html',
                       
                        // ]
                        // ],
                        'value'=>function($model){
                           return $model->batch->batch_name;
                        }
                    ],
                     
                    [
                        'attribute'=>    'student_id',
                        'label'=>"Student Name",
                        'format'=>'html',
                        // 'filter' => ArrayHelper::map(Sector::find()->all(), 'nsdc_sector_id', 'sector_name'),
                        // 'filterType' => GridView::FILTER_SELECT2,
                        // 'filterWidgetOptions' => [
                        // 'options' => ['prompt' => 'All'],
                        // 'pluginOptions' => [
                        // 'allowClear' => true,
                        // 'format'=>'html',
                       
                        // ]
                        // ],
                        'value'=>function($model){
                           return $model->student->student_name;
                        }
                    ], 
                    [
                        'attribute'=>    'sip_id',
                        'label'=>"SIP ID",
                        'format'=>'html',
                        // 'filter' => ArrayHelper::map(Sector::find()->all(), 'nsdc_sector_id', 'sector_name'),
                        // 'filterType' => GridView::FILTER_SELECT2,
                        // 'filterWidgetOptions' => [
                        // 'options' => ['prompt' => 'All'],
                        // 'pluginOptions' => [
                        // 'allowClear' => true,
                        // 'format'=>'html',
                       
                        // ]
                        // ],
                        'value'=>function($model){
                           return $model->student->sip_id;
                        }
                    ],
                     
            
                       [
                            'attribute'=>  'placed_organisation',
                            
                            'format'=>'html',
                         
                            'value'=>function($model){
                               return $model->placed_organisation;
                            }
                        ], 
                        [
                            'attribute'=> 'package_pm',
                            'format'=>'html',
                            'value'=>function($model){
                               return '&#8377; '.$model->package_pm;
                            }
                        ],
                        
                        [
                            'attribute'=>   'file_name',
                            'label'=>"Appointment Letter",
                            'format'=>'html',
                            'value'=>function($model){
                               if ($model->file_name) {
                                return Html::a('View', $model->file_name, ['class'=>'btn btn-primary btn-sm changePassword text-white', 'onclick'=>"return openModal()" ,'data-target'=>"#exampleModal"]);
                               }else{
                                   return "Not found on server (Please Upload)";
                               }
                            }
                        ],    

                ],
            ]) ?>
        </div>
            <div class="row">
            <div class="col-md-8">
                
            <?php $form = ActiveForm::begin([ 'method'=>'POST', 'action'=>'index.php?r=placement/upload-file&id='.$model->id, 'enableClientValidation' => true, ]); 

echo $form->field($uploadFile, 'file')->widget(FileInput::classname(), [
    'options' => ['accept' => ['image/*','/pdf','required'=>true]],

'pluginOptions' => [
    'initialPreview'=>[
        Url::base().'/'.$model->file_name,
    ],
    'initialPreviewAsData'=>true,
    'initialCaption'=>"apointment_leter.png",
    
    'overwriteInitial'=>true,
    'maxFileSize'=>2800,

    'showCaption' => true,
    'showRemove' => false,
    'showUpload' => false,
    'showCancel' => false,
]
])->label(false);

                    ?>
                    <div class="row ">
                    <div class="col-12 text-right mb-2">
                    <?php 
                    echo Html::submitButton('Save',[ 'class'=>'btn btn-success' ])  ?>
                    
                    </div>
                    </div>

<?php ActiveForm::end(); ?>
            </div>
            </div>
    </div>
</div>





