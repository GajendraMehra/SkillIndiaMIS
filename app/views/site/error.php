<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>
<div class="site-error">
	
   

	<div class="col-md-12 text-center">
    <div class ="mt-5">
    <img src="<?= Url::base()?>/custom/images/error.gif" alt="">
    
     <h5 class="mt-1">
       <?= nl2br(Html::encode($message)) ?>
    </h5>
        <?= Html::a("<i class='fa fa-home'></i> &nbspHome", Url::base(), ['class' => 'btn btn-sm btn-success', ]); ?>
		<p> Back To Home </p>
    </div> 
    </div> 


</div>



