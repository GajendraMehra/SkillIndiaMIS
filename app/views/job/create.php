<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Job */

$this->title = Yii::t('app', 'Create Job');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Jobs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-create">

    <div class="card card-primary border-info">
        <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
        <h5><?= $this->title ?></h5>
        </div>
        <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
           
        ]) ?>
        </div>
    </div>
</div>
