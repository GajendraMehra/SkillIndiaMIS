<?php use app\models\TpartnerDetail;
$tp_pending=TpartnerDetail::find()->where(['is_approved' => 2,'final_submit' => 1])->count();
?>
<style>
    	.blink{
	
	    background-color: magenta;

	}
.blinkme{
		/* font-size: 25px; */
		font-family: cursive;
		color: white;
		animation: blink 1s linear infinite;
	}
@keyframes blink{
0%{opacity: 0;}
50%{opacity: .5;}
100%{opacity: 1;}
}
</style>
<ul class="nav navbar-nav">
    <!-- <li class="">
    <h2 class="text-uppercase  mt-2 text-center"><a href="<?= Yii::$app->homeUrl ?>"></a></h2>
    </li> -->
    <!-- <h3 class="menu-title"><?= Yii::$app->config->get('mis-name','skill mis'); ?></h3>/.menu-title -->



    <!--  Rate-->
    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            preg_match('/rate\b/', $_GET['r'])

        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?> ">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-inr"></i>Rates</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <li><i class="fa fa-plus-square"></i><a href="<?=  Yii::$app->homeUrl ?>?r=rate/create">Create Rate</a></li>
            <li><i class="fa fa-list-ul"></i><a href="<?=  Yii::$app->homeUrl ?>?r=rate/index">Manage Rate</a></li>
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>
    <!--  Sector-->
    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
          strpos( $_GET['r'],'sector')===0


        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cog"></i>Sectors</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <li><i class="fa fa-plus-square"></i><a href="<?=  Yii::$app->homeUrl ?>?r=sector/create">Create Sector</a></li>
            <li><i class="fa fa-list-ul"></i><a href="<?=  Yii::$app->homeUrl ?>?r=sector/index">Manage Sector</a></li>
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>
    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            strpos( $_GET['r'],'subsector')===0

        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pie-chart"></i>Sub Sectors</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <li><i class="fa fa-plus-square"></i><a href="<?=  Yii::$app->homeUrl ?>?r=subsector/create">Create Sub Sector</a></li>
            <li><i class="fa fa-list-ul"></i><a href="<?=  Yii::$app->homeUrl ?>?r=subsector/index">Manage Sub Sector</a></li>
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>
    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            preg_match('/job\b/', $_GET['r'])

        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-wrench"></i>Jobs</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <li><i class="fa fa-plus-square"></i><a href="<?=  Yii::$app->homeUrl ?>?r=job/create">Create Job</a></li>
            <li><i class="fa fa-list-ul"></i><a href="<?=  Yii::$app->homeUrl ?>?r=job/index">Manage Job</a></li>
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>

    <!-- Scheme  -->
    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            preg_match('/scheme\b/', $_GET['r'])

        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Schemes</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <li><i class="fa fa-plus-square"></i><a href="<?=  Yii::$app->homeUrl ?>?r=scheme/create">Create Scheme</a></li>
            <li><i class="fa fa-list-ul"></i><a href="<?=  Yii::$app->homeUrl ?>?r=scheme">Manage Scheme</a></li>
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>




    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            preg_match('/tpartner\b/', $_GET['r'])


        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-building menu-icon" aria-hidden="true"></i>Training Partners</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
        <li><i class="fa fa-check-square" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tpartner&TpartnerDetail[is_approved]=1">Approved</a></li>
        <li><i class="fa fa-window-close" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tpartner&TpartnerDetail[is_approved]=0">Not Approved</a></li>
        <li><i class="fa fa-exclamation-triangle"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tpartner&TpartnerDetail[is_approved]=2"> Pending <?= ($tp_pending>0) ? '<span class="badge badge-info">'.$tp_pending.'</span>' : '' ?></span></a></li>
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>
    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            preg_match('/tcenter\b/', $_GET['r'])


        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-building menu-icon" aria-hidden="true"></i>Training Centers</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
        <li><i class="fa fa-check-square" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tcenter/admin-index">See All</a></li>
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>   
    <!-- 

    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            preg_match('/target\b/', $_GET['r'])

        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-bullseye menu-icon "></i>Targets</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <li><i class="fa fa-plus-square" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=target/create">Create Target</a></li>
            <li><i class="fa fa-list-ul" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=target/index&filter=all">Manage Target</a></li>
            <li><i class="fa fa-file-word-o" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=target/acknowledge&filter=applied">Training Partner Response</a></li>
        </ul>
    </li>
     -->
     <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            preg_match('/target\b/', $_GET['r'])


        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-bullseye menu-icon" aria-hidden="true"></i>Manage Targets</a>
        <ul class="sub-menu children dropdown-menu <?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
        <li><i class="fa fa-check-square" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=target/create">Create Target</a></li>
        <li><i class="fa fa-list-ul" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=target/index&filter=all">Manage Target</a></li>
        <li><i class="fa fa-file-word-o"></i><a href="<?=  Yii::$app->homeUrl ?>?r=target/acknowledge&filter=applied"> TP Response </a></li>
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>

    <!-- Targets -->
   
    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            preg_match('/student\b/', $_GET['r'])


        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa  fa-graduation-cap menu-icon" aria-hidden="true"></i>Student Section</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
        <li><i class="fa fa-check-square" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=student/">All Students </a></li>
        <!-- <li><i class="fa fa-window-close" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=student/create">Add 
         </a></li> -->

        <!-- <li><i class="fa fa-window-close" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tpartner&TpartnerDetail[is_approved]=0">District Wise </a></li> -->
        <!-- <li><i class="fa fa-exclamation-triangle"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tpartner&TpartnerDetail[is_approved]=2"> Pending <?= ($tp_pending>0) ? '<span class="badge badge-info">'.$tp_pending.'</span>' : '' ?></span></a></li> -->
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
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Student Batches </a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=batch/index&type=3">All Batches</a></li>
            <li><i class="fa fa-backward"></i><a href="<?=  Yii::$app->homeUrl ?>?r=batch/index&type=0">Completed</a></li>
            <li><i class="fa fa-pause"></i><a href="<?=  Yii::$app->homeUrl ?>?r=batch/index&type=1">Running</a></li>
            <li><i class="fa fa-forward"></i><a href="<?=  Yii::$app->homeUrl ?>?r=batch/index&type=2">Upcoming</a></li>
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>



    <?php
        // echo
        $className="menu-close ";
        if (isset($_GET['r'])) {
        $className = ((
            strpos( $_GET['r'],'attendance')===0
            // ||preg_match('/tpartner/create\b/', $_GET['r'])
            // ||preg_match('/tpartner\b/', $_GET['r'])
        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-pencil-square-o"></i>Attendance Section</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <!-- <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=attendance/index&type=1">Today's Attendance</a></li> -->
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
            preg_match('/accountant\b/', $_GET['r'])
        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-user menu-icon" aria-hidden="true"></i>Accountant Section</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
        <li><i class="fa fa-check-square" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=accountant/">All Accountant </a></li>
        <li><i class="fa fa-window-close" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=accountant/create">Add New </a></li>
        <!-- <li><i class="fa fa-exclamation-triangle"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tpartner&TpartnerDetail[is_approved]=2"> Pending <?= ($tp_pending>0) ? '<span class="badge badge-info">'.$tp_pending.'</span>' : '' ?></span></a></li> -->
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>

    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            preg_match('/manager\b/', $_GET['r'])
        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-user menu-icon" aria-hidden="true"></i>Manager Section </a><span class="blink"></span>

        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
        <li><i class="fa fa-check-square" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=manager/">All Managers </a></li>
        <li><i class="fa fa-window-close" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=manager/create">Add New </a></li>
        <!-- <li><i class="fa fa-exclamation-triangle"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tpartner&TpartnerDetail[is_approved]=2"> Pending <?= ($tp_pending>0) ? '<span class="badge badge-info">'.$tp_pending.'</span>' : '' ?></span></a></li> -->
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>
    
      <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-user menu-icon" aria-hidden="true"></i>Training Request </a><span class="blink"><span class="blinkme">New</span></span>

        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
        <li><i class="fa fa-check-square" aria-hidden="true"></i><a href="http://mis.uksdm.org/app/register/student_reg/studentrecord.php">All Students </a></li>
      
        <!-- <li><i class="fa fa-exclamation-triangle"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tpartner&TpartnerDetail[is_approved]=2"> Pending <?= ($tp_pending>0) ? '<span class="badge badge-info">'.$tp_pending.'</span>' : '' ?></span></a></li> -->
            <!-- <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> -->
        </ul>
    </li>
    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            preg_match('/cresponse\b/', $_GET['r'])
        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-robot menu-icon"></i>Center Bot</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
        <li><i class="fa fa-check-square" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=cresponse/">Center Response </a></li>
        <!-- <li><i class="fa fa-window-close" aria-hidden="true"></i><a href="<?=  Yii::$app->homeUrl ?>?r=accountant/create">Add New </a></li> -->
        <!-- <li><i class="fa fa-exclamation-triangle"></i><a href="<?=  Yii::$app->homeUrl ?>?r=tpartner&TpartnerDetail[is_approved]=2"> Pending <?= ($tp_pending>0) ? '<span class="badge badge-info">'.$tp_pending.'</span>' : '' ?></span></a></li> -->
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
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Tranche Requests</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=trans/index"> See All</a></li>
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=trans/index&TransDetail[claim_type]=0"> First Trans</a></li>
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=trans/index&TransDetail[claim_type]=1"> Second Trans</a></li>
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=trans/index&TransDetail[claim_type]=2"> Third Trans</a></li>
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=trans/index&TransDetail[claim_type]=3"> Reassesment 1</a></li>
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=trans/index&TransDetail[claim_type]=4"> Reassesment 2</a></li>
        </ul>
    </li>
    
     <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            strpos( $_GET['r'],'user/alluser')===0
            ||strpos( $_GET['r'],'user/view')===0
            // ||preg_match('/tpartner/create\b/', $_GET['r'])
            // ||preg_match('/tpartner\b/', $_GET['r'])
        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
        <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-users"></i>All Users</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=user/alluser"> See All</a></li>
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=user/alluser&Users[role]=2"> Training Partners</a></li>
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=user/alluser&Users[role]=3"> Training Centers</a></li>
            
        </ul>
    </li>


</ul>
