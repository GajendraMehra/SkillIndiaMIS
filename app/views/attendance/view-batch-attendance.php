
<?php

use yii\helpers\Url;
$this->registerJsFile(" https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js", ['position' => \yii\web\View::POS_BEGIN]);
$this->registerJsFile(" https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js ", ['position' => \yii\web\View::POS_BEGIN]);
$this->registerJsFile("https://cdn.datatables.net/buttons/1.6.3/js/dataTables.buttons.min.js", ['position' => \yii\web\View::POS_BEGIN]);
$this->registerJsFile("https://cdn.datatables.net/buttons/1.6.3/js/buttons.colVis.min.js", ['position' => \yii\web\View::POS_BEGIN]);
$this->registerJsFile("https://cdn.datatables.net/buttons/1.6.3/js/buttons.flash.min.js", ['position' => \yii\web\View::POS_BEGIN]);
$this->registerJsFile("https://cdn.datatables.net/buttons/1.6.3/js/buttons.html5.min.js", ['position' => \yii\web\View::POS_BEGIN]);
$this->registerJsFile("https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js", ['position' => \yii\web\View::POS_BEGIN]);
$this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js", ['position' => \yii\web\View::POS_BEGIN]);
$this->title = Yii::t('app', $model->batch_name.' Attendance Report');
$this->params['breadcrumbs'][] = ['label' => 'All Attendance Report', 'url' => ['all-batch','type'=>3]];
$attValue= json_encode($attendance);
$baseUrl=Url::base(); 
$this->params['breadcrumbs'][] = $this->title;
?>

<style>

#photos_wrapper {
    overflow-x: auto;
    width: 65em;
}
</style>
<div class="card card-primary border-info">
        <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
        <h5><?= $this->title ?></h5>
        </div>
        <div class="card-body">


<table id="photos" class="display" cellspacing="0" width="100%">

        <thead>
            <tr>
                <th>Student HOPE ID</th>
                <th>Student Name</th>
                <th>Percent</th>
                <?php foreach ($dates as $key => $value): ?>
                  <th><?= $value ?></th>
                <?php endforeach; ?>


            </tr>
        </thead>
        <tbody>
        </tbody>

    </table>

  </div>
</div>


<script type="text/javascript">
var attendanceData=<?= $attValue ?>;

console.log(attendanceData);
function inittable(data) {
		//console.log(data);


		$('#photos').DataTable( {
      "data":data,
      "ordering": false,
      "paging":   false,
      "columnDefs": [
           {
               "render": function ( data, type, row ) {
                //  $(row).find('td:eq("Present")').css('color', 'red');
                 if (data==1) {
                    return "Present";
                 }else{
                   return "Absent";

                 }
               },
               "targets": Array.from(Array(data[0].length).keys()).splice(3)

           },
           // { "visible": false,  "targets": [ 3 ] }
       ],
       "rowCallback" : function(row, data, index,full){
         console.log(index);
         console.log(data);
         data.forEach((item, i) => {
           if(i>2){
            if (item=="1") {
              $('td', row).eq(i).addClass('table-success');

            }else{
              $('td', row).eq(i).addClass('table-danger');


            }
          }
         });


},
		dom: 'Blfrtip',
			"paging": false,
			"autoWidth": true,
			"buttons": [

				// 'copyHtml5',
        // 'csvHtml5',
        { extend: 'excelHtml5', text: 'Export to Excel',className:'btn btn-sm btn-info' },
        'pdfHtml5',
        {
                text: 'See Snaps',
                className:'btn btn-sm btn-success' ,
                action: function ( e, dt, node, config ) {
                  window.location="<?= $baseUrl?>/index.php?r=attendance/snaps&id=<?=$bid?>"
                    // alert( 'Button activated' );
                }
            }

			]
		} );
	}
  console.log(attendanceData);
  // console.log(arrayReturn);
  inittable(attendanceData);

  $("button").removeClass("dt-button");
</script>
