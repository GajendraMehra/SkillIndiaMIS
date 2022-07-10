
<div class="row">
<div class="col-md-5 mx-auto">


<?php
use kartik\select2\Select2;
use yii\helpers\Html;

$yearDrop=[];
for ($i=0; $i < 12; $i++) { 
    $low=2021+$i;
    $up=2021%100+$i+1;
  $yearDrop[2021+$i]= $low ."-".$up;   
}


echo '<label class="control-label">Finance Year</label>';
echo Select2::widget([
    'attribute' => 'state_2',
    'name' => 'state_2',
    'data' => $yearDrop,
  
    'value'=>$year,
    'options' => ['placeholder' => 'Select Financial Year...'],
    'pluginOptions' => [
        'allowClear' => true,
       
    ],
    'pluginEvents' => [
        'select2:select' => 'function(e) {  populateSchemeData(e.params.data.id); }',
    ],
  
]);

?>


</div>
<div class="col-md-7">
<?php if($filePath1){ ?>
<?= Html::a('<i class="fa fa-download fa-fw"></i>TP Level Report', $filePath1, ['class'=>'btn btn-sm btn-success mt-4 ml-5']) ?>
<?= Html::a('<i class="fa fa-download fa-fw"></i>Batch Level Report', $filePath2, ['class'=>'btn btn-sm btn-success mt-4 ml-5']) ?>
<?= Html::a('<i class="fa fa-download fa-fw"></i>Batch Level Report Table', $filePath2_1, ['class'=>'btn btn-sm btn-success mt-4 ml-5']) ?>
<?= Html::a('<i class="fa fa-download fa-fw"></i>Student Level Report', $filePath3, ['class'=>'btn btn-sm btn-success mt-4 ml-5']) ?>

<?php } ?>
</div>

</div>

<script>


</script>