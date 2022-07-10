<?php
use app\models\Scheme;
use app\models\Sector;
use app\models\Job;
use app\models\TpartnerDetail;
use app\models\CommonModel;
use app\models\Targets;
use app\models\Tcdetail;
use app\models\TargetsResponse;
use app\models\TransDetail;
use yii\helpers\Url;
// use dosamigos\leaflet\types\LatLng;
// use dosamigos\leaflet\layers\Marker;
// use dosamigos\leaflet\layers\TileLayer;
// use dosamigos\leaflet\LeafLet;
// use dosamigos\leaflet\widgets\Map;
$data=CommonModel::getStudentData();
$allTranche=TransDetail::find();
$money= $allTranche->where(['status'=>3])->sum('net_amount');

$dis= json_encode(implode(', ', array_column($data, 'name')));
$studentArray=implode(', ', array_column($data, 'students'));
$students= json_encode($studentArray);
// print_r($data);
// echo $dis;
$waitingTranche= $allTranche->where(['status'=>0])->count();
$disapprovedTranche= $allTranche->where(['status'=>2])->count();
$targetWaiting= TargetsResponse::find()->where(['status'=>0])->groupBy('target_id')->count();
?>
<style>
.fc-title{
  color: wheat !important ;
font-size: 1.5em !important;

}
.fc-content{
    cursor:pointer !important;
    
}
</style>


