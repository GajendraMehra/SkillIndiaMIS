<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\CommonModel;
use app\models\TpartnerDetail;
use app\models\OrganisationType;
use app\models\States;
use app\models\UkDistrict;

function maskedaadhar($value='')
{
  return   $value[0].$value[1]."XXXXXXXXX".substr($value,-2);
}
/* @var $this yii\web\View */
/* @var $model app\models\Tcdetail */

$this->title = $model->name;
 if ($showUpdate){
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Training Centers'), 'url' => ['admin-index']];
}
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>


        section{
        padding: 60px 0;
        }

        #accordion-style-1 h1,
        #accordion-style-1 a{
            color:#007b5e;
        }
        #accordion-style-1 .btn-link {
            font-weight: 400;
            color: #007b5e;
            background-color: transparent;
            text-decoration: none !important;
            font-size: 16px;
            font-weight: bold;
            padding-left: 25px;
        }

        #accordion-style-1 .card-body {
            border-top: 2px solid #007b5e;
        }

        #accordion-style-1 .card-header .btn.collapsed .fa.main{
            display:none;
        }

        #accordion-style-1 .card-header .btn .fa.main{
            background: #007b5e;
            padding: 13px 11px;
            color: #ffffff;
            width: 35px;
            height: 41px;
            position: absolute;
            left: -1px;
            top: 10px;
            border-top-right-radius: 7px;
            border-bottom-right-radius: 7px;
            display:block;
        }
        </style>
<div class="tcdetail-view" id=>


<?php if ($showUpdate): ?>
    <!-- <p class="text-right">
        
    </p> -->
    <?php endif; ?>
    <div id="accordion-style-1">
    <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header  " id="headingOne">
                        <h5 class="mb-0">
                        <button class="btn btn-link btn-block text-left text-uppercase  bold" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="fa fa-eye main"></i><i class="fa fa-angle-double-right mr-3"></i>Training Center Basic Details
                        </button>
                    </h5>
                    </div>

                    <div id="collapseOne" class="collapse show fade" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">

                        <?= DetailView::widget([
                            'model' =>@$model,
                            // 'condensed'=>true,
                            'hover'=>true,
                            'hAlign'=>'left',
                           'attributes'=>[
                            // 'id',
                            'name',
                            [
                                'attribute'=>'tp_id',
                                'label'=>"Parent Training Partner",
                                'format'=>'html',
                                'value'=>@$model->parenttp->tp_name
                            ],
                            'smart_tcid',
                            [
                                'attribute'=>'email',
                                'label'=>"Email (Registered with account)",
                                'format'=>'html',
                                'value'=>@$model->email
                            ],
                            [
                                'attribute'=>'is_pmkk',
                                'label'=>'Pradhan Mantri Kaushal Kendra',
                                'format'=>'html',
                                'value'=>CommonModel::labels($model->is_pmkk)

                            ],

                            [
                                'attribute'=>'tcenter_type',
                                'format'=>'html',
                                'value'=>CommonModel::ceneterTypelabels($model->tcenter_type)

                            ], [
                                'attribute'=>'is_hostel',
                                'format'=>'html',
                                'value'=>CommonModel::labels($model->is_hostel)

                            ],
                            'hostel_capacity',

                            [
                                'attribute'=>'status',
                                'format'=>'html',
                                'valueColOptions'=>['style'=>'display:none'],
                                'labelColOptions'=>['style'=>'display:none']

                            ],
                            [
                                'attribute'=>'status',
                                'format'=>'html',
                                'label'=>"Active Status",
                                'value'=>function($r,$model){

                                    if ($model->attributes[7]['value']==1) {
                                        return '<span class="badge badge-success">Active  </span>';
                                       }

                                       return '<span class="badge badge-danger">De active</span>';
                                }
                            ]
                            ,

                           ]
                        ]) ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="accordion" id="accordionExample2">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                    <button class="btn btn-link btn-block text-left text-uppercase" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                        <i class="fa fa-eye main"></i><i class="fa fa-angle-double-right mr-3"></i>ADDRESS DETAILS
                    </button>
                    </h5>
                    </div>

                    <div id="collapseFour" class="collapse show fade" aria-labelledby="headingOne" data-parent="#accordionExample2">
                        <div class="card-body">
                        <?= DetailView::widget([
                        'model' => @$model1,
                        'hAlign'=>'left',

                        'attributes' =>[
                            // 'id',
                            'address_line',
                            'post_office',
                            [
                                'attribute'=> 'village',
                                'format'=>'html',
                                'value'=>(!$model1->village)? " (Not set ) ": $model1->village

                            ],
                            'pin_code',

                            [
                                'attribute'=> 'state_id',
                                'format'=>'html',
                                'value'=>States::findOne($model1->state_id)->name

                            ],

                            [
                                'attribute'=> 'city_id',
                                'format'=>'html',
                                'value'=>UkDistrict::findOne($model1->city_id)->name

                            ],

                             ],
                            ]) ?>
                        </div>
                    </div>
                </div>

            </div>


            <div class="accordion" id="accordionExample2">
                <div class="card">  
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                    <button class="btn btn-link btn-block text-left text-uppercase" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        <i class="fa fa-eye main"></i><i class="fa fa-angle-double-right mr-3"></i>Banks Details
                    </button>
                    </h5>
                    </div>

                    <div id="collapseThree" class="collapse show fade" aria-labelledby="headingOne" data-parent="#accordionExample2">
                        <div class="card-body">
                        <?= DetailView::widget([
                        'model' =>@$model2,
                        'hAlign'=>'left',

                        'attributes' => [
                            'account_number',
                            'ifsc_code',
                            'bank_name',
                            'account_name',
                        ],
                            ]) ?>
                        </div>
                    </div>
                </div>

            </div>



            <div class="accordion" id="accordionExample2">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                    <button class="btn btn-link btn-block text-left text-uppercase" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                        <i class="fa fa-eye main"></i><i class="fa fa-angle-double-right mr-3"></i>SINGLE POINT OF CONTACT-OPERATION (SPOC-OPERATION)
                    </button>
                    </h5>
                    </div>

                    <div id="collapseFive" class="collapse show fade" aria-labelledby="headingOne" data-parent="#accordionExample2">
                        <div class="card-body">
                        <?= DetailView::widget([
                        'model' =>@$model3,
                        'hAlign'=>'left',

                        'attributes' =>[

                            'name',
                            [
                                'attribute'=>'gender',
                                'format'=>'html',
                                'value'=>CommonModel::labelsGender($model3->gender)
                            ],
                            'designation',
                            // 'aadhar_no',
                            [
                              'attribute'=>  'aadhar_no',
                              // 'label'=>"A",
                              'value'=>maskedaadhar($model3->aadhar_no)

                            ],
                            'mobile_no',
                            'email',
                            // 'landline_no',

                        ],
                            ]) ?>
                        </div>
                    </div>
                </div>

            </div>


    </div>



</div>
