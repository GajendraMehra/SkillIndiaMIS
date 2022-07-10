<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;
use dosamigos\fileupload\FileUpload;
use kartik\widgets\FileInput;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Scheme */

$this->title = Yii::t('app', 'User Profile');
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Home'), 'url' => []];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="scheme-create">
    <div class="card card-primary border-info">
        <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
        <h5><?= $this->title ?></h5>
        </div>
        <div class="card-body">
        <div class="row">
            <div class="col-md-8">
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
                  
                    [
                        'attribute'=>   'password_hash',
                        'label'=>"Password",
                        'format'=>'html',
                        'value'=>function($model){
                            return Html::a('Change Password', 'javascript:void(0)', ['class'=>'btn btn-primary btn-sm changePassword text-white', 'onclick'=>"return openModal()" ,'data-target'=>"#exampleModal"]);
                        }
                    ],    
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
                            if ($model->status==10) {
                                return '<span class="badge badge-success"> Active </span>';
 
                            }
                            return '<span class="badge badge-danger">Not active</span>';

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
            <div class="col-md-4">
                  <h5>Change Profile Picture</h5>
                  <?php $form = ActiveForm::begin([
                        'method'=>'POST',
                        'action'=>'index.php?r=user/upload-file',
      'enableClientValidation' => true,
]); 

        

// echo '<label class="control-label">Add Attachments</label>';
echo $form->field($uploadFile, 'file')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*',

],

'pluginOptions' => [
    'initialPreview'=>[
        Url::base().'/'.Yii::$app->user->identity->profile_pic,
    ],
    'initialPreviewAsData'=>true,
    'initialCaption'=>"profile_pic.png",
    
    'overwriteInitial'=>true,
    'maxFileSize'=>2800,

    'showCaption' => true,
    'showRemove' => false,
    'showUpload' => false,
    'showCancel' => false,
]
])->label(false);
echo Html::submitButton('Change Picture',[
    'class'=>'btn btn-primary'
])
                    ?>

<?php ActiveForm::end(); ?>
            </div>
        </div>
                
        </div>
    </div>



</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p>Please fill out the following fields to change password :</p>
   
   <?php $form = ActiveForm::begin([
       'id'=>'changepassword-form',
       'options'=>['class'=>'form-vertical'],
       
   ]); ?>
       <?= $form->field($model1,'oldpass',['inputOptions'=>[
           'placeholder'=>'Old Password'
       ]])->passwordInput() ?>
      
       <?= $form->field($model1,'newpass',['inputOptions'=>[
           'placeholder'=>'New Password'
       ]])->passwordInput() ?>
      
       <?= $form->field($model1,'repeatnewpass',['inputOptions'=>[
           'placeholder'=>'Repeat New Password'
       ]])->passwordInput() ?>
      
       <div class="form-group">
           <div class="col-lg-offset-2 col-lg-11">
              
           </div>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <?= Html::submitButton('Change password',[
                   'class'=>'btn btn-primary'
               ]) ?>
   <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>
<script>

$('.changePassword').click(function(){
    $('#passwordform-oldpass').val('')
    $('#exampleModal').modal('show')

}) 
$(document).ready(()=>{

$('.fileinput-upload').click(()=>{alert()})
})
</script>