<div class="row">
    <div class="col-sm-12 mb-4">
        <div class="">
            <div class="card col-lg-6 col-xl-3 col-md-4 no-padding bg-flat-color-1">
                <div class="card-body">
                    <div class="h1 text-muted text-right mb-0">
                        <i class="fa fa-pie-chart text-light"></i>
                    </div>
                    <div class="h4 mb-0 text-light">
                        <span class="count">
                            <?= Sector::find()->count()?>
                        </span>
                    </div>
                    <small class="text-uppercase font-weight-bold text-light">
                        <a class="text-white" href="
							<?= Url::base().'/index.php?r=sector/index'?>">Registered Sectors
                        </a>
                    </small>
                    <div class="progress progress-xs mt-3 mb-0 bg-light" style="width: 40%; height: 5px;"></div>
                </div>
            </div>
            <div class="card col-lg-4 col-xl-3 col-md-4 no-padding no-shadow">
                <div class="card-body bg-flat-color-2">
                    <div class="h1 text-muted text-right mb-0">
                        <!-- <i class="menu-icon fa fa-wrench"></i> -->
                        <i class="fa fa-wrench text-light"></i>
                    </div>
                    <div class="h4 mb-0 text-light">
                        <span class="count">
                            <?= Job::find()->count()?>
                        </span>
                    </div>
                    <small class="text-uppercase font-weight-bold text-light">
                        <a class="text-white" href="
							<?= Url::base().'/index.php?r=job/index'?>">New Jobs
                        </a>
                    </small>
                    <div class="progress progress-xs mt-3 mb-0 bg-light" style="width: 40%; height: 5px;"></div>
                </div>
            </div>
            <div class="card col-lg-4 col-xl-3 col-md-4 no-padding no-shadow">
                <div class="card-body bg-flat-color-3">
                    <div class="h1 text-right mb-0">
                        <i class="fa fa-laptop text-light"></i>
                    </div>
                    <div class="h4 mb-0 text-light">
                        <span class="count">
                            <?= Scheme::find()->count()?>
                        </span>
                    </div>
                    <small class="text-uppercase font-weight-bold text-light">
                        <a class="text-white" href="
							<?= Url::base().'/index.php?r=scheme/index'?>">Registered Schemes
                        </a>
                    </small>
                    <div class="progress progress-xs mt-3 mb-0 bg-light" style="width: 40%; height: 5px;"></div>
                </div>
            </div>
            <div class="card col-lg-4 col-xl-3 col-md-4 no-padding no-shadow">
                <div class="card-body bg-flat-color-5">
                    <div class="h1 text-right text-light mb-0">
                        <i class="fa fa-building"></i>
                    </div>
                    <div class="h4 mb-0 text-light">
                        <span class="count">
                             <?= TpartnerDetail::find()->where(['final_submit'=>1 ,'is_approved' => 1])->count() ?> 
                        </span>

                    </div>
                    <small class="text-uppercase font-weight-bold text-light">
                        <a class="text-white" href="
							<?= Url::base().'/index.php?r=tpartner&TpartnerDetail[is_approved]=1'?>">Training Partner Approved
                        </a>
                    </small>
                    <div class="progress progress-xs mt-3 mb-0 bg-light" style="width: 40%; height: 5px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-5 col-sm-12">
        <div class="card">
            <div class="card-header">
                <a href="
					<?= Yii::$app->homeUrl ?>?r=student/index">
                    <strong class="card-title mb-3">Student Registered :
                        <?=array_sum(array_column($data, 'students')) ?>
                    </strong>
                </a>
            </div>
            <div class="card-body">
                <div class="chart">
                   
                    <canvas id="barChart"
                      
                        width="200" height="200" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-12 col-xl-7 col-sm-12">
        <div class="row">
            <div class="col-md-6 col-lg-12 col-xl-6 col-sm-12">
                <div class="">
                    <div class="card">
                        <div class="card-body">
                            <div class="clearfix">
                                <i class="fa fa-cogs bg-flat-color-5 p-3 font-2xl mr-3 float-left text-light"></i>
                                <div class="h5 text-secondary mb-0 mt-1">
                                    <?= TpartnerDetail::find()->where(['final_submit'=>1,'is_approved'=>1])->count() ?>
                                </div>
                                <div class="text-muted text-uppercase font-weight-bold font-xs small">
                                    <a class="text-" href="
										<?= Url::base().'/index.php?r=tpartner&TpartnerDetail[is_approved]=1'?>">Active Training Partners
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="card">
                        <div class="card-body">
                            <div class="clearfix">
                                <i class="fa fa-bullseye bg-flat-color-5 p-3 font-2xl mr-3 float-left text-light"></i>
                                <div class="h5 text-secondary mb-0 mt-1">
                                    <?= Targets::find()->where(['status'=>1])->count();?>
                                </div>
                                <div class="text-muted text-uppercase font-weight-bold font-xs small">
                                    <a class="text-" href="
										<?= Url::base().'/index.php?r=target/index&filter=all'?>">Active Targets
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="card">
                        <div class="card-body">
                            <div class="clearfix">
                                <i class="fa fa-bullseye bg-flat-color-5 p-3 font-2xl mr-3 float-left text-light"></i>
                                <div class="h5 text-secondary mb-0 mt-1">
                                    <?= Tcdetail::find()->count();?>
                                </div>
                                <div class="text-muted text-uppercase font-weight-bold font-xs small">
                                    <a class="text-" href="
										<?= Url::base().'/index.php?r=tcenter/admin-index'?>">Training Centers
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-12 col-xl-6 col-sm-12">
         
            <div class="card">
            <div class="card-body">
                <div class="clearfix">
                   <?php
                     if($waitingTranche !=0):
                        echo'<i class="spinner-grow text-danger float-left  mr-3 " role="status"> <span class="sr-only">Loading...</span></i>';
                    else:
                        echo' <i class="fa fa-bell bg-warning bg-warning p-3 font-2xl mr-3 float-left text-light"></i>';
                        
                    endif;
                    ?>
                    <div class="h5 text-secondary mb-0 mt-1"><?= $waitingTranche ?>  Tranche </div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs small">Waiting for Response</div>
                </div>
                <div class="b-b-1 pt-3"></div>
                <hr>
                <div class="more-info pt-2" style="margin-bottom:-10px;">
                <a class="font-weight-bold font-xs btn-block text-muted small" href="<?= Url::base().'/index.php?r=trans/index&TransDetail[status]=0'?>">View  <i class="fa fa-angle-right float-right font-lg"></i></a>
                </div>
            </div>
            </div>

            <div class="card">
            <div class="card-body">
                <div class="clearfix">
             
                <?php
                  
                    if($targetWaiting !=0):
                        echo'<i class="spinner-grow text-danger float-left  mr-3 " role="status"> <span class="sr-only">Loading...</span></i>';
                    else:
                        echo' <i class="fa fa-bell bg-warning bg-warning p-3 font-2xl mr-3 float-left text-light"></i>';
                        
                    endif;
                    ?>

                    <div class="h5 text-secondary mb-0 mt-1"><?= $targetWaiting ?> Target</div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs small">Waiting for Response</div>
                </div>
                <div class="b-b-1 pt-3"></div>
                <hr>
                <div class="more-info pt-2" style="margin-bottom:-10px;">
                <a class="font-weight-bold font-xs btn-block text-muted small" href="<?= Url::base().'/index.php?r=target/acknowledge&filter=applied'?>">View More <i class="fa fa-angle-right float-right font-lg"></i></a>
                </div>
            </div>
            </div>

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
</div>


