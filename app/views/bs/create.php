<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BatchStudents */

$this->title = 'Create Batch Students';
$this->params['breadcrumbs'][] = ['label' => 'Batch Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="batch-students-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
