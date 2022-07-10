<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tcdetail */

$this->title = Yii::t('app', 'Create Training Center');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Training Center'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tcdetail-create">

   

    <?= $this->render('_form', [
        'model' => $model,
        'model1' => $model1,
        'model2' => $model2,
        'model3' => $model3,
    ]) ?>

</div>
