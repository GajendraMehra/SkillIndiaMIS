<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use app\models\CommonModel;


/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'All Users', 'url' => ['alluser']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="users-view">

  <div class="card card-primary border-info">
      <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
      <h5><?= $this->title ?></h5>
      </div>
      <div class="card-body">
      <?php

         if($model->status==10&&Yii::$app ->user ->identity->role==1):
            echo Html::a(Yii::t('app', 'Suspend Account'), ['change-status', 'id' => $model->id,'status'=>0], [
                'class' => 'btn btn-danger mb-2',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to perform this item?'),
                    'method' => 'post',
                ],
            ]);
          elseif($model->status==0):
            echo Html::a(Yii::t('app', 'Reactive Account'), ['change-status', 'id' => $model->id,'status'=>10], [
                'class' => 'btn btn-success mb-2',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to perform this item?'),
                    'method' => 'post',
                ],
            ]);
          endif;

        ?>
 
        <div class="row">
          <div class="col-8">

         
  <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

          [
              'attribute'=>  'id',
              'label'=>"User ID",
              'format'=>'html',
              'value'=>function($model){
                  return Yii::$app->params['user_prefix'].$model->id;
              }
          ],

          'username',

          // [
          //     'attribute'=>   'password_hash',
          //     'label'=>"Password",
          //     'format'=>'html',
          //     'value'=>function($model){
          //         return Html::a('Change Password', 'javascript:void(0)', ['class'=>'btn btn-primary btn-sm changePassword text-white', 'onclick'=>"return openModal()" ,'data-target'=>"#exampleModal"]);
          //     }
          // ],
          'email',

          [
              'attribute'=>  'role',
              // 'label'=>"Registerd On",
              'format'=>'html',
              'value'=>function($model){
                  return Yii::$app->params['role_'.$model->role];
              }
          ],      [
              'attribute'=>  'status',
              'label'=>"Account Status",
              'format'=>'html',
              'value'=>function($model){
                return CommonModel::UserStatus($model->status);


              }
          ],

          [
              'attribute'=>  'created_at',
              'label'=>"Registerd On",
              'format'=>'html',
              'value'=>function($model){
                  return date('d F Y',$model->created_at) ." at ".date('h:i:s A',$model->created_at);
              }
          ],     [
              'attribute'=> 'updated_at',
              'label'=>"Last Modified",
              'format'=>'html',
              'value'=>function($model){
                  return date('d F Y',$model->updated_at) ." at ".date('h:i:s A',$model->updated_at);
              }
          ],

          // 'verification_token',
        ],
    ]) ?>

  </div>
  <div class="col-4 text-center">
    <?= Html::img(Url::base().'/'.$model->profile_pic,['width' => '250px','height'=>'250px','class'=>'rounded-circle']);?>
  </div>
</div>
</div>
</div>
</div>
</div>
