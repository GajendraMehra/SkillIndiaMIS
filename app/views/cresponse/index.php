<?php
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use app\models\IbmResponse;
use app\models\search\IbmResponse as IbmResponseSearch;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
$this->title = "Center Response";

$connection = new AMQPStreamConnection(
    Yii::$app->config->get('rabitmq-host'),
    Yii::$app->config->get('rabitmq-port'), 
    Yii::$app->config->get('rabitmq-username'), 
    Yii::$app->config->get('rabitmq-password'), 
    Yii::$app->config->get('rabitmq-rhost')
);
 // $connection = new AMQPStreamConnection('13.232.208.10', 5672, 'UKSDM', 'G3CpKsDUKSDM','sdmsResponse_UKSDM');
 $channel = $connection->channel();
 
 $channel->queue_declare('NxtGenSDMS_GetResponse_UKSDM', true, false, false, false);
 
//  echo " [*] Waiting for messages. To exit press CTRL+C\n";
 $msgCount=0; 
 $type='errormessage';

 $callback = function ($msg) {
 Yii::$app->session->addFlash('successmessage'," New Message Received. ");

     $model = new IbmResponse();
    	$model->response_data= $msg->body;
    	$data=json_decode($msg->body);
	if (property_exists($data->data, 'tpmBatchId')) 
    		$model->batch_id= $data->data->tpmBatchId;
	else
 		$model->batch_id=0;

   	$model->read_status=0;
	
    $model->save();
    @$msgCount++;
  
 };
//  Yii::$app->session->addFlash($type, $msgCount." Message Received. ");
 $channel->basic_consume('NxtGenSDMS_GetResponse_UKSDM', 'NxtGenSDMS_GetResponse_UKSDM', false, true, false, false, $callback);
 $timeout = 2;
 while (count($channel->callbacks)) {
     try{
         $channel->wait(null, false , $timeout);
     }catch(\PhpAmqpLib\Exception\AMQPTimeoutException $e){
         $channel->close();
         $connection->close();
        //  exit;
     }
 }
        $searchModel = new IbmResponseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
?>
   <?= GridView::widget([
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,
   
    'columns' => [
        ['class' => '\kartik\grid\CheckboxColumn'],

        // 'response_data',
        [
            'attribute'=>'id',
           
            'value'=>function($model){
               return  Yii::$app->params['ibm_message'] .$model->id;
            }
        ],[
            // 'attribute'=>'id',
            'label'=>'Message',
            'value'=>function($model){
               return (json_decode($model->response_data)->message);
            }
        ],[
            'attribute'=>'read_status',
            // 'label'=>"Related Sector",
            'format'=>'html',
            'filter' => ['Not Seen','Seen'],
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
            'options' => ['prompt' => 'All'],
            'pluginOptions' => [
            'allowClear' => true,
            'format'=>'html',
           
            ]
            ],
            'value'=>function($model){
                if ($model->read_status) {
                    # code...
                    return '<span class="badge badge-success"> Seen </span>';
        
                }
                else{
                    return '<span class="badge badge-danger">Not Seen</span>';
                    // return "No";
                }
            }
        ],
      
            [
              'class' => 'kartik\grid\ActionColumn',
              'dropdown' => false,
              // 'width'=>'20',
              // 'contentOptions' => ['style' => 'width:20%'],
              'hAlign'=>'middle',
              'template' => ' {view} ',
              'buttons' => [
                'delete' => function($url, $model){
                    return Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-danger',
                        'data' => [
                            'confirm' => 'Are you absolutely sure ? You will lose all the related information  with this action.',
                            'method' => 'post',
                            'class' => 'danger'
                        ],
                    ]);
                },
                
              ],
              'urlCreator' => function($action, $model, $key, $index) { 
                      return Url::to([$action,'id'=>$key]);
              },
              'viewOptions'=>['role'=>'modal-local',
              'icon'=>'glyphicon glyphicon-trash',
              'label' => 'View','class' => 'btn btn-sm btn-success ','title'=>'View'],
              'updateOptions'=>['role'=>'modal-remote',
              'label' => 'Update',
              'class' => 'btn btn-sm btn-info ',
              'icon'=>'fa fa-trash',
              'title'=>'Update', 'data-toggle'=>'tooltip'],
            ],
     
    ],
    'toolbar' => [
       
        '{export}',
        '{toggleData}'
    ],
    'toggleDataContainer' => ['class' => 'btn-group-sm'],
    'exportContainer' => ['class' => 'btn-group-sm'],
    'panel' => [
    'type'=> Yii::$app->config->get('panel-theme','primary'),
      'heading'=>'<h5>'.Html::encode(mb_strtoupper($this->title)).'</h5>',
      'before'=>Html::a('<i class="fa fa-redo"></i> Refresh ', ['index'], ['class' => 'btn btn-success btn-sm']) .'&nbsp&nbsp',
      'after'=>Html::a('<i class="fa fa-redo"></i> Reset ', ['index'], ['class' => 'btn btn-info btn-sm']),
    ],
   
]);
?>