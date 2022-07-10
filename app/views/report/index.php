<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TargetBatch */

$this->title = 'Reports';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="target-batch-create">

      <div class="card card-primary border-info">
          <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
          <h5><?= $this->title ?></h5>
          </div>
          <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Report Type</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">1</th>
                    <td>Summary Report</td>
                    <td><?= Html::a('View', ['batch','type'=>3], ['class'=>'btn btn-sm btn-primary ']) ?></td>
                    </tr>
                    <tr>
                    <th scope="row">2</th>
                    <td>Scheme Wise</td>
                    <td><?= Html::a('View', ['/scheme'], ['class'=>'btn btn-sm btn-primary ']) ?></td>
                    </tr>

                    <tr>
                    <th scope="row">3</th>
                    <td>Training Partner Wise</td>
                    <td><?= Html::a('View', ['/tpartner','TpartnerDetail[is_approved]'=>1], ['class'=>'btn btn-sm btn-primary ']) ?></td>
                    </tr>

                    <tr>
                    <th scope="row">4</th>
                    <td>Training Center Wise</td>
                    <td><?= Html::a('View', ['/tcenter/admin-index'], ['class'=>'btn btn-sm btn-primary ']) ?></td>
                    </tr>
                </tbody>
            </table>
          </div>
      </div>

</div>
