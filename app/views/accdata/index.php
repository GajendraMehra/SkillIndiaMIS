<?php

use yii\helpers\Html;
use yii\helpers\Url;

use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\AccountantData */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Drive ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accountant-data-index">

  

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,

    'columns' => [
        // ['class' => '\kartik\grid\CheckboxColumn'],


            [
              'class' => 'yii\grid\SerialColumn',
              'contentOptions' => ['style' => 'width:10px; white-space: normal;'],

            ],
           
            'file_title',
      
            'file_description',
           
            [
              'attribute'=>  'editedBy.username',
              'label'=>"Uploaded By",
              'format'=>'html',
              // 'value'=>
          ],
            [
              'class' => 'kartik\grid\ActionColumn',
              'dropdown' => false,
              'width'=>'20',
              // 'contentOptions' => ['style' => 'width:20%'],
              'hAlign'=>'middle',
              'template' => '{delete} {view}',
              'buttons' => [
                'delete' => function($url, $model){
                    return Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-danger',
                        'data' => [
                            'confirm' => 'Are you absolutely sure ? You will lose all the related information with this action.',
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
              'label' => 'View','class' => 'btn btn-sm btn-success ','title'=>'View'],
              'updateOptions'=>['role'=>'modal-remote',
              'label' => 'Update',
              'class' => 'btn btn-sm btn-info ',
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
      'before'=>Html::a('<i class="fa fa-plus"></i> Add New File ', ['create'], ['class' => 'btn btn-success btn-sm']) .'&nbsp&nbsp',
      'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['index'], ['class' => 'btn btn-info btn-sm']),
    ],

]);
?>


</div>
