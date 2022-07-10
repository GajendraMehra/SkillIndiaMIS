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

            <p class="">
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
              
            </p>

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
                        'attribute'=>    'batch_id',
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
                                   return "Not Provided By TP";
                               }
                            }
                        ],   
                ],
            ]) ?>
        </div>
         
    </div>
</div>





