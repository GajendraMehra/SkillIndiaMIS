<ul class="nav navbar-nav">
    <!-- <li class="active"> -->
    <!-- <h2 class="text-uppercase  mt-2 text-center"><a href="<?= Yii::$app->homeUrl ?>"><?= Yii::$app->config->get('mis-name','skill mis'); ?></a></h2> -->


    <!-- </li> -->
   <!-- <h3 class="menu-title">Accountant Menu</h3><!-- /.menu-title -->

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
    <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-inr"></i>Tranche</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
        <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=trans/index"> See All</a></li>
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=trans/index&TransDetail[claim_type]=0"> First Trans</a></li>
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=trans/index&TransDetail[claim_type]=1"> Second Trans</a></li>
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=trans/index&TransDetail[claim_type]=2"> Third Trans</a></li>
        </ul>
    </li>
    <?php
        // echo
        $className="menu-close";
        if (isset($_GET['r'])) {
        $className = ((
            strpos( $_GET['r'],'accdata')===0
            // ||preg_match('/tpartner/create\b/', $_GET['r'])
            // ||preg_match('/tpartner\b/', $_GET['r'])
        )) ? "show" : "hide" ;

        }
    ?>
    <li class="menu-item-has-children dropdown  <?= $className; ?>">
    <a href="#" clases="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-hdd"></i>Drive</a>
        <ul class="sub-menu children dropdown-menu <?= $className; ?><?= ' '.Yii::$app->config->get('sidemenu-theme','simple'); ?>">
            <li><i class="fa fa-podcast"></i><a href="<?=  Yii::$app->homeUrl ?>?r=accdata"> See All Data</a></li>
        </ul>
    </li>



</ul>
