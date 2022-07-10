<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\AccountantData */

$this->title = $model->file_title;
$this->params['breadcrumbs'][] = ['label' => 'Accountant Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="accountant-data-view">
  <div class="card card-primary border-info">
      <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
      <h5><?= $this->title ?></h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-8">

            <p class="">
             
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [


                    'file_title',
                    'file_description',
                    [
                        'attribute'=>  'file_name',
                        'label'=>"File Type",
                        'format'=>'html',
                        'value'=>function($model){
                            $data=explode('.',$model->file_name);
                            return @$data[1];
                        }
                    ],

                    [
                        'attribute'=>  'created_at',
                        'label'=>"Uploaded On ",
                        'format'=>'html',
                        'value'=>function($model){
                            return date('d F Y',strtotime($model->created_at)) ." at ".date('h:i:s A',strtotime($model->created_at));
                        }
                    ],     [
                        'attribute'=> 'updated_at',
                        'label'=>"Last Modified",
                        'format'=>'html',
                        'value'=>function($model){
                            return date('d F Y',strtotime($model->updated_at)) ." at ".date('h:i:s A',strtotime($model->updated_at));
                        }
                    ],

                    // 'verification_token',
                    ],
                ]) ?>

            </div>
            <div class="col-4 text-center">
                    <div class="mt-5">

                    <a class="btn btn-primary mt-5 mb-5" href="<?php echo Yii::getAlias('@web/').$model->file_name ?>" target="_blank" > View </a>
                    <h5>Or</h5>
                    <br>
            <a class="btn btn-secondary mt-2" href="<?php echo Yii::getAlias('@web/').$model->file_name ?>" target="_blank" download> Download Here</a>
                    </div>
               
            </div>
</div>
</div>
</div>
</div>
</div>

