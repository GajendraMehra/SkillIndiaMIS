<?php

namespace app\controllers;

use Yii;
use DateTime;
use app\models\TargetBatch;
use app\models\Targets;
use app\models\Student;
use app\models\Job;
use app\models\BatchStudents;
use app\models\Tcdetail;
use app\models\TcenterAddress;
use app\models\States;
use app\models\SubSector;
use app\models\UploadForm;
use app\models\Category;
use app\models\Religion;
use app\models\UkBlocks;
use app\models\UkDistrict;
use app\models\Scheme;
use app\models\Sector;
use app\models\TpartnerDetail;
use app\models\TpdetailAddress;
use app\models\TransDetail;
use app\models\TargetsResponse;
use app\models\TpdetailSpocoperation;
use app\models\Cities;
use app\models\TcenterSpocoperation;
use app\models\StudentAttendance;
use app\models\search\TargetBatch as TargetBatchSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\CommonModel;
use yii\data\ActiveDataProvider;
use app\models\search\BatchStudents as BatchStudentsSearch;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * BatchController implements the CRUD actions for TargetBatch model.
 */
class BatchController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {
            # code...
            $this->displayError();
        }
        return parent::beforeAction($action);
    }

    public function actionRemovestudent($id,$batchId){
        $model= $this->findModel($batchId);
        if ($model->final_submit) {
            throw new \yii\web\HttpException(403,
            'This Batch is final submitted . You can not remove students .Please contact admin');
        }
        BatchStudents::findOne($id)->delete();
    
        return $this->redirect(['view','id' => $batchId]);
    } 
    public function actionAddStudent($bid){
        $batch=$this->findModel($bid);
        $job_id=$batch->job_id;
      
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT tbl_student.*,tbl_batch_students.id as bid FROM tbl_student left join tbl_batch_students on tbl_batch_students.student_id=tbl_student.id  where tbl_batch_students.id is null and tbl_student.prefrence_job=:job_id and tbl_student.selected_tc=:tc_id")
        ->bindValues([
            ':job_id' => $job_id,
            ':tc_id'=>$batch->tc_id
        ]);
        
        $result = $command->queryAll();
        
        return $this->renderPartial('add_student', [
            'data' => $result,
            // 'dataProvider' => $dataProvider,
        ]);
    }
   public function actionRemoteSend($id)
   {    

    if (Yii::$app->user->identity->role!=2&&Yii::$app->user->identity->role!=1) {
        throw new \yii\web\HttpException(403,
        'You do not have permission to access this page. Contact admin');
    
   
    }
    if (!BatchStudents::find()->where(['batch_id'=>$id])->count()) {
        throw new \yii\web\HttpException(403,
        'You can not send this batch for assesment. Please add student first.');
    }
    $model = $this->findModel($id);
    
    $candidatesData=[];
    $batchData=TargetBatch::find()->where(['id'=>$id])->asArray()->one();
    //     print_r($batchData);
    //    die;
    $jobData=Job::find($batchData['job_id'])->asArray()->one();
    $tcbasicdata=Tcdetail::find($batchData['tc_id'])->asArray()->one();
    $tcbasicspoc=TcenterSpocoperation::find(['tc_id'=>$tcbasicdata['id']])->asArray()->one();
    $tpbasicdata=TpartnerDetail::find($batchData['tc_id'])->asArray()->one();
    $tcbasicaddress=TcenterAddress::find(['tc_id'=>$tcbasicdata['tp_id']])->asArray()->one();
    $tpbasicaddress=TpdetailAddress::find(['tp_id'=>$tcbasicdata['tp_id']])->asArray()->one();
    $tpbasicspoc=TpdetailSpocoperation::find(['tp_id'=>$tcbasicdata['tp_id']])->asArray()->one();
    $tid=TargetsResponse::findOne([$batchData['sub_target_id']])->target_id;
    $sid=Targets::findOne([$tid])->scheme_id;
    $scheme=Scheme::findOne([$sid]);
    $stuid=BatchStudents::find()->where(['batch_id'=>$id])->asArray()->all();
    foreach ($stuid as $key => $value) {
        $data=Student::findOne($value['student_id']);
    $contactDetails=[
        "phone"=>$data->phone_no,
        "email"=>$data->email,
        "communicationAddress"=>[
          "country"=>"India",
          "countryId"=>"91",
          "state"=>"Uttrakhand",
          "stateId"=>"31",
          "districtDetails"=>[
            "district"=>UkDistrict::findOne(UkBlocks::findOne($data->block_id)->district_id)->name,
            "districtId"=>(String)UkBlocks::findOne($data->block_id)->district_id,
            "subDistrict"=>UkBlocks::findOne($data->block_id)->name,
            "subDistrictId"=>(String)$data->block_id,
            "parliamentaryConstituency"=>"",
            "mandal"=>"",
            "village"=>"",
            "villageId"=>"",
      ],
          "pinCode"=> (String)$data->pin_code,
          "city"=> UkBlocks::findOne($data->block_id)->name,
          "address1"=> $data->address
      
    ]
    ];

    $studentname=explode(' ',$data->student_name);
    $firstname=array_shift($studentname);
    $candidates= [
          "tpmUserName"=>$data->email,
          "tpmCandidateId"=>(String)$data->id,
          "tpmRegistrationNumber"=>$data->sip_id,
          "personalDetails"=>[
            "firstName"=>$firstname,
            "lastName"=>implode(" ",$studentname),
            "gender"=>CommonModel::labelsGender($data->gender),
            "dob"=>date("d-m-Y", strtotime($data->dob)),
            "guardianName"=>$data->father_name,
            "relationWithGuardian"=>'father',
            "caste"=>Category::findOne($data->category)->category,
            "religion"=>Religion::findOne($data->religion)->religion_name,
            "differentlyAbled"=>CommonModel::labelsYesNo($data->is_disabled),
            "disabilityCategory"=>$data->disbality,
           
          ],
          "contactDetails"=>$contactDetails,
          
          ];

          array_push($candidatesData,$candidates);
        }
    $tcaddress = array(
        "addressLine"=> $tcbasicaddress['address_line'],
        "landmark"=> $tcbasicaddress['address_line'],
        "name"=> $tcbasicaddress['address_line'],
        "pincode"=> $tcbasicaddress['pin_code'],
        "civerified"=>false,
        "state"=>[
          "name"=>States::findOne($tcbasicaddress['state_id'])->name,
          "id"=>$tcbasicaddress['state_id'],
        ],
   
          "district"=>Cities::findOne($tcbasicaddress['city_id'])->city,
          "id"=>$tcbasicaddress['city_id'],
        "subDistrict"=>[
            "name"=>Cities::findOne($tcbasicaddress['city_id'])->city,
            "id"=>$tcbasicaddress['city_id']
          ],
        "location"=>[
          "longitude"=>"77.43006279999997",
          "latitude"=>"23.2324416"
        ],
        "spoc"=>[
          "firstName"=>$tcbasicspoc['name'],
          "mobileNumber"=>$tcbasicspoc['mobile_no'],
          "email"=>$tcbasicspoc['email']
        ]
    );

    $tpaddress = array(

        "landmark"=> $tpbasicaddress['address_line'],
        "locality"=> "",
        "pinCode"=> $tpbasicaddress['pin_code'],
        // "civerified"=>"false",
        "state"=>States::findOne($tpbasicaddress['state_id'])->name,
        "stateId"=>$tpbasicaddress['state_id'],
        "address1"=> $tpbasicaddress['address_line'],
        "addressProof"=> null,
        "country"=> "INDIA",
        "districtDetails"=>[
          "district"=>Cities::findOne($tpbasicaddress['city_id'])->city,
          "districtId"=>$tpbasicaddress['city_id'],
          "subDistrict"=>Cities::findOne($tpbasicaddress['city_id'])->city,
          "subDistrictId"=>$tpbasicaddress['city_id'],
          "mandal"=> "",
          "parliamentaryConstituency"=> "",

        ],
    
        // "location"=>[
        //   "longitude"=>"77.43006279999997",
        //   "latitude"=>"23.2324416"
        // ],
        
    );
    $tcdetail = array(
  
        "tpmTCId"=>$tcbasicdata['smart_tcid'],
        "tpmTCName"=>$tcbasicdata['name'],
        "trainingCenterType"=>CommonModel::ceneterTypelabels($tcbasicdata['tcenter_type']),
        "address"=>$tcaddress,
    );
    $tpdetail = array(
  
        "tpmTpId"=>$tpbasicdata['tp_sdms_id'],
        "tpmTpName"=>$tpbasicdata['tp_name'],
        // "trainingCenterType"=>CommonModel::ceneterTypelabels($tcbasicdata['tcenter_type']),
        "address"=>$tpaddress,
        "email"=> $tpbasicspoc['email'],
        "phone"=> [
            "mobile"=> $tpbasicspoc['mobile_no']
        ],
        "spoc"=>[
            "firstName"=>$tpbasicspoc['name'],
            "mobileNumber"=>$tpbasicspoc['mobile_no'],
            "email"=>$tpbasicspoc['email']
          ]
    );
  
    // $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    // $channel = $connection->channel();
    
    // $channel->queue_declare('hello', false, false, false, false);

    // $msg = new AMQPMessage('Hello It Works!');
    // $channel->basic_publish($msg, '', 'hello');
    
    // echo " [x] Sent 'Hello World!'\n";
    // $channel->close();
    // $connection->close();
  
    $jobRoles[0]=array(
        "jobName"=>$jobData['job_name'],
        "qpCode"=>$jobData['qp_code'],
        "jobRoleDesc"=>"",
        "assessmentStartDate"=>date("d-m-Y", strtotime($batchData['end_date'])),
        "assessmentEndDate"=>date("d-m-Y", strtotime($batchData['assesment_date'])),
        "version"=>'1.0',
    );
    $tpmBatch=array(
        "tpmBatchId"=>$batchData['id'],
        "batchName"=>$batchData['batch_name'],
        "batchStartDate"=>date("d-m-Y", strtotime($batchData['start_date'])),
        "batchEndDate"=>date("d-m-Y", strtotime($batchData['end_date'])),
        "size"=>(String)($batchData['max_size']-$batchData['min_size']),
        "status"=>"NEW",
        "jobRoles"=>$jobRoles,
        "candidates"=>$candidatesData,
       
    );
    $data = array(
        "requestType"=>"BatchCreateOrUpdate",
        "sectorId"=>(String)SubSector::findOne(['nsdc_sub_sector_id'=>$jobData['sub_sector_id']])->sector_id,
        "sectorName"=>Sector::findOne(['nsdc_sector_id'=>SubSector::findOne(['nsdc_sub_sector_id'=>$jobData['sub_sector_id']])->sector_id])->sector_name, 
        "subSectorId"=>$jobData['sub_sector_id'],
        "subsectorName"=>SubSector::findOne(['nsdc_sub_sector_id'=>$jobData['sub_sector_id']])->sub_sector_name, 
        "tpmId"=>"UKSDM",
        "tpmName"=>"UKSDM",
        "sdmsSchemeName"=>$scheme->full_name,
        "sdmsSchemeId"=>$scheme->short_name,
        "tpmBatch"=>$tpmBatch,
        "tcDetails"=>$tcdetail,
        "tpDetails"=>$tpdetail,
    );
    $post=Yii::$app->request->post();
    if ($post) {
      $this->sendData($data);
        Yii::$app->session->addFlash('successmessage', "Data Sent for Assesment");
        $model = $this->findModel($id);
        $model->final_submit=2;
        $model->save();
    }else{

        Yii::$app->session->addFlash('tips', "Please Verify All the Information . Before Sending to Skill India Portal");
    }
 

    return $this->render('send-report', [
    'data'=>json_encode($data),
    'model'=>$model,
    ]);
   }

    public function sendData($data)
    {
        

         
        // Local Connection String Connection string goes here
        // $connection = new AMQPStreamConnection('127.0.0.1', 5672, 'guest', 'guest','sdmstpmintegration');

        // Remote Connection String 
        // $connection = new AMQPStreamConnection('13.232.208.10', 5672, 'UKSDM', 'G3CpKsDUKSDM','sdmstpmintegration');
        $connection = new AMQPStreamConnection(
            Yii::$app->config->get('rabitmq-host'),
            Yii::$app->config->get('rabitmq-port'), 
            Yii::$app->config->get('rabitmq-username'), 
            Yii::$app->config->get('rabitmq-password'), 
            Yii::$app->config->get('rabitmq-vhost')
        );
        
        $MESSAGE=json_encode($data);


        $channel = $connection->channel();
        $channel->queue_declare('NxtGenSDMS_SubmitRequest', true, false, false, false);
     
        $msg = new AMQPMessage($MESSAGE);
        $channel->basic_publish($msg, '', 'NxtGenSDMS_SubmitRequest');

        $channel->close();
        $connection->close();
        
    }

   public function actionRemoteReceive()
   {
    
        // use PhpAmqpLib\Connection\AMQPStreamConnection;

        // $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        // $connection = new AMQPStreamConnection('13.232.208.10', 5672, 'UKSDM', 'G3CpKsDUKSDM','sdmsResponse_UKSDM');
             // $connection = new AMQPStreamConnection('13.232.208.10', 5672, 'UKSDM', 'G3CpKsDUKSDM','sdmsResponse_UKSDM');
             $connection = new AMQPStreamConnection(
                Yii::$app->config->get('rabitmq-host'),
                Yii::$app->config->get('rabitmq-port'), 
                Yii::$app->config->get('rabitmq-username'), 
                Yii::$app->config->get('rabitmq-password'), 
                Yii::$app->config->get('rabitmq-rhost')
            );
        $channel = $connection->channel();
        
        $channel->queue_declare('NxtGenSDMS_GetResponse_UKSDM', false, false, false, false);
        
        echo " [*] Waiting for messages. To exit press CTRL+C\n";
        
        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
            die;
        };
        
        $channel->basic_consume('NxtGenSDMS_GetResponse_UKSDM', 'NxtGenSDMS_GetResponse_UKSDM', false, true, false, false, $callback);
        
        while ($channel->is_consuming()) {
            $channel->wait();
        }
        
        
        
        $channel->close();
        $connection->close();
   }
    public function displayError()
    {
        // echo "error";
        // if (Yii::$app->user->identity->role!=3&&Yii::$app->user->identity->role!=1) {
        //     throw new \yii\web\HttpException(403,
        //     'You do not have permission to access this page. Contact admin');
        
        // $exception = Yii::$app->errorHandler->exception;
       
        // return $this->render('/site/error', ['exception' => $exception
        //   ,'name'=>"Error",
        //   "message"=> $exception ]);
        // }
    }

    /**
     * Lists all TargetBatch models.
     * @return mixed
     */
    public function actionEvents($id, $start, $end)
    {
        $tcdetails=CommonModel::getTcdetailbyuserid();
        $batches=TargetBatch::find()->asArray()->all();

        foreach ($batches as $key => $value) {

            if (new DateTime(date('Y-m-d')) <=new DateTime($value['end_date'])&&new DateTime(date('Y-m-d')) >= new DateTime($value['start_date'])) {
                $bgcolor='#4dbd74';
    
                }elseif(new DateTime(date('Y-m-d')) < new DateTime($value['start_date'])){
                    $bgcolor='#0d6651';
                }else{
                    $bgcolor='#dc3545';
                }
            $my_events[] = array(
                'id' => $value['id'],
                'title' => $value['batch_name'], //$event_array->calendar_title;
                'data' => $value['batch_name'], //$event_array->calendar_title;
                'start' =>  $value['start_date'],  //$event_array->calendar_startdate .' '.$event_array->calendar_starttime;
                'end'   =>  $value['end_date'],  //$event_array->calendar_enddate .' '.$event_array->calendar_endtime;
                'backgroundColor'=>  $bgcolor

            );
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
        return  ($my_events);
    
    }
    public function actionIndex($type=3)
    {

        // mark final submit if not submitted by training center after checking end dates 
        if (Yii::$app->user->identity->role==2) {
            return $this->redirect(['center-index','type'=>3]);

        }
        $ids=TargetBatch::find()->select('id')->where(['<=','start_date',date('Y-m-d')])->asArray()->all();

        foreach ($ids as $key => $value) {
            // $model=$this->findModel($value['id']);
            // $model->final_submit=1;
            // $model->save();

        }
        if (Yii::$app->user->identity->role==5) {
            $searchModel = new TargetBatchSearch(['final_submit'=>1,'type'=>$type]);
            $renderFile='adminindex';
        }
       else if (Yii::$app->user->identity->role==1) {
            $searchModel = new TargetBatchSearch(['final_submit'=>1,'type'=>$type]);
            $renderFile='adminindex';
        }else{
            $tcdetails=CommonModel::getTcdetailbyuserid();
            $renderFile='index';
            $searchModel = new TargetBatchSearch(['tc_id'=>$tcdetails['id'],'type'=>$type]);
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      
        // echo "<pre>";
      
    
        return $this->render($renderFile, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } 
    public function actionCenterIndex($type=3)
    {
        $tpdetails=CommonModel::getTpdetailbyuserid();
        // mark final submit if not submitted by training center after checking end dates 

        $ids=TargetBatch::find()->select('id')->where(['<=','start_date',date('Y-m-d')])->asArray()->all();

        foreach ($ids as $key => $value) {
            // $model=$this->findModel($value['id']);
            // $model->final_submit=1;
            // $model->save();

        }
        $searchModel = new TargetBatchSearch(['final_submit'=>1,'type'=>$type,'tp_id'=>$tpdetails['id']]);


        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      
        // echo "<pre>";
      
    
        return $this->render('tpindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TargetBatch model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $datamodel=$this->findModel($id);
        $cstudent=BatchStudents::find()->where(['batch_id'=>$id])->count();
        $tstudent=$datamodel->subTarget->response_number;
      
        $renderFile='view';

      
        if (Yii::$app->user->identity->role==1){
            // $searchModel = new TargetBatchSearch(['final_submit'=>1]);
            $renderFile='adminview';
        }
        elseif(Yii::$app->user->identity->role==2){
            if(Yii::$app->user->identity->id!=$datamodel->center->parenttp->edited_by){
                throw new \yii\web\HttpException(403,
                'You do not have permission to access this page.');
            
            }
           

        }
        elseif(Yii::$app->user->identity->role==3){
            if(Yii::$app->user->identity->id!=$datamodel->edited_by){
                throw new \yii\web\HttpException(403,
                'You do not have permission to access this page.');
            
            }

        }
       
       $post=Yii::$app->request->post();
    
     
        if (isset($post['selectedStudents'])) {
            if (sizeof($post['selectedStudents'])>($tstudent-$cstudent)) {
                Yii::$app->session->addFlash('errormessage', "Target Exceed . Can not add more");
        
                $searchModel = new BatchStudentsSearch(['batch_id'=>$id]);
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                return $this->render($renderFile, [
                    'model' => $datamodel,
                    'dataProvider' => $dataProvider
                ]);
                }else{
                    foreach ($post['selectedStudents'] as $key => $value) {
                        $model = new BatchStudents();
                        $model->batch_id=$id;
                        $model->student_id=$value;
                        $model->created_at = date('Y-m-d H:i:s');
                        $model->save();
                       }
                }
          
        }
        $searchModel = new BatchStudentsSearch(['batch_id'=>$id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render($renderFile, [
            'model' => $datamodel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new TargetBatch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $tcdetails=CommonModel::getTcdetailbyuserid();
        $model = new TargetBatch();
        $model->updated_at = date('Y-m-d H:i:s');
        $model->edited_by = Yii::$app->user->id;
        $model->created_at = date('Y-m-d H:i:s');
        $model->final_submit=0;
        $model->tc_id =$tcdetails['id'];
        $model->load(Yii::$app->request->post());
        // echo "<pre>";
        // print_r(Yii::$app->request->post());
        // // print_r($model);
        // die;
            //   
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('successmessage', "Batch Created Successfully. Please Add Student and final submit batch");

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'tc'=>$tcdetails['id']
        ]);
    }

      
    public function actionMarkAttendance($id)
    {
     
        $searchModel = new BatchStudentsSearch(['batch_id'=>$id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       $post=Yii::$app->request->post();
       $model=StudentAttendance::findOne(['batch_id'=>$id]);
      
       if ($model) {
        $attendance_data=$model->attendance_data;
        $attendance_data=(array)json_decode($attendance_data);
        $result = @$attendance_data[date('Y-m-d')] ?: null;
        if ($result) {
            Yii::$app->session->addFlash('errormessage', "You already submited  Today's attendance . You can not submit twice a day. ");
            return $this->redirect(['view', 'id' => $id]);

        }
       }
       if ($post) {
        $data[date('Y-m-d')]=$post['attendance'];
        $batchdata=StudentAttendance::find()->where(['batch_id'=>$id])->asArray()->one();
        if ($batchdata) {
            $attendance_data=$batchdata['attendance_data'];
            $attendance_data=(array)json_decode($attendance_data);
            $attendance_data[date('Y-m-d')]=$post['attendance'];
            $model=StudentAttendance::findOne($batchdata['id']);
            $model->attendance_data=json_encode($attendance_data);
            if ($model->save()) {
                Yii::$app->session->addFlash('successmessage', "Successfully Saved");
                return $this->redirect(['view', 'id' => $id]);

            } else {
                Yii::$app->session->addFlash('errormessage', "Something Went wrong ");
         
            }
            

        }else{
            $model=new StudentAttendance();
            $model->batch_id=$id;
            $model->attendance_data=json_encode($data);
            if ($model->save()) {
                Yii::$app->session->addFlash('successmessage', "Successfully Saved");

                return $this->redirect(['view', 'id' => $id]);

            } else {
                Yii::$app->session->addFlash('errormessage', "Something Went wrong ");
         
            }
        }
   

    
       }
      
     
        return $this->render('mark-attendance', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
            'uploadForm' => new UploadForm()
        ]);
    }

    /**
     * Updates an existing TargetBatch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
       
        $model = $this->findModel($id);

     
        if ($model->final_submit&&Yii::$app->user->identity->role!=1) {
            throw new \yii\web\HttpException(403,
            'This Batch is final submitted . You can not update .Please contact Admin');
        }
        // $model->final_submit=1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionFinal($id)
    {
        if (!BatchStudents::find()->where(['batch_id'=>$id])->count()) {
            throw new \yii\web\HttpException(403,
            'You can not submit this batch . Please add student first.');
        }
        $model = $this->findModel($id);
        $model->final_submit=1;
        $model->save();

        return $this->redirect(['view', 'id' => $id]);

    }

    /**
     * Deletes an existing TargetBatch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
  if (Yii::$app ->user ->identity->role==5) {
            throw new \yii\web\HttpException(403, 'You do not have permission to access this page. Contact admin');
        }
        $model= $this->findModel($id);
        if ($model->final_submit&&Yii::$app->user->identity->role!=1) {
            throw new \yii\web\HttpException(403,
            'This Batch is final submitted . You can not update .Please contact Admin');
        }
       
        if (TransDetail::find()->where(['batch_id'=>$id])->count()) {
            throw new \yii\web\HttpException(403,
            'You can not Delete this batch. Trans of this batch is under processing.');
        }
        $model->delete();

        return $this->redirect(['index','type'=>3]);
    }

    /**
     * Finds the TargetBatch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TargetBatch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TargetBatch::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMultipleDelete()
    {
        $pk = Yii::$app->request->post('row_id');
        $bid=0;
        foreach ($pk as $key => $id) 
        {
            $bid=BatchStudents::findOne($id)->batch_id;
            if(BatchStudents::findOne($id)->delete())
                 Yii::$app->session->addFlash('successdeleted', "Successfully Deleted");

        }
        return $this->redirect(['view', 'id' => $bid]);

        // return $this->redirect(['index']);

    }
    
}
