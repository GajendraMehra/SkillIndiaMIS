<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Targets */

$this->title = Yii::t('app', 'Create Targets');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Targets'), 'url' => ['index','filter'=>'all']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="targets-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <div class="card card-primary border-info">
        <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
        <h5><?= $this->title ?></h5>
        </div>
        <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
            'model1' => $model1,
            'model2' => $model2,

        ]) ?>
        </div>
    </div>

</div>
