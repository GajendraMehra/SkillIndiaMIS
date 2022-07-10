<?php 
use yii\helpers\Html;

$this->title = Yii::t('app', 'Approval Status');
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Schemes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
.right-panel{


    
	width: 86%;
	min-width: 82% !important;

}

</style>

<div class="container">
  <?php switch ($tpdata['is_approved']) {
      case '0':
        ?>
        <div class="alert-box mt-8">
            <div class="alert alert-danger">
              <div class="alert-icon text-center">
                <i class="fa fa-ban  fa-3x" aria-hidden="true"></i>
              </div>
              <div class="alert-message text-center">
                <strong>OOPS !</strong> Your application  was declined by admin.
              </div>
            </div>
          </div>
        </div>
        <?php
          break;
    case '1':
        ?>
<div class="alert-box mt-8">
    <div class="alert alert-success">
      <div class="alert-icon text-center">
        <i class="fa fa-check  fa-3x" aria-hidden="true"></i>
      </div>
      <div class="alert-message text-center">
        <strong>Approved !</strong> You are approved as Training Partner .
      </div>
    </div>
  </div>
</div>
       
    <?php
    break;

      default:
        ?>
         <div class="alert-box mt-8">
            <div class="alert alert-info">
              <div class="alert-icon text-center">
                <i class="fa fa-warning  fa-3x" aria-hidden="true"></i>
              </div>
              <div class="alert-message text-center">
                <strong>Status !</strong> Your approval status is under review by admin
              </div>
            </div>
          </div>
        </div>
        <?php
          break;
  } ?>
  <div class="text-center">
    <?= Html::a(Yii::t('app', '<i class="fa fa-eye"></i>&nbsp&nbsp View Application'), ['view-application', 'id' => $tpdata['id'],'actionId'=>1], ['class' => 'btn btn-primary',
         
        ]) ?>
</div>
