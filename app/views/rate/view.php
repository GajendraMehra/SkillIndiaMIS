<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\Rate */

$this->title = $model->rate_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="rate-view">
<div class="card card-primary border-info">
        <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
        <h5><?= $this->title ?></h5>
        </div>
        <div class="card-body">

            <p class="">
                <?= Html::a(Yii::t('app', 'Rename'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'rate_name',
            [
                'attribute'=>'created_at',
                // 'label'=>"Assigned Training Partner",
                'format'=>'html',
                'value'=>date('d F Y',strtotime($model->created_at)) ." at ".date('h:i:s A',strtotime($model->created_at))
            ],
            [
                'attribute'=>  'updated_at',
                'label'=>"Last Renamed",
                'format'=>'html',
                'value'=>date('d F Y',strtotime($model->updated_at)) ." at ".date('h:i:s A',strtotime($model->created_at))
            ],
            [
                'attribute'=>  'editedBy.username',
                'label'=>"Created By",
                'format'=>'html',
                // 'value'=>
            ],
        ],
    ]) ?>

<?= GridView::widget([
    'dataProvider'=> $model1,
    // 'filterModel' => $searchModel,
   
    'columns' => [

        // 'id',
        // 'rate_id',
    [  
        'attribute'=>'rate_amount',
        'format'=>'html',
        'value'=>function($model1){
          
            return '<span>&#x20B9</span> <span>'.$model1->rate_amount.'</span>';
        }
    
    ],

 
      
        [
            'attribute'=>  'fromdate',
            'label'=>"Effective from",
            'format'=>'html',
            'value'=>function($model1){
                return date('d F Y',strtotime($model1->fromdate)) ." at ".date('h:i:s A',strtotime($model1->fromdate));
            }
            
        ], [
            'attribute'=>  'updated_at',
            'label'=>"Updated At",
            'format'=>'html',
            'value'=>function($model1){
                return date('d F Y',strtotime($model1->updated_at)) ." at ".date('h:i:s A',strtotime($model1->updated_at));
            }
        ],[
            'attribute'=>  'editedBy.username',
            'label'=>"Updated By",
            'format'=>'html',
           
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'dropdown' => false,
            'width'=>'20',
            // 'contentOptions' => ['style' => 'width:20%'],
            'hAlign'=>'middle',
            'template' => '{delete} {update} ',
            'buttons' => [
              'delete' => function($url, $model){
                  return Html::a('Delete', ['/rateinfo/delete', 'id' => $model->id, 'rateid' => $_GET['id']], [
                      'class' => 'btn btn-danger btn-sm',
                      'data' => [
                          'confirm' => 'Are you absolutely sure ? You will lose all the related information  with this action.',
                          'method' => 'post',
                          'class' => 'danger'
                      ],
                  ]);
              },
              'update' => function($url, $model){
                return Html::a('Update Amount', ['/rateinfo/update', 'id' => $model->id], [
                    'class' => 'btn btn-sm btn-primary',
                    
                ]);
            },
              
            ],
           
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
      'heading'=>'<h5>'.Html::encode(mb_strtoupper($this->title." amount ")). '</h5>',
      'before'=>Html::a('<i class="fa fa-plus"></i> New Amount ', ['/rateinfo/create','id'=>$_GET['id']], ['class' => 'btn btn-success btn-sm']),
    //   'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['index'], ['class' => 'btn btn-info btn-sm']),
    ],
   
]);
?>
        </div>
    </div>
</div>
