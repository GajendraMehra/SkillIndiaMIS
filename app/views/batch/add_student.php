<?php
use app\models\TargetBatch;
$this->title = "Add Student";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Batches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', TargetBatch::findOne($_GET['bid'])->batch_name), 'url' => ['view','id'=>$_GET['bid']]];
$this->params['breadcrumbs'][] = $this->title;
$students= json_encode($data);
// echo "<pre>";
// print_r($data);

?>  
<table id="example" class="display" width="100%">
  <thead>
    <!-- <button class="btn btn-success btn-sm" name="">Add Selected Students</button> -->
  </thead>
<tfoot><tr>
  <!-- <button type="button" name="button">dsfsdf</button> -->
</tr></tfoot>
</table>
<!-- <div class="card card-primary border-info">
        <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
        <h5><?= $this->title ?></h5>
        </div>
        <div class="card-body">

      </div>
    </div> -->
<script type="text/javascript">


$(document).ready(function() {

function render(data, type, row, meta){
// console.log(row);

  return data;
}
$('#example').DataTable( {
  data: <?php echo $students ?>,
  columns: [
    {"data":"id","title": '<input type="checkbox" id="selectall" id="">',"render":function(data){

      return '<input type="checkbox" id="vehicle1" name="selectedStudents[]" value="'+data+'">'
    }},
    {"data":"hope_id","title": "HOPE ID","render":render},
    {"data":"student_name","title": "STUDENT NAME","render":render},
    // {"data":"email","title": "State","render":render},
    {"data":"mother_name","title": "MOTHER'S NAME","render":render},
    {"data":"father_name","title": "FATHER'S NAME","render":render},
    {"data":"dob","title": "DOB","render":render},
    // {"data":"gender","title": "GENDER","render":render},
    // {"data":"aadhar_no","title": "AADHAR NO","render":render},
    // {"data":"address","title": "ADDRESS","render":render},
    // {"data":"block_id","title": "State","render":render},
    // {"data":"phone_no","title": "State","render":render},
    // {"data":"max_edu","title": "State","render":render},
    // {"data":"category","title": "State","render":render},
    // {"data":"prefrence_job","title": "State","render":render},
    // {"data":"prefrence_district","title": "State","render":render},
    // {"data":"","render":render},

// }
  ],
  // "dom": '<"toolbar">frtip',
  "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
  buttons: [
           {
               text: 'My button',
               action: function ( e, dt, node, config ) {
                   alert( 'Button activated' );
               }
           }
       ],
  columnDefs: [ {
           orderable: false,
           className: 'select-checkbox',
           targets:   0
       } ],
       select: {
           style:    'os',
           selector: 'td:first-child'
       },
       order: [[ 1, 'asc' ]],

  rowReorder: {
        selector: 'td:nth-child(2)'
  },
  responsive: true,
  "order": [[ 1, "desc" ]]

} );
  // $("div.toolbar").append('<button type="button" id="any_button">Click Me!</button>');
} );

$('#example').on( 'draw.dt', function () {
$("#selectall").click(function(){
    $('input[name="selectedStudents[]"]').not(this).prop('checked', this.checked);
});
// alert()
})


</script>
