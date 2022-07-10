<?php
use app\models\CommonModel;
use app\models\TargetBatch;
use app\models\TargetsResponse;
use yii\helpers\Url;
use app\models\TransDetail;

$tcdetails=CommonModel::getTcdetailbyuserid();
$data=CommonModel::getStudentData($tcdetails['id']);

$totalbatch=TargetBatch::find()->where(['tc_id'=>$tcdetails['id']])->count();
$submittedbatch=TargetBatch::find()->where(['tc_id'=>$tcdetails['id'],'final_submit'=>1])->count();
$pendingbatch=TargetBatch::find()->where(['tc_id'=>$tcdetails['id'],'final_submit'=>0])->count();
$dis= json_encode(implode(', ', array_column($data, 'name')));
$studentArray=implode(', ', array_column($data, 'students'));
$students= json_encode($studentArray);
$assignTargets=TargetsResponse::find()->where(['tc_id'=>$tcdetails['id'],'status'=>1])->count();
$assignJobs=TargetsResponse::find()->select('job_id')->distinct()->where(['tc_id'=>$tcdetails['id'],'status'=>1])->count();

$money = TransDetail::find()->innerJoin("tbl_target_batch", "tbl_target_batch.id=trans_details.batch_id")
->innerJoin("tbl_tcdetail", "tbl_tcdetail.id=tbl_target_batch.tc_id")
->where(["tbl_tcdetail.id"=>$tcdetails['id'],'trans_details.status'=>3 ])->sum('net_amount');

;
?>

<div class="row">
<!-- <h2>sd</h2> -->


<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12">
  <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="clearfix">
                                    <i class="fa fa-cogs bg-flat-color-5 p-3 font-2xl mr-3 float-left text-light"></i>
                                    <div class="h5 text-secondary mb-0 mt-1"><?= $assignTargets ?></div>
                                    <div class="text-muted text-uppercase font-weight-bold font-xs small">  <a class="text-" href="<?=  Yii::$app->homeUrl ?>?r=tcenter/targets">Targets Assigned</a> </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="clearfix">
                                    <i class="fa fa-bullseye bg-flat-color-5 p-3 font-2xl mr-3 float-left text-light"></i>
                                    <div class="h5 text-secondary mb-0 mt-1"><?= $assignJobs; ?></div>
                                    <div class="text-muted text-uppercase font-weight-bold font-xs small">  <a class="text-" href="<?=  Yii::$app->homeUrl ?>?r=tcenter/targets">Jobs Assigned</a> </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
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

                    <div class="col-md-12 col-lg-12 col-xl-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                            <a href="<?= Yii::$app->homeUrl ?>?r=student/my-students">
                                <strong class="card-title mb-3">Student Registered : <?=array_sum(array_column($data, 'students')) ?></strong>
                                </a>
                            </div>
                            <div class="card-body">
                            <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                <canvas id="barChart"class=""></canvas>
                                </div>
                            </div>
                        </div>
                        </div>


                    <!-- <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="clearfix">
                                    <i class="fa fa-bullseye bg-flat-color-5 p-3 font-2xl mr-3 float-left text-light"></i>
                                    <div class="h5 text-secondary mb-0 mt-1">3</div>
                                    <div class="text-muted text-uppercase font-weight-bold font-xs small">  <a class="text-" href="<?=  Yii::$app->homeUrl ?>?r=">Training Centers</a> </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
            <!-- <div class="card col-md-12  no-padding no-shadow">
                <div class="card-body bg-flat-color-4">
                    <div class="h1 text-light text-right mb-0">
                        <i class="fa fa-window-close"></i>
                    </div>
                    <div class="h4 mb-0 text-light">
                        <span class="count">0</span>
                    </div>
                    <small class="text-uppercase font-weight-bold text-light"><a class="text-white" href="<?=  Yii::$app->homeUrl ?>?r=tpartner&TpartnerDetail[is_approved]=0">Trainging Partner Rejected</a></small>
                    <div class="progress progress-xs mt-3 mb-0 bg-light" style="width: 40%; height: 5px;"></div>
                </div>
            </div>
            <div class="card col-md-12  no-padding no-shadow">
                <div class="card-body bg-flat-color-1">
                    <div class="h1 text-light text-right mb-0">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <div class="h4 mb-0 text-light">
                    <span class="count"></span>

                    </div>
                    <small class="text-uppercase font-weight-bold text-light"><a class="text-white" href="<?=  Yii::$app->homeUrl ?>?r=tpartner&TpartnerDetail[is_approved]=2">T.P Waiting for Approval</a></small>

                    <div class="progress progress-xs mt-3 mb-0 bg-light" style="width: 40%; height: 5px;"></div>
                </div>
            </div> -->

                </div>
                <div class="col-md-6 col-sm-12">

                <div class="col-md-12">
                        <div class="card">
                        <div class="card-body">
                          <div class="stat-widget-four">
                            <div class="stat-icon dib">
                                <i class="fa fa-exclamation-circle text-muted"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                <a class="text-dark" href="<?=  Yii::$app->homeUrl ?>?r=batch/index&type=3"><div class="stat-heading">Total Batches Created</div></a>

                                    <div class="stat-text">Total: <a class="text-dark" href="<?=  Yii::$app->homeUrl ?>?r=batch/index.php&type=1"><?= $totalbatch; ?></a></div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="card">
                        <div class="card-body">
                          <div class="stat-widget-four">
                            <div class="stat-icon dib">
                                <i class="fa fa-times text-muted"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                <a class="text-dark" href="<?=  Yii::$app->homeUrl ?>?r=batch/index&type=3&TargetBatch[final_submit]=0"><div class="stat-heading">Batches Not Submitted</div></a>

                                    <div class="stat-text">Total: <a class="text-dark" href="<?=  Yii::$app->homeUrl ?>?r=batch/index&type=3&TargetBatch[final_submit]=0"><?= $pendingbatch;?></a></div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>

                     </div>


                    <div class="col-md-12">
                        <div class="card">
                        <div class="card-body">
                          <div class="stat-widget-four">
                            <div class="stat-icon dib">
                                <i class="fa fa-check-square text-muted"></i>
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                <a class="text-dark" href="<?=  Yii::$app->homeUrl ?>?r=batch/index&type=3&TargetBatch[final_submit]=1"><div class="stat-heading">Batches Submitted</div></a>

                                    <div class="stat-text">Total: <a class="text-dark" href="<?=  Yii::$app->homeUrl ?>?r=batch/index&type=3&TargetBatch[final_submit]=1"><?= $submittedbatch; ?></a></div>
                                </div>
                            </div>
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
            position:'right',
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


</script>
