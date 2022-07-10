<ul class="nav navbar-nav">
    <li class="active">
    <!-- <h2 class="text-uppercase  mt-2 text-center"><a href="<?= Yii::$app->homeUrl ?>"><?= Yii::$app->config->get('mis-name','skill mis'); ?></a></h2> -->


    </li>
    <h3 class="menu-title">Training Center Menu</h3><!-- /.menu-title -->

    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
          preg_match('/tcenter\/my-center\b/', $_GET['r'])
        ||  preg_match('/tcenter\/my-tp\b/', $_GET['r'])
        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Center Profile </a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?> ">
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tcenter/my-center">My Profile</a></li>
            <li><i class="fa fa-plus-square"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tcenter/my-tp">Parent TP</a></li>
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>

    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((

            preg_match('/tcenter\/targets\b/', $_GET['r'])
            // ||preg_match('/tpartner\b/', $_GET['r'])
        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Assigned Targets </a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tcenter/targets">See All</a></li>
            <!-- <li><i class="fa fa-plus-square"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tcenter/my-tp">Parent TP</a></li> -->
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>
    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            preg_match('/student\b/', $_GET['r'])
            // ||preg_match('/tpartner/create\b/', $_GET['r'])
            // ||preg_match('/tpartner\b/', $_GET['r'])
        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Manage Students </a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=student/my-students">All Students</a></li>
            <li><i class="fa fa-plus-square"></i><a href="<?=  Yii::$app->homeUrl ?>?r=student/create">Add Student</a></li>
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
            <li><i class="fa fa-plus-square"></i><a href="<?=  Yii::$app->homeUrl ?>?r=batch/create">New Batch</a></li>
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=batch/index&type=3">All Batches</a></li>
            <li><i class="fa fa-backward"></i><a href="<?=  Yii::$app->homeUrl ?>?r=batch/index&type=0">Completed</a></li>
            <li><i class="fa fa-pause"></i><a href="<?=  Yii::$app->homeUrl ?>?r=batch/index&type=1">Running</a></li>
            <li><i class="fa fa-forward"></i><a href="<?=  Yii::$app->homeUrl ?>?r=batch/index&type=2">Upcoming</a></li>
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>


    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            strpos( $_GET['r'],'attendance')===0
            // ||preg_match('/tpartner/create\b/', $_GET['r'])
            // ||preg_match('/tpartner\b/', $_GET['r'])
        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Manage Attendance </a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=attendance/index&type=1">Today's Attendance</a></li>
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=attendance/all-batch&type=3">Attendance Report</a></li>
            <!-- <li><i class="fa fa-plus-square"></i><a href="<?=  Yii::$app->homeUrl ?>?r=student/create">See Attendance</a></li> -->
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>
  <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            strpos( $_GET['r'],'trans')===0
            // ||preg_match('/tpartner/create\b/', $_GET['r'])
            // ||preg_match('/tpartner\b/', $_GET['r'])
        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Claim Tranche </a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=trans/create">New Tranche</a></li>
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=trans">Tranche Status</a></li>
            <!-- <li><i class="fa fa-plus-square"></i><a href="<?=  Yii::$app->homeUrl ?>?r=student/create">See Attendance</a></li> -->
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>

    <!-- <h3 class="menu-title">Icons</h3><!-- /.menu-title -->

    <!-- <li class="menu-item-has-children dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Icons</a>
        <ul class="sub-menu children dropdown-menu">
            <li><i class="menu-icon fa fa-fort-awesome"></i><a href="font-fontawesome.html">Font Awesome</a></li>
            <li><i class="menu-icon ti-themify-logo"></i><a href="font-themify.html">Themefy Icons</a></li>
        </ul>
    </li> -->


</ul>
