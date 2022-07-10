    <?php
use app\models\TpartnerDetail;
use app\models\CommonModel;
?>
<ul class="nav navbar-nav">
   

    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            preg_match('/tpartner\/create\b/', $_GET['r'])
            // ||preg_match('/tpartner/create\b/', $_GET['r'])
            ||preg_match('/tpartner\b/', $_GET['r'])
        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Approval Request</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <li><i class="fa fa-puzzle-piece"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tpartner/create">Approval Status</a></li>
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>

    <?php

 if(@CommonModel::getTpdetailbyuserid()['is_approved']==1):

      // target by admin
      $className="menu-close";
      if (isset($_GET['r'])) {
      $className = ((
        //   preg_match('/tar\/create\b/', $_GET['r'])
          // ||preg_match('/tpartner/create\b/', $_GET['r'])
          preg_match('/target\b/', $_GET['r'])
      )) ? "show" : "hide" ;

      }
  ?>
  <li class="menu-item-has-children dropdown  <?= $className; ?>">
      <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bullseye"></i>Targets</a>
      <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
          <!-- <li><i class="fa fa-plus-square"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tcenter/create">All</a></li> -->
      <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=target/assigned-index&filter=all">See All</a></li>
      <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=target/assigned-index&filter=applied">Applied </a></li>
      <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=target/assigned-index&filter=apply">Waiting for Response</a></li>
      <!-- <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=target/scheme-wise-index">Scheme wise </a></li> -->
          <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
      </ul>
  </li>
  <?php
      // target by admin
      $className="menu-close";
      if (isset($_GET['r'])) {
      $className = ((
        //   preg_match('/tar\/create\b/', $_GET['r'])
          // ||preg_match('/tpartner/create\b/', $_GET['r'])
          preg_match('/targetresponse\b/', $_GET['r'])
      )) ? "show" : "hide" ;

      }
  ?>
  <li class="menu-item-has-children dropdown  <?= $className; ?>">
      <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-reply"></i>Acknowledged Targets</a>
      <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
      <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=targetresponse">See All</a></li>
      <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=targetresponse/achieved">Approved Sub Targets </a></li>
      <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=targetresponse/declined">Declined Sub Targets </a></li>
    </ul>
  </li>

    <?php   $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            preg_match('/tcenter\/create\b/', $_GET['r'])
            // ||preg_match('/tpartner/create\b/', $_GET['r'])
            ||preg_match('/tcenter\b/', $_GET['r'])
        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-university"></i>Training Centers</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <li><i class="fa fa-plus-square"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tcenter/create">Create New</a></li>
        <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tcenter/index">All Centers</a></li>
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>

    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            strpos( $_GET['r'],'batch')===0

            // ||preg_match('/tpartner/create\b/', $_GET['r'])
            // ||preg_match('/tpartner\b/', $_GET['r'])
        )) ? "show" : "hide" ;

        }
    ?>

    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Manage Batches </a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <!-- <li><i class="fa fa-plus-square"></i><a href="<?=  Yii::$app->homeUrl ?>?r=batch/create">New Batch</a></li> -->
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=batch/center-index&type=3">All Batches</a></li>
            <li><i class="fa fa-backward"></i><a href="<?=  Yii::$app->homeUrl ?>?r=batch/center-index&type=0">Completed</a></li>
            <li><i class="fa fa-pause"></i><a href="<?=  Yii::$app->homeUrl ?>?r=batch/center-index&type=1">Running</a></li>
            <li><i class="fa fa-forward"></i><a href="<?=  Yii::$app->homeUrl ?>?r=batch/center-index&type=2">Upcoming</a></li>
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>

    <?php endif; ?>
    <!-- <h3 class="menu-title">Icons</h3><!-- /.menu-title -->

    <!-- <li class="menu-item-has-children dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Icons</a>
        <ul class="sub-menu children dropdown-menu">
            <li><i class="menu-icon fa fa-fort-awesome"></i><a href="font-fontawesome.html">Font Awesome</a></li>
            <li><i class="menu-icon ti-themify-logo"></i><a href="font-themify.html">Themefy Icons</a></li>
        </ul>
    </li> -->


</ul>
