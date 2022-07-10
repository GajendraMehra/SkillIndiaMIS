<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\base\View;
/* @var $this yii\web\View */
/* @var $model app\models\IbmResponse */

$this->title = Yii::$app->params['ibm_message'] .$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Center Responses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerJs("https://unpkg.com/@araujoigor/json-grid/dist/JSONGrid.min.js",  \yii\web\View::POS_BEGIN);
// <link rel="stylesheet" href="https://unpkg.com/@araujoigor/json-grid/dist/json-grid.css">
// <script src="https://unpkg.com/@araujoigor/json-grid/dist/JSONGrid.min.js"></script>
?>
<style>
#container {
	overflow: auto;
	overflow-x: scroll;
	width: 980px;
}
</style>
  <!-- <link rel="stylesheet" href="https://unpkg.com/@araujoigor/json-grid/dist/json-grid.css"> -->
  <script src="https://unpkg.com/@araujoigor/json-grid/dist/JSONGrid.min.js"></script>
<div class="ibm-response-view">
<div class="card card-primary border-info" id="card">
      <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
      <h5><?= $this->title ?></h5>
      </div>
      <div class="card-body">
      <div id="container"></div>
      <input type="hidden" name="">
      <!-- <textarea style="" id="myTextArea" style="display:none" readonly></textarea> -->
    </div>
    </div>
</div>
<script type="text/javascript">
$( document ).ready(function() {
var container = document.getElementById("container");
    var data =JSON.parse('<?= $model->response_data ?>') ;
    var jsonGrid = new JSONGrid(data, container);
    jsonGrid.render();

$.fn.json_beautify= function() {
   var obj = JSON.parse( this.val() );
   var pretty = JSON.stringify(obj, undefined, 4);
   this.val(pretty);
};

// Then use it like this on any textarea
$('#myTextArea').json_beautify();
});
</script>
<script>
$('#container').width($('#card').width())

</script>