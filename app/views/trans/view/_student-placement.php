<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\CommonModel;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\StudentResult */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Placement Details';
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
                'label'=>'Placement Status',
                'value'=>function($model){
                  return CommonModel::labelsPlacementStatus($model->result);
                }
            ],[
                // 'attribute'=>'result',
                'format'=>'html',
                'label'=>'Placed Organisation',
                'value'=>function($model){
                  return $model->placed_organisation;
                }
            ],[
                // 'attribute'=>'result',
                'format'=>'html',
                'label'=>'Salary Per Month',
                'value'=>function($model){
                  return $model->package_pm;
                }
            ],
            [
              // 'attribute'=>'result',
              'format'=>'raw',
              'label'=>'Candidate Document',
              'value'=>function($model){
                if($model->result){

                
                $allfiles = scandir(\Yii::$app->basePath."/web/uploads/placement");

                foreach ($allfiles as $file) {
                    if (str_contains($file,$model->student_id)) {
                      return Html::a('View File',  Yii::$app->request->BaseUrl."/uploads/placement/". $file, ['target'=>'_blank','class'=>"btn btn-sm btn-success"]);
                    }
                }
              }
              }
          ],

          
        ],
    ]); ?>


</div>