<?php

namespace app\controllers;

use Yii;
use app\models\Targets;
use app\models\TargetJob;
use app\models\TargetBatch;
use app\models\search\Scheme as SchemeSearch;
use app\models\Tcdetail;
use app\models\TcenterBank;
use app\models\UploadForm;
use app\models\Users;
use app\models\TcenterSpocoperation;
use app\models\CommonModel;
use app\models\TcenterAddress;
use frontend\models\SignupForm;

// use app\models\Tcdetail;

use app\models\search\Targets as TargetsSearch;
use app\models\search\TargetsResponse as TargetsResponseSearch;
use yii\web\UploadedFile;
use app\models\TargetDistrict;
use app\models\search\TargetDistrict as TargetDistrictSearch;
use app\models\search\TargetJob as TargetJobSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\TargetsResponse;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * TargetController implements the CRUD actions for Targets model.
 */
class TargetController extends Controller
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
                    'target-close' => ['POST'],
                ],
               
            ], 'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
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
    
        public function displayError()
        {
            if(Yii::$app->user->identity->role==3){
                throw new \yii\web\HttpException(403,
                'You do not have permission to access this page.');
            
            }
            $actionName=Yii::$app ->controller ->action->id;
            
            if ($actionName == "view"
                ||$actionName=="create"
                ||$actionName=="update"
                ||$actionName=="upload"
                ||$actionName=="set-status"
                ||$actionName=="delete"
                ||$actionName=="index"
                ||$actionName=="view-response"
                ||$actionName=="acknowledge"
                ||$actionName=="center-view"
                ||$actionName=="center-view-by-id"
                )
            {
                $role_id = 1;
            }
            else
            {
                $role_id = 2;
               
            }
            // die;
        if (Yii::$app ->user ->identity->role!=5) {
            
            if (Yii::$app ->user ->identity->role != $role_id) {
                throw new \yii\web\HttpException(403, 'You do not have permission to access this page. Contact admin');
                
                $exception = Yii::$app ->errorHandler->exception;
                
                return $this->render('/site/error', ['exception' => $exception, 'name' => "Error", "message" => $exception]);
            }
        }
    }

    /**
     * Lists all Targets models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity->role!=1&&Yii::$app->user->identity->role!=5) {
            throw new \yii\web\HttpException(403, 'You do not have permission to access this page. Contact admin');
        }
        $searchModel = new TargetsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } 
    public function actionAcknowledge()
    {
        if (Yii::$app->user->identity->role!=1&&Yii::$app->user->identity->role!=5) {
            throw new \yii\web\HttpException(403, 'You do not have permission to access this page. Contact admin');
        }
        $searchModel = new TargetsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('acknowledge', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } 

    public function actionView($id)
    {
        $datamodel=$this->findModel($id);
      
        $searchModel = new TargetDistrictSearch(['target_id'=>$id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $searchModel1 = new TargetJobSearch(['target_id'=>$id]);
        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams);

        // print_r($model1);
        // $model2=  TargetJob::find()->where(['target_id'=>$id])->all();
        return $this->render('view', [
            'model' =>$datamodel,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProvider1' => $dataProvider1,
            // 'model2' => $model2,1111
           
        ]);
    }

    public function actionCenterView($id)
    {
        $cid=TargetsResponse::findOne($id)['tc_id'];
        $model1 = TcenterAddress::find()->where(['tc_id' => $cid])->one();
        $model2 = TcenterBank::find()->where(['tc_id' => $cid])->one();
        $model3 = TcenterSpocoperation::find()->where(['tc_id' => $cid])->one();
        return $this->renderPartial('centerview', [
            'model' =>Tcdetail::findOne($cid),
            'model1' => $model1,
            'model2' => $model2,
            'model3' => $model3,
        ]);
    }    
    public function actionCenterViewById($id)
    {
        $cid=TargetBatch::findOne($id)['tc_id'];
        $model1 = TcenterAddress::find()->where(['tc_id' => $cid])->one();
        $model2 = TcenterBank::find()->where(['tc_id' => $cid])->one();
        $model3 = TcenterSpocoperation::find()->where(['tc_id' => $cid])->one();
        return $this->renderPartial('centerview', [
            'model' =>Tcdetail::findOne($cid),
            'model1' => $model1,
            'model2' => $model2,
            'model3' => $model3,
        ]);
    }
    public function actionViewResponse($id)
    {
        if (!TargetsResponse::find()->where(['target_id'=>$id])->all()) {
            # code...
            throw new \yii\web\HttpException(403, 'You  have not  applied for this target yet');
        }
        
        $searchModel = new TargetsResponseSearch(['target_id'=>$id]);
        $dataProvider = $searchModel->centerwisedata(Yii::$app->request->queryParams);
        // Yii::$app->session->addFlash('tips',  "Expand Training Center row to see all the applied jobs. Be careful for your action. Once the action is taken it can not be reverted back" );
        
        return $this->render('view_response', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model1' => $this->findModel($id),
            'model' => new UploadForm()
        ]);
    }

    public function actionUpload()
    {
        $model = new UploadForm();
        // echo '<pre>';
        // print_r($_FILES); 
        // print_r($_POST); 
        // echo '</pre>';
        // die;
        $code=0;
        $message="Error While uploading";
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $name='uploads/lordocument/'.time().'.'.$model->file->extension;

            if ($model->validate()) {                
                $code= $model->file->saveAs( $name ,$model->file->baseName . '.' . $model->file->extension);
            }else{
                $message=$model->errors['file'][0];
            }
        }
    
        return ['code'=>$code,
        'name'=>$name,
        'message'=>$message
            

        ];

        // return $this->render('upload', ['model' => $model]);
    }
    public function actionUpdate($id)
    {
            $model=   $this->findModel($id) ;
            $model1 = new TargetDistrict();
            $model2 = new TargetJob();
         
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('successupdated', "Updated Successfully");



            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('_form_update', [
            'model' => $model,
            'model1' => $model1,
            'model2' => $model2,
        ]);
    }
    public function actionAssignedIndex()
    {

        switch ($_GET['filter']) {
            case 'apply':
           $title="Targets Waiting for response";
                break;   
                case 'applied':
            $title="Applied Targets";

                break;
            
            default:
            $title="All Targets";
            
                break;
        }
        $tpdetails=CommonModel::getTpdetailbyuserid();
        $searchModel = new TargetsSearch(['tp_id'=>$tpdetails['id']]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('assignedIndex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tpDetails' => $tpdetails,
            'title' => $title,
        ]);
    }
    
    public function actionSetStatus()
    {
        $code=0;
        $reg=0;
        $post=Yii::$app->request->post();
        // 
       
        // 
        $text = ($post['status']==1) ? "Job Approved" : "Job Declined " ;
        if ($post) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $code=TargetsResponse::updateAll(['status' => $post['status'],'action_id'=>$post['actionId']], ['tc_id'=> $post['centerId'],
            'id'=> $post['responseId']
            ]);
            if ($code>0) {
                if ($post['status']==1) {
                    # code...
                    $reg= $this->registerCenter($post['centerId']);
                    if ($reg) {
                        # code...
                        Yii::$app->session->addFlash('Done',  $text ." . Login Credientials sent to Training Center registered email" );
                    }else{

                        Yii::$app->session->addFlash('Approved',  $text );
                    }

                }else{

                    Yii::$app->session->addFlash('Done',  $text );
                }
            }
            return [
                'code'=>$code,
                'isreg'=>$reg
        
        ];
        }
      
       
    }
    public function registerCenter($cid)
    {
        $center=Tcdetail::findOne($cid);
        
        if ($center) {
            if (Users::find()->where(['email'=>$center['email']])->one()) {
              return false;
            }else{
                $signupmodel = new SignupForm();
                $signupmodel->email=$center['email'];
                $signupmodel->username=$center['smart_tcid'];
                // $signupmodel->password="Thdsjk234#3423";
                $signupmodel->password= "Z".uniqid();
                $signupmodel->role=3;
                return $signupmodel->signup();
            }
        }
        // die;
    }
   
    public function actionSchemeWiseIndex()
    {
        // sYdEE5xKNycUk4A
        $tpdetails=CommonModel::getTpdetailbyuserid();
        $searchModel = new TargetsSearch(['tp_id'=>$tpdetails['id']]);
        $dataProvider = $searchModel->search1(Yii::$app->request->queryParams);

        return $this->render('schemewise', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tpDetails' => $tpdetails,
        ]);
    }  
    

    public function actionCreate()
    {
        $model = new Targets();
        $model->updated_at = date('Y-m-d H:i:s');
        $model->edited_by = Yii::$app->user->id;
        $model->created_at = date('Y-m-d H:i:s');
        $model->status=1;
        $model1 = new TargetDistrict();
        $model2 = new TargetJob();
        // $model->validate();
        // $model1->validate();
        // $model2->validate();
        $post=$_POST;
   
        $model->load(Yii::$app->request->post());
        $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        // echo "<pre>";
        // print_r( $model->imageFile);die;
        $model->work_order_file ='';
        if ($model->imageFile ) {
   
            $filename=$model->upload();
        if ($filename) {
            $model->work_order_file=$filename;
            // $model->imageFile = 'null';
            // $model->save(false);x`
           
        if ($model->save(false)) {
            $count=0;
            Yii::$app->session->addFlash('successcreated', "Created Successfully");
          foreach ($post['TargetDistrict']['district_id'] as $key => $value) {
 
            $model1 = new TargetDistrict();
            $model1->target_id=$model->id;
            $model1->district_id=$value;
            $model1->save();
  
          } 
          foreach ($post['TargetJob']['job_id'] as $key => $value) {
            $model1 = new TargetJob();
            $model1->target_id=$model->id;
            $model1->job_id=$value;
            $model1->save();

        // $model1->target_id=$model->id;
              # code...
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        }
        }else if($post){
        Yii::$app->session->addFlash('Error', "Please Upload work order please ");      

        }

        return $this->render('create', [
            'model' => $model,
            'model1' => $model1,
            'model2' => $model2,
        ]);
    } 
    public function actionApply($id)
    {
        $targetModel=$this->findModel($id);
        if(Yii::$app->user->identity->id!=$targetModel->tp->edited_by){
            throw new \yii\web\HttpException(403,
            'You do not have permission to access this page.');
        
        }
        if ($targetModel->status!=1) {
            # code...
            throw new \yii\web\HttpException(403, 'This Target is Closed By Admin');
        }
        
        //  echo"<pre>";
        $post=Yii::$app->request->post();
        // echo "<pre>";
        //  print_r($post);die;
        if (Yii::$app->request->post()) {
            $tpdetails=CommonModel::getTpdetailbyuserid();
          
            foreach ($post['TargetsResponse']['target_response'] as $key => $value) {
                if(sizeof($value)==4){
                $model = new TargetsResponse();
                $model->updated_at = date('Y-m-d H:i:s');
                $model->edited_by = Yii::$app->user->id;
                $model->created_at = date('Y-m-d H:i:s');
                $model->target_id=$post['TargetsResponse']['target_id'];
                $model->job_id=$value['job_id'];
                $model->district_id=$value['district_id'];
                $model->tc_id=$value['tc_id'];
                $model->tp_id=$tpdetails['id'];
                $model->response_number=$value['response_number'];
                $model->status=0;


                // restrict number to not exceed the assigned targets
                $assign=TargetsResponse::find()->andWhere(['!=','status',2])->andWhere(['target_id'=>$id])->sum('response_number');
                $total=Targets::findOne($id)->number;
                 $remaining=$total-$assign;
                 if ($remaining>=  $model->response_number) {
                    $model->save();
                 }else{
                    Yii::$app->session->addFlash('errormessage', "Limit Exceed . Please fill no less than or equal to the remaning target.");
                 }


                // 
               
                }
               
            }
            Yii::$app->session->addFlash('Done', "Successfully Applied");

            return $this->redirect(['/target/assigned-index', 'sort' => '-id','filter'=>'applied']);
        }

        return $this->render('apply', [
            'model' => new TargetsResponse(),
            'model1' => $targetModel,
        ]);
    } 
 
    public function actionApplied($id)
    {
        $datamodel=$this->findModel($id);
        if(Yii::$app->user->identity->id!=$datamodel->tp->edited_by){
            throw new \yii\web\HttpException(403,
            'You do not have permission to access this page.');
        
        }
        if (!TargetsResponse::find()->where(['target_id'=>$id])->all()) {
            # code...
            throw new \yii\web\HttpException(403, 'You  have not  applied for this target yet');
        }
     
        
        $searchModel = new TargetsResponseSearch(['target_id'=>$id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $post=Yii::$app->request->post();
        $flag=true;
        if (Yii::$app->request->post()) {
            $assign=TargetsResponse::find()->andWhere(['!=','status',2])->andWhere(['target_id'=>$id])->sum('response_number');
            $total=Targets::findOne($id)->number;
            $remaining=$total-$assign;
            $tpdetails=CommonModel::getTpdetailbyuserid();
          
            foreach ($post['TargetsResponse']['target_response'] as $key => $value) {
                if(sizeof($value)==4){
                   if ($value['response_number']>$remaining) {
                       $flag=false;
                    Yii::$app->session->addFlash('errormessage', "Limit Exceed . Please fill no less than or equal to the remaning target.");

                   }else{
                    $model = new TargetsResponse();
                    $model->updated_at = date('Y-m-d H:i:s');
                    $model->edited_by = Yii::$app->user->id;
                    $model->created_at = date('Y-m-d H:i:s');
                    $model->target_id=$post['TargetsResponse']['target_id'];
                    $model->job_id=$value['job_id'];
                    $model->district_id=$value['district_id'];
                    $model->tc_id=$value['tc_id'];
                    $model->tp_id=$tpdetails['id'];
                    $model->response_number=$value['response_number'];
                    
                    $model->status=0;
                    $model->save();
                   }
               
                }
               
            }
            if ($flag) {
                Yii::$app->session->addFlash('Done', "Successfully Applied");

                return $this->redirect(['/target/applied', 'id' => $id]);
            }
            
        }
        return $this->render('applied', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model1' => $this->findModel($id),
            'model' => new TargetsResponse(),
        ]);
    }


 
    /**
     * Deletes an existing Targets model.
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
        if (TargetsResponse::find()->where(['target_id'=>$id])->count()) {
            throw new \yii\web\HttpException(403,
            'You can not Delete this Target. TP responded for this Target');
        }
     
        if($this->findModel($id)->delete())
        Yii::$app->session->addFlash('successdeleted', "Successfully Deleted");

        return $this->redirect(['index','filter'=>'all']);
    }  
    
    public function actionTargetClose($id)
    {
        $model= $this->findModel($id) ;
        $model->status=0;
     
        if ( $model->save()) {
            Yii::$app->session->addFlash('successupdated', "Updated Successfully");

            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            print_r($model->errors);
            die;
        }
    }

    /**
     * Finds the Targets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Targets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Targets::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actionMultipleDelete()
    {
        $pk = Yii::$app->request->post('row_id');

        foreach ($pk as $key => $id) 
        {
            if($this->findModel($id)->delete())
        Yii::$app->session->addFlash('successdeleted', "Successfully Deleted");

        }

        return $this->redirect(['index']);

    }
}
