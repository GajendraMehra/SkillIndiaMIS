<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\CommonModel;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\StudentResult */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Results';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-result-index">

    <h5><?= Html::encode($this->title) ?></h5>



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>   'id',
              'label'=>"Student Name",
              'header' => false,
              'encodeLabel' => false,
                // 'contentOptions' => ['style' => 'display:none   '],
        
                'format'=>"html",
                'value'=>function($model){
                  return  $model->student->student_name;
                }
        
            ],
            [
               'attribute'=>   'sip_id',
              'header' => false,
              'encodeLabel' => false,
                // 'contentOptions' => ['style' => 'display:none   '],
        
                'format'=>"html",
                'value'=>function($model){
                  return $model->student->sip_id;
                }
        
            ],
            [
                // 'attribute'=>'result',
                'format'=>'html',
                'label'=>'Result',
                'value'=>function($model){
                  return CommonModel::labelsResultStatus($model->result);
                }
            ],

          
        ],
    ]); ?>


</div>