<!-- Third Row  -->
<div class="row">
    <div class="col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-four">
                    <div class="stat-icon dib">
                        <?php

                        if(TpartnerDetail::find()->where(['final_submit'=>1 ,'is_approved' => 2])->count() !=0):
                            echo'<i class="spinner-grow text-danger float-left  mr-3 " role="status"> <span class="sr-only">Loading...</span></i>';
                        else:
                            echo'<i class="fa fa-exclamation-circle text-muted"></i>';
                            
                        endif;
                        ?>
                        
                       
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <a class="text-dark" href="
                                <?= Url::base().'/index.php?r=tpartner&TpartnerDetail[is_approved]=2'?>">
                                <div class="stat-heading">T.P Waiting for Approval</div>
                            </a>
                            <div class="stat-text">Total:
                                <a class="text-dark" href="
                                    <?= Url::base().'/index.php?r=tpartner&TpartnerDetail[is_approved]=2'?>">
                                    <?= (TpartnerDetail::find()->where(['final_submit'=>1 ,'is_approved' => 2])->count())?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-four">
                    <div class="stat-icon dib">
                        <i class="fa fa-times text-muted"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <a class="text-dark" href="
                                <?= Url::base().'/index.php?r=tpartner&TpartnerDetail[is_approved]=2'?>">
                                <div class="stat-heading">T.P Rejected </div>
                            </a>
                            <div class="stat-text">Total:
                                <a class="text-dark" href="
                                    <?= Url::base().'/index.php?r=tpartner&TpartnerDetail[is_approved]=0'?>">
                                    <?= (TpartnerDetail::find()->where(['final_submit'=>1 ,'is_approved' => 0])->count())?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-four">
                    <div class="stat-icon dib">
                        <i class="fa fa-check-square text-muted"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <a class="text-dark" href="
                                <?= Url::base().'/index.php?r=tpartner&TpartnerDetail[is_approved]=1'?>">
                                <div class="stat-heading">T.P Approved </div>
                            </a>
                            <input type="hidden" id="batchurl" value="
                                <?= Yii::$app->homeUrl ?>?r=batch/view&id">
                            <div class="stat-text">Total:
                                <a class="text-dark" href="
                                        <?= Url::base().'/index.php?r=tpartner&TpartnerDetail[is_approved]=1'?>">
                                    <?= (TpartnerDetail::find()->where(['final_submit'=>1 ,'is_approved' => 1])->count())?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

 function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++ ) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    function replaceAll(str, find, replace) {
  return str.replace(new RegExp(find, 'g'), replace);
}

    var ctx = document.getElementById('barChart');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?= $dis ?>.split(","),

            datasets: [{
                label: 'No of Students',
                data:<?= $students ?>.split(","),
                backgroundColor: [
                    "#FF6384",
                    "#63FF84",
                    "#84FF63",
                    "#8463FF",
                    "#6384FF",
                    "#97EAD2",
                    "#8CC7A1",
                    "#816E94",
                    "#74226C",
                    "#FCDDBC",
                    "#4B2142",
                    "#69585F",
                    "#EF959D",
                ]
            
            }]
        },
        options: {
            showAllTooltips: true,
            legend: {
                display: true,
                position:'bottom',
                labels: {
                    // This more specific font property overrides the global property
                    fontColor: 'black',
                    fontStyle: 'normal',
                    // fontSize:'1'
                }
            },
            tooltips: {
                display: true,
                options: {
                }

            },


            scales: {
                yAxes: [],
                xAxes: []
            
            }
        },
        label: {
                font: {
                    family: "Georgia"
                }
            }
    });
    })


$('.fc-content').click(()=>{
  alert()
})
</script>
