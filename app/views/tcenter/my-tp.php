<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\CommonModel;
use app\models\OrganisationType;
use app\models\States;
use app\models\Cities;
/* @var $this yii\web\View */
/* @var $model app\models\TpartnerDetail */

$this->title = "Parent Training Partner";

$this->params['breadcrumbs'][] = $this->title;
// \yii\web\YiiAsset::register($this);
function maskedaadhar($value='')
{
  return   $value[0].$value[1]."XXXXXXXXX".substr($value,-2);
}

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
<div class="row">
<div class="col-md-10 text-right">

<p>
<?php if($model->is_approved==2&&Yii::$app->user->identity->role==1): ?>
        <?= Html::a(Yii::t('app', '<i class="fa fa-check"></i>&nbsp&nbsp Approve'), ['change-status', 'id' => $model->id,'actionId'=>1], ['class' => 'btn btn-outline-info',
         'data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to  approve <b> '.$model->tp_name.' </b>as Training Partner . '),

                    'method' => 'post',
                    'params'=>[
                        'is_approved'=>1,

                    ],
                    'option'=>[

                        'type'=>'danger'
                    ]
                ],
        ]) ?>
        <?= Html::a(Yii::t('app', '<i class="fa fa-times"></i>&nbsp&nbsp Dis Approve'), ['change-status', 'id' => $model->id,'actionId'=>2], ['class' => 'btn btn-outline-primary',
         'data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to dis approve <b> '.$model->tp_name.' </b>as Training Partner . '),

                    'method' => 'post',
                    'params'=>[
                        'is_approved'=>0,

                    ],
                    'option'=>[

                        'type'=>'danger'
                    ]
                ],
        ]) ?>
        <?= Html::a(Yii::t('app', '<i class="fa fa-trash"></i>&nbsp&nbspDelete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-outline-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                    'option'=>[

                        'type'=>'danger'
                    ]
                ],
            ]) ?>
        <?php endif; ?>

        </p>
</div>
</div>

<div class="tpartner-detail-view" id="accordion-style-1">
    <div class="row">
        <div class="col-10">

            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header  " id="headingOne">
                        <h5 class="mb-0">
                        <button class="btn btn-link btn-block text-left text-uppercase  bold" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="fa fa-eye main"></i><i class="fa fa-angle-double-right mr-3"></i>Training Partner Basic Details
                        </button>
                    </h5>
                    </div>

                    <div id="collapseOne" class="collapse show fade" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">

                        <?= DetailView::widget([
                            'model' => $model,
                            // 'condensed'=>true,
                            'hover'=>true,
                            'hAlign'=>'left',
                            'attributes' => [
                                // 'id',
                                'tp_name:ntext',
                                'tp_sdms_id',
                                [
                                    'attribute'=>'has_gst',
                                    'format'=>'html',
                                    'value'=>CommonModel::labels($model->has_gst)

                                ],
                                 'gst_no:ntext',
                                [

                                    'attribute'=>'is_approved',
                                    'format'=>'html',
                                    'valueColOptions'=>['style'=>'display:none'],
                                    'labelColOptions'=>['style'=>'display:none']

                                ],

                                // 'updated_at',
                                // 'createdBy.username',
                                // 'final_submit',
                                [
                                    'attribute'=>'is_approved',
                                    'format'=>'html',
                                    'label'=>"Approval Status",
                                    'value'=>function($r,$model){

                                        if ($model->attributes[4]['value']==1) {
                                            return '<span class="badge badge-success">Approved   </span>';
                                           }
                                           else  if ($model->attributes[4]['value']==2) {
                                              return '<span class="badge badge-info">Pending   </span>';
                                             }
                                           return '<span class="badge badge-danger">Not Approved</span>';
                                    }
                                ]

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
                    <button class="btn btn-link btn-block text-left text-uppercase" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                        <i class="fa fa-eye main"></i><i class="fa fa-angle-double-right mr-3"></i>ADDRESS DETAILS
                    </button>
                    </h5>
                    </div>

                    <div id="collapseFour" class="collapse show fade" aria-labelledby="headingOne" data-parent="#accordionExample2">
                        <div class="card-body">
                        <?= DetailView::widget([
                        'model' => $modelTpdetailAddress,
                        'hAlign'=>'left',

                        'attributes' =>[
                            // 'id',
                            'address_line',
                            'post_office',
                            [
                                'attribute'=> 'village',
                                'format'=>'html',
                                'value'=>(!$modelTpdetailAddress->village)? " (Not set ) ": $modelTpdetailAddress->village

                            ],
                            'pin_code',

                            [
                                'attribute'=> 'state_id',
                                'format'=>'html',
                                'value'=>States::findOne($modelTpdetailAddress->state_id)->name

                            ],

                            [
                                'attribute'=> 'city_id',
                                'format'=>'html',
                                'value'=>Cities::findOne($modelTpdetailAddress->city_id)->city

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
                    <button class="btn btn-link btn-block text-left text-uppercase" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                        <i class="fa fa-eye main"></i><i class="fa fa-angle-double-right mr-3"></i>SINGLE POINT OF CONTACT-OPERATION (SPOC-OPERATION)
                    </button>
                    </h5>
                    </div>

                    <div id="collapseFive" class="collapse show fade" aria-labelledby="headingOne" data-parent="#accordionExample2">
                        <div class="card-body">
                        <?= DetailView::widget([
                        'model' => $modelTpdetailSpocoperation,
                        'hAlign'=>'left',

                        'attributes' =>[

                            'name',
                            [
                                'attribute'=>'gender',
                                'format'=>'html',
                                'value'=>CommonModel::labelsGender($modelTpdetailSpocoperation->gender)
                            ],
                            'designation',
                            [
                              'attribute'=>  'aadhar_no',
                              // 'label'=>"A",
                              'value'=>maskedaadhar($modelTpdetailSpocoperation->aadhar_no)

                            ],
                            'mobile_no',
                            'email',
                            'landline_no',

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
                    <button class="btn btn-link btn-block text-left text-uppercase" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                        <i class="fa fa-eye main"></i><i class="fa fa-angle-double-right mr-3"></i>CEO/MD
                    </button>
                    </h5>
                    </div>

                    <div id="collapseSeven" class="collapse show fade" aria-labelledby="headingOne" data-parent="#accordionExample2">
                        <div class="card-body">
                        <?= DetailView::widget([
                        'model' => $modelTpdetailCeo,
                        'hAlign'=>'left',

                        'attributes' =>[

                            'name',
                            [
                                'attribute'=>'gender',
                                'format'=>'html',
                                'value'=>CommonModel::labelsGender($modelTpdetailCeo->gender)
                            ],
                            'designation',
                            [
                              'attribute'=>  'aadhar_no',
                              // 'label'=>"A",
                              'value'=>maskedaadhar($modelTpdetailCeo->aadhar_no)

                            ],
                            'mobile_no',
                            'email',
                            'landline_no',

                        ],
                            ]) ?>
                        </div>
                    </div>
                </div>

            </div>




        </div>
    </div>

</div>
