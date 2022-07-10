<?php
use app\models\TransDetail;
use yii\helpers\Url;

$allTranche=TransDetail::find();
$allTranche1=TransDetail::find();
$app= $allTranche->where(['status'=>3])->count();
$money= $allTranche->where(['status'=>3])->sum('net_amount');
$dis= $allTranche->where(['status'=>4])->count();
$waitadmin= $allTranche->where(['status'=>0])->count();
$tranchWaiting=$allTranche->where(['status'=>1])->count()

?>

<div class="row">
<!-- <h2>sd</h2> -->
<div class="col-sm-12 col-12">
  
    <div class="col-6 col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="clearfix">
                    <i class="fa fa-bullseye bg-info p-3 font-2xl mr-3 float-left text-light"></i>
                    <div class="h5 text-secondary mb-0 mt-1"><?= $allTranche1->count()-$waitadmin ?></div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs small">Total Tranche  </div>
                </div>
                <div class="b-b-1 pt-3"></div>
                <hr>
                <div class="more-info pt-2" style="margin-bottom:-10px;">
                    <a class="font-weight-bold font-xs btn-block text-muted small" href="<?= Url::base().'/index.php?r=trans/index'?>">View More <i class="fa fa-angle-right float-right font-lg"></i></a>
                </div>
            </div>
        </div>

    </div>

    <div class="col-6 col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="clearfix">
                    <i class="fa fa-mail-reply-all bg-flat-color-5 p-3 font-2xl mr-3 float-left text-light"></i>
                    <div class="h5 text-secondary mb-0 mt-1"><?= $app+$dis ?></div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs small">Tranche Responded by you</div>
                </div>
                <div class="b-b-1 pt-3"></div>
                <hr>
                <div class="more-info pt-2" style="margin-bottom:-10px;">
                <a class="font-weight-bold font-xs btn-block text-muted small" href="<?= Url::base().'/index.php?r=trans/index'?>">View More <i class="fa fa-angle-right float-right font-lg"></i></a>

                </div>
            </div>
        </div>
    </div>

 
    <div class="col-6 col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="clearfix">
                   
                   
                    <?php

                     if($tranchWaiting >0):
                         echo'<i class="spinner-grow text-danger float-left  mr-3 " role="status"> <span class="sr-only">Loading...</span></i>';
                     else:
                         echo' <i class="fa fa-bell bg-warning bg-warning p-3 font-2xl mr-3 float-left text-light"></i>';
                         
                     endif;
                 ?>
                     <div class="h5 text-secondary mb-0 mt-1"><?= $tranchWaiting ?></div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs small">Waiting for Response </div>
                </div>
                <div class="b-b-1 pt-3"></div>
                <hr>
                <div class="more-info pt-2" style="margin-bottom:-10px;">
                <a class="font-weight-bold font-xs btn-block text-muted small" href="<?= Url::base().'/index.php?r=trans/index'?>">View More <i class="fa fa-angle-right float-right font-lg"></i></a>
                </div>
            </div>
        </div>
    </div>
    

    <div class="col-6 col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="clearfix">
                <i class="fa fa-money bg-primary p-3 font-2xl mr-3 float-left text-light"></i>
                     <div class="h5 text-secondary mb-0 mt-1">&#x20b9;<?= $money ?></div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs small">Money Approved </div>
                </div>
                <div class="b-b-1 pt-3"></div>
                <hr>
                <div class="more-info pt-2" style="margin-bottom:-10px;">
                <a class="font-weight-bold font-xs btn-block text-muted small" href="<?= Url::base().'/index.php?r=trans/index'?>">View More <i class="fa fa-angle-right float-right font-lg"></i></a>
                </div>
            </div>
        </div>
    </div>
    


</div>
</div>

