<?php
use app\models\search\Targets as TargetsSearch;

use app\models\Targets;
use yii\Html;

use app\models\TargetsResponse;
use app\models\CommonModel;
 $tpdetails=CommonModel::getTpdetailbyuserid();
 $allTargets =Targets::find()->where(['tp_id'=>@$tpdetails['id']])->count();
 $appliedTargets =TargetsResponse::find()->where(['tp_id'=>@$tpdetails['id']])->groupBy('target_id')->count();
 $reviewedTargets =TargetsResponse::find()->where(['tp_id'=>@$tpdetails['id']])->groupBy('target_id')->where(['!=', 'status', 0])->count();

 function getLoginStatusInst(){
    $connection = Yii::$app->getDb();
    $sql="select u.username,u.email,u.status,tc.id as tc_id from user as u
    inner join tbl_tcdetail as tc on tc.email = u.email 
   inner join tbl_tpartner_detail as tp on tp.id = tc.tp_id where tp.edited_by=".Yii::$app->user->identity->id;

    $command = $connection->createCommand($sql);

    $result = $command->queryAll();
    foreach ($result as $key => $value) {
      switch ($value['status']) {
        case '10':
           $result[$key]['badge']='success';
           $result[$key]['acc_status']='Active';
        break;
          
        case '9':
            $result[$key]['badge']='warning';
            $result[$key]['acc_status']='Waiting for Email Verification';
         break;
          default:
          $result[$key]['badge']='danger';
          $result[$key]['acc_status']='Suspended by admin';
        break;
      }
    }
 
    return $result;


}


?>
<!-- <h2>sd</h2> -->
<?php  if(@CommonModel::getTpdetailbyuserid()['is_approved']==1): ?>
<div class="row">
    <div class="col-md-6 col-sm-12 col-lg-3 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="clearfix">
                    <i class="fa fa-bullseye bg-info p-3 font-2xl mr-3 float-left text-light"></i>
                    <div class="h5 text-secondary mb-0 mt-1"><?= $allTargets ?></div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs small">Total Targets </div>
                </div>
                <div class="b-b-1 pt-3"></div>
                <hr>
                <div class="more-info pt-2" style="margin-bottom:-10px;">
                    <a class="font-weight-bold font-xs btn-block text-muted small"
                        href="index.php?r=target/assigned-index&filter=all">View More <i
                            class="fa fa-angle-right float-right font-lg"></i></a>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-6 col-sm-12 col-lg-3 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="clearfix">
                    <i class="fa fa-mail-reply-all bg-flat-color-5 p-3 font-2xl mr-3 float-left text-light"></i>
                    <div class="h5 text-secondary mb-0 mt-1"><?= $appliedTargets ?></div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs small">Targets Responded by you</div>
                </div>
                <div class="b-b-1 pt-3"></div>
                <hr>
                <div class="more-info pt-2" style="margin-bottom:-10px;">
                    <a class="font-weight-bold font-xs btn-block text-muted small"
                        href="index.php?r=target/assigned-index&filter=applied">View More <i
                            class="fa fa-angle-right float-right font-lg"></i></a>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12 col-lg-3 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="clearfix">
                    <?php

                if($allTargets-$appliedTargets>0):
                    echo'<i class="fa spinner-grow text-danger float-left p-3   mr-3 " role="status"> <span class="sr-only">Loading...</span></i>';
                else:
                    echo' <i class="fa fa-bell bg-danger bg-warning p-3 font-2xl mr-3 float-left text-light"></i>';
                    
                endif;
                ?>
                    <div class="h5 text-secondary mb-0 mt-1"><?=$allTargets-$appliedTargets ?> Target</div>

                    <div class="text-muted text-uppercase font-weight-bold font-xs small">Waiting for your response
                    </div>
                </div>
                <div class="b-b-1 pt-3"></div>
                <hr>
                <div class="more-info pt-2" style="margin-bottom:-10px;">
                    <a class="font-weight-bold font-xs btn-block text-muted small"
                        href="index.php?r=target/assigned-index&filter=apply">View More <i
                            class="fa fa-angle-right float-right font-lg"></i></a>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12 col-lg-3 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="clearfix">
                    <i class="fa fa-check-square bg-flat-color-5 p-3 font-2xl mr-3 float-left text-light"></i>
                    <div class="h5 text-secondary mb-0 mt-1"><?= $appliedTargets ?> </div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs small">Targets Responses Reviewed By
                        Admin</div>
                </div>
                <div class="b-b-1 pt-3"></div>
                <hr>
                <div class="more-info pt-2" style="margin-bottom:-10px;">
                    <a class="font-weight-bold font-xs btn-block text-muted small"
                        href="index.php?r=targetresponse">View More <i
                            class="fa fa-angle-right float-right font-lg"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Account alert -->
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <aside class="profile-nav alt">
            <section class="card">
                <div class="card-header user-header alt ">
                    <div class="media">
                      
                        <div class="media-body">
                            <h5 class=" display-6">Training Centers </h5>
                            <p>Account Status</p>
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                <?php    foreach (getLoginStatusInst() as $bar):?>
                    <li class="list-group-item">
                      <i class="fa fa-user"></i> 
                        <a class="text-primary" href='<?=Yii::$app->homeUrl ?>?r=tcenter/view&id=<?= $bar["tc_id"] ?>'>
                        <?= $bar['email'] ?>
                       <span class="badge badge-<?= $bar['badge'] ?> pull-right"><?= $bar['acc_status'] ?></span>
                                </a>
                    </li>
                   
                <?php endforeach; ?>
                   
                </ul>
            </section>
        </aside>
    </div>

</div>
<?php else: ?>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="text-center">
            <div class=" alert alert-secondary text-center" role="alert">
                <h3 class="text-center"> You are not an approved Training Partner .</h3>
            </div>
            <a href="index.php?r=tpartner/create" class="btn btn-success btn-lg active" role="button"
                aria-pressed="true">Apply for Approval</a>
        </div>
    </div>
    <?php endif; ?>
