<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BatchStudents */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Batch Students';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="batch-students-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Batch Students', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'batch_id',
            'student_id',
            'created_at',
            
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
