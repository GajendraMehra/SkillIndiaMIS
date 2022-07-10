<?php
$this->title = "Snap of Batch ".$model->batch_name;
// $this->params['breadcrumbs'][] = ['label' => 'Target Batches', 'url' => ['index','type'=>3]];
$this->params['breadcrumbs'][] = ['label' => 'Attendance Report', 'url' => ['all-batch','type'=>3]];
$this->params['breadcrumbs'][] = ['label' => 'Attendance Report', 'url' => ['batch-attendance','id'=>$model->id]];

$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
use yii\helpers\Url;
?>

<div class="container">
      <div class="row">
                <?php
foreach ($files as $key => $value) {?>
    <div class="col-lg-3 col-md-4 col-xs-6 thumb border border-primary"><a class="thumbnail img-rounded" href="<?= Url::base() ?>/uploads/attendance/<?= $model->id?>/<?=$value ?>" data-lightbox="imgGLR" ><img class="img-responsive img-rounded" border="0" height="150" src="<?= Url::base() ?>/uploads/attendance/<?= $model->id?>/<?=$value ?>" width="400" /></a>
    <h5 class="text-center mt-2 bg-white"><?= date('d M yy' ,strtotime(explode('.',$value)[0]))?></h5>
    </div>

<?php }
                ?>
          

	</div>	
</div>

