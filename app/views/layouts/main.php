<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;

use app\assets\AppAsset;
use app\assets\LoginAsset;
use app\assets\DashboardAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
// use app\models\Notification;
use yii\widgets\Breadcrumbs;
// use yii\widgets\NotificationsWidget;
use common\widgets\Alert;
// use machour\yii2\notifications\widgets\NotificationsWidget;
// echo Alert::widget();

if (isset($_GET['r'])) {
    if ($_GET['r']=='site/login'
    ||$_GET['r']=='site/tp-signup'
    ) {
            LoginAsset::register($this);
        } else {
            DashboardAsset::register($this);
        }
}
else {
    DashboardAsset::register($this);

}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>

        .normaliseBtn{
            border:0;
            background:transparent;
            cursor:pointer;
        }
       
        .sub-menu{
            background:'red'
        }


#curtain1
{
 top:0px;
 position:absolute;
 left:0px;
 height:100%;
 width:50%;
}
#curtain2
{
 top:0px;
 position:absolute;
 height:100%;
 width:50%;
 right:0px;
}

     
        /* .dropdown-menu{
            background-color: inherit !important;
        } */
        body{
            background:'red' !important;
        }
    </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</head>
<?php $this->beginBody();

echo $this->render('/layouts/flashes');
  if (Yii::$app->user->isGuest) {
    echo $content;
}else{?>
<div id="wrapper">

<div id="effect">
 
<div class="">

<!-- Left Panel -->
<?php

    //  NotificationsWidget::widget([
    //     'theme' => NotificationsWidget::THEME_TOASTR,
    //     'clientOptions' => [
    //         'location' => 'br',
    //     ],
    //     'counters' => [
    //         '.notifications-header-count',
    //         '.notifications-icon-count'
    //     ],
    //     'markAllSeenSelector' => '#notification-seen-all',
    //     'listSelector' => '#notifications',
    // ]);
    //  Notification::notify(Notification::KEY_NEW_MESSAGE, 2, 10);

?>

<aside id="left-panel" class="left-panel <?= Yii::$app->config->get('sidemenu-theme','simple'); ?>">
        <nav class="navbar navbar-expand-sm ">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./">
                <h4><?= Yii::$app->config->get('mis-name','skill mis'); ?>  </h4>
                </a>
                
                <!-- <a class="navbar-brand hidden" href="./"><img src="custom/images/logo2.png" alt="Logo"></a> -->
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
            <?php
            // render the menus according to the user role
                switch (Yii::$app->user->identity->role) {
                    case '1':
                        echo $this->render('menu/admin.php');
                    break;
                    case '2':
                        echo $this->render('menu/trainingPartner.php');
                    break;
                    case '3':
                        echo $this->render('menu/trainingCenter.php');
                    break;
                    case '4':
                        echo $this->render('menu/accountant.php');
                    break;
                    case '5':
                        echo $this->render('menu/manager.php');
                    break;
                    default:

                    break;
                }
            ?>

            </div><!-- /.navbar-collapse -->
        </nav>
      
    </aside>

       <!-- Right Panel -->
<div id="right-panel" class="right-panel fullwidth" style="width:100%">

<!-- Header-->
<header id="header" class="header <?= Yii::$app->config->get('topbar-theme','simple'); ?>">

    <div class="header-menu row">

        <div class="col-3 col-sm-2">
            <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
            <div class="header-left">

                <div class="dropdown for-message">
                  <?php if (Yii::$app->user->identity->role ==1): ?>
                  <?= Html::a('<i class="fa fa-print" aria-hidden="true"></i> Reports', ['/report/index'], ['class'=>'btn']) ?>
                    <?php endif; ?>
                    </div>
            </div>
        </div>

        <div class="col-9 col-sm-10">

            <div class="user-area dropdown d-flex flex-row-reverse  text-right">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle" src="<?= Url::base().'/'.Yii::$app->user->identity->profile_pic; ?>" alt="User Avatar">
                </a>
                <div class="user-menu dropdown-menu text-center">
                    <a class="nav-link bg-white" href="<?=  Yii::$app->homeUrl."?r="?>user"><i class="fa fa-user"></i> My Profile</a>

                    <!-- <a class="nav-link" href="#"><i class="fa fa-user"></i> Notifications <span class="count">13</span></a> -->

                    <?php if (Yii::$app->user->identity->role ==1): ?>
                    <a class="nav-link bg-white" href="<?=  Yii::$app->homeUrl."?r="?>user/settings"><i class="fa fa-cog"></i> Settings</a>
                    <?php endif; ?>

                    <?= Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                        '<i class="fa fa-power-off"></i> Logout',
                        ['class' => 'bg-white nav-link normaliseBtn btn-block',
                        'data' => [
                            'confirm' => 'Are you sure you want to logout',
                            'method' => 'post',
                        ],]
                        )
                        . Html::endForm()
                    ?>

                </div>
            <h5 class=" mr-3"><?= Yii::$app->user->identity->username; ?>  <span class="badge badge-pill badge-success"><?= Yii::$app->params['role_'.Yii::$app->user->identity->role] ?></span></h5>
      
            </div>



        </div>
    </div>

</header><!-- /header -->
<!-- Header-->

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">

                <h1><?=  isset($this->params['breadcrumbs'][0]) ? end($this->params['breadcrumbs']) : "Home" ?></h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
            <?= Breadcrumbs::widget([
                'itemTemplate' => "<li>{link}</li>\n",
                'homeLink' => [
                            'label' => Yii::t('yii', 'Home'),
                            'url' => Yii::$app->homeUrl."?r=",
                        ],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
            ?>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">
<div class="header">



</div>
    <?= $content ?>
   
</div>
<?= $this->render('footer'); ?>

</div>

</div>

</div>


</div>

<!-- parda -->

</div>
<?php 
if(@$_GET['welcome'])
{
?>
<img src="<?= yii::getalias('@web')?>/custom/images/curtain11.jpg" id="curtain1">
 <img src="<?= yii::getalias('@web')?>/custom/images/curtain11.jpg" id="curtain2">
</div>
<!-- parda -->
<?php 
}
?>
<script>

</script>
<?php } ?>
<?php $this->endBody() ?>
<?php $this->endPage() ?>
<?php 
if(@$_GET['welcome'])
{
?>
<script type="text/javascript">
var state=false;

function open_curtain()
{
    $("#wrapper").show(1000)
 $("#curtain1").animate({width:20},1000);
 $("#curtain2").animate({width:20},1000);
}
function close_curtain()
{
    $("#wrapper").hide(500)
 $("#curtain1").animate({width:"51%"},500);
 $("#curtain2").animate({width:"51%"},500);
}
$('body').on('click', function(e) {
    // e.preventDefault();  
    open_curtain()
});
$("body").dblclick(function(e) {
    e.preventDefault();
    close_curtain()
});
</script>
<?php 
}
?>
