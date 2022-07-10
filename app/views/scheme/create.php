<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Scheme */

$this->title = Yii::t('app', 'Create Scheme');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Schemes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="scheme-create">
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
