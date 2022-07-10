<?php

namespace app\controllers;

use Yii;
use app\models\TransDetail;
use app\models\CommonModel;
use app\models\search\TransDetail as TransDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\web\Response;
use app\models\BatchStudents;
use app\models\StudentResult;
use app\models\StudentPlacement;
use app\models\TargetBatch;
use app\models\search\StudentResult as StudentResultSearch;
use app\models\search\TargetBatch as TargetBatchSearch;
use app\models\search\BatchStudents as BatchStudentsSearch;
/**
 * TransController implements the CRUD actions for TransDetail model.
 */
// ALTER TABLE `student_result`  ADD `result1` TINYINT NULL  AFTER `reclaim`,  ADD `result2` TINYINT NULL  AFTER `result1`;
class TransController extends Controller
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
    public function displayError()
    {
        // echo "error";
        if (Yii::$app->user->identity->role!=3
        &&Yii::$app->user->identity->role!=1
        &&Yii::$app->user->identity->role!=5
        &&Yii::$app->user->identity->role!=4
        
        ) {
            throw new \yii\web\HttpException(403,
            'You do not have permission to access this page. Contact admin');
        
        $exception = Yii::$app->errorHandler->exception;
       
        return $this->render('/site/error', ['exception' => $exception
            ,'name'=>"Error",
            "message"=> $exception ]);
        }
    }

    /**
     * Lists all TransDetail models.
     * @return mixed
     */
    public function actionBill($id)
    {
        $model=$this->findModel($id);
        if ($model->status!=3) {
            throw new \yii\web\HttpException(403,
            'Bill of Supply Not Generated'); 
        }
        if (Yii::$app->user->identity->role==3){
            $tcdetails=CommonModel::getTcdetailbyuserid();
            if ($model->tc_id!= $tcdetails['id']) {
                throw new \yii\web\HttpException(403,
                'You do not have permission to view this page'); 
            }
        }
        return $this->render('bill', [
            'model'=>$model
        ]); 
    }   
    
    public function actionDecelare($id)
    {
        $model=$this->findModel($id);
        if ($model->status==2) {
            throw new \yii\web\HttpException(403,
            'You do not have permission to access this page. ');
        }
        return $this->render('decelare', [
            'model'=>$this->findModel($id)
        ]);
    }
    public function actionIndex()
    {
        switch (Yii::$app->user->identity->role) {
            case 1:
                $searchModel = new TransDetailSearch();
            break;           
            case 5:
                $searchModel = new TransDetailSearch();
            break;    
            case 3:
                $tcdetails=CommonModel::getTcdetailbyuserid();
                $searchModel = new TransDetailSearch(['tc_id'=>$tcdetails['id']]);
            break;
        
            default:
                $searchModel = new TransDetailSearch(['user'=>3]);
            break;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
     


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TransDetail model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        switch (Yii::$app->user->identity->role) {
            case 1:
               $viewFile='view/admin-view';
            break;           
            
            case 3:
              $viewFile='view/tc-view';
            break;
        
            default:
              $viewFile='view/view';
        }
        // $viewFile='view/view';
        $data=$this->findModel($id);
        if (Yii::$app->user->identity->role==3){
            $tcdetails=CommonModel::getTcdetailbyuserid();
            if ($data->tc_id!= $tcdetails['id']) {
                throw new \yii\web\HttpException(403,
                'You do not have permission to view this page'); 
            }
        }
        $searchModel = new BatchStudentsSearch(['batch_id'=>$data->batch_id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render($viewFile, [
            'model' => $data,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    function actionDecesion($id){
        $model = $this->findModel($id);

        $model->load(Yii::$app->request->post());


       if ($model->status==1) {
        $viewFile='view/yes-view';

       }else if ($model->status==2) {
        $viewFile='view/no-view';


       }else{
        return $this->redirect(['view','id'=>$id]);

       }
       
        return $this->render($viewFile, [
            'model' => $this->findModel($id),
        ]);
    }

    function actionSecondClaim($id)
    {
        // echo $id;
        // die;
        $post=Yii::$app->request->post();
        if ($post) {
            $model = new TransDetail();
            $tcdetails=CommonModel::getTcdetailbyuserid();
            // Yii::$app->session->addFlash('Message', "All Details are filled by your parent Training Partner . Contact T.P for changes");
            
            // Yii::$app->session->addFlash('successcreated', "Created Successfully");
            $model->status=0;
           $model->tc_id= $tcdetails['id'];
           $model->updated_at = date('Y-m-d H:i:s');
           $model->updated_by = Yii::$app->user->id;
           $model->message_admin = " ";
           $model->created_at = date('Y-m-d H:i:s');  
           $model->updated_at = date('Y-m-d H:i:s');
           $model->batch_id=$id;
           $model->claim_type=1;
           $model->is_tds_deduct=0;
            $model->trans_percent=0;
           $model->save(); 
           foreach ($post['assesment'] as $key => $value) {
            $modelAssesment = new StudentResult();
            $modelAssesment->student_id=$key;
            $modelAssesment->result=$value;
            $modelAssesment->batch_id=$id;
            $modelAssesment->save();
           }
           return $this->redirect(['index']);
        }
    }   

    function actionReassesClaim1($id)
    {
        $post=Yii::$app->request->post();
   
        if ($post) {
            $model = new TransDetail();
            $tcdetails=CommonModel::getTcdetailbyuserid();
            // Yii::$app->session->addFlash('Message', "All Details are filled by your parent Training Partner . Contact T.P for changes");
            
            // Yii::$app->session->addFlash('successcreated', "Created Successfully");
            $model->status=0;
           $model->tc_id= $tcdetails['id'];
           $model->updated_at = date('Y-m-d H:i:s');
           $model->updated_by = Yii::$app->user->id;
           $model->message_admin = " ";
           $model->created_at = date('Y-m-d H:i:s');  
           $model->updated_at = date('Y-m-d H:i:s');
           $model->batch_id=$id;
           $model->claim_type=3;
           $model->is_tds_deduct=0;
            $model->trans_percent=0;
           $model->save(); 
           foreach ($post['assesment'] as $key => $value) {
            $modelAssesment =  StudentResult::find()->where([
                'student_id'=>$key,
                'batch_id'=>$id
                ])->one();

  
            $modelAssesment->student_id=$key;
            $modelAssesment->result1=$value;
            $modelAssesment->batch_id=$id;
            $modelAssesment->reclaim=1;
            $modelAssesment->save();
           }
        //    die;
           return $this->redirect(['index']);
        }
    }  

    function actionReassesClaim2($id)
    {
        $post=Yii::$app->request->post();
   
        if ($post) {
            $model = new TransDetail();
            $tcdetails=CommonModel::getTcdetailbyuserid();
            // Yii::$app->session->addFlash('Message', "All Details are filled by your parent Training Partner . Contact T.P for changes");
            
            // Yii::$app->session->addFlash('successcreated', "Created Successfully");
            $model->status=0;
           $model->tc_id= $tcdetails['id'];
           $model->updated_at = date('Y-m-d H:i:s');
           $model->updated_by = Yii::$app->user->id;
           $model->message_admin = " ";
           $model->created_at = date('Y-m-d H:i:s');  
           $model->updated_at = date('Y-m-d H:i:s');
           $model->batch_id=$id;
           $model->claim_type=4;
           $model->is_tds_deduct=0;
            $model->trans_percent=0;
           $model->save(); 
           foreach ($post['assesment'] as $key => $value) {
            $modelAssesment =  StudentResult::find()->where([
                'student_id'=>$key,
                'batch_id'=>$id
                ])->one();
  
            $modelAssesment->student_id=$key;
            $modelAssesment->result2=$value;
            $modelAssesment->batch_id=$id;
            $modelAssesment->reclaim=2;
            $modelAssesment->save();
           }
        //    die;
           return $this->redirect(['index']);
        }
    }  
    function actionThirdClaim($id)
    {
        
        // echo $id;
        // die;
        $post=Yii::$app->request->post();
       
        if ($post) {
            $model = new TransDetail();
            $tcdetails=CommonModel::getTcdetailbyuserid();
            // Yii::$app->session->addFlash('Message', "All Details are filled by your parent Training Partner . Contact T.P for changes");
            
            // Yii::$app->session->addFlash('successcreated', "Created Successfully");
            $model->status=0;
           $model->tc_id= $tcdetails['id'];
           $model->updated_at = date('Y-m-d H:i:s');
           $model->updated_by = Yii::$app->user->id;
           $model->message_admin = " ";
           $model->created_at = date('Y-m-d H:i:s');  
           $model->updated_at = date('Y-m-d H:i:s');
           $model->batch_id=$id;
           $model->claim_type=2;
           $model->is_tds_deduct=0;
           $model->trans_percent=0;
           $model->save(); 
           foreach ($post['result'] as $key => $value) {
            $modelAssesment = new StudentPlacement();
            $modelAssesment->student_id=$key;
            $modelAssesment->result=$value;
            if ($value) {
                $modelAssesment->placed_organisation=$post['placed_organisation'][$key];
                $modelAssesment->package_pm=$post['package_pm'][$key];
            }
           
            $modelAssesment->batch_id=$id;
            $modelAssesment->save();
           }
           return $this->redirect(['index']);
        }
    }

    public function actionUploadFile()
    {
        $code=false;
        $model = new UploadForm();
        $post=Yii::$app->request->post();
        $model->file = UploadedFile::getInstancesByName('file')[0];
        $name='uploads/placement/'.$post['student_id']. '.' . $model->file->extension;
        if ($model->validate()) {                
            $code= $model->file->saveAs( $name ,$model->file->baseName . '.' . $model->file->extension);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' =>$code,'errors'=>@$model->errors['file'][0]];
    }
    function actionForward($id){
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post());
        
       if ($model->status==1) {
         if ($model->save()) {
             # code...
             Yii::$app->session->addFlash('successmessage', "Tranche Forwarded Successfully");
         }
   
       }else if ($model->status==2) {
        if ($model->save()) {
            # code...
            Yii::$app->session->addFlash('successmessage', "Tranche Denied Successfully");
        }

       }else if ($model->status==3) {
        if ($model->save()) {
            # code...
            Yii::$app->session->addFlash('successmessage', "Bill of Supply Generated Successfully");
        }

       }else if ($model->status==4) {
        if ($model->save()) {
            # code...
            Yii::$app->session->addFlash('successmessage', "Tranche Denied Successfully");
        }

       }
        return $this->redirect(['view','id'=>$id]);

    }
    /**
     * Creates a new TransDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TransDetail();
        $tcdetails=CommonModel::getTcdetailbyuserid();
        // Yii::$app->session->addFlash('Message', "All Details are filled by your parent Training Partner . Contact T.P for changes");
        
        // Yii::$app->session->addFlash('successcreated', "Created Successfully");
        $model->status=0;
       $model->tc_id= $tcdetails['id'];
       $model->updated_at = date('Y-m-d H:i:s');
       $model->updated_by = Yii::$app->user->id;
       $model->message_admin = " ";
       $model->created_at = date('Y-m-d H:i:s');  
       $model->updated_at = date('Y-m-d H:i:s');
       $model->is_tds_deduct=0;
       $model->trans_percent=0;
    
       
        if ($model->load(Yii::$app->request->post()) ) {
            if(TransDetail::find()->where([
                'claim_type'=>$model->claim_type,
                'batch_id'=>$model->batch_id,
            ])->one()){
                throw new \yii\web\HttpException(403, 'Already Applied for this Tranche . Can not reapply.');
            }
            if ($model->claim_type==1) {
                // die;
                if ($model->validate()) {
                    $searchModel = new BatchStudentsSearch(['batch_id'=>$model->batch_id]);
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                    return $this->render('student-result', [
                        'model' =>  TargetBatch::findOne($model->batch_id),
                        'dataProvider' => $dataProvider,
                        'trans'=>$model
                    ]);
                } else {
                    // validation failed: $errors is an array containing error messages
                    $errors = $model->errors;
                    foreach ($errors as $key => $value) {
                        Yii::$app->session->addFlash('errormessage',$value[0]);
                    break;
                    }
                }
              
            }
            if ($model->claim_type==2) {
                // die;
                $searchModel = new StudentResultSearch(['batch_id'=>$model->batch_id,'reclaim'=>3]);
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                return $this->render('student-placement', [
                    'model' =>  TargetBatch::findOne($model->batch_id),
                    'dataProvider' => $dataProvider,
                    'trans'=>$model

                ]);
            }
            if ($model->claim_type==3) {
                if(TransDetail::find()->where([
                    'claim_type'=>2,
                    'batch_id'=>$model->batch_id,
                ])->one()){
                    throw new \yii\web\HttpException(403, 'Can not apply for this Tranche . Because you applied for Third Claim');
                }
                $searchModel = new StudentResultSearch(['batch_id'=>$model->batch_id,'result'=>2]);
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                return $this->render('student-result', [
                    'model' =>  TargetBatch::findOne($model->batch_id),
                    'dataProvider' => $dataProvider,
                    'trans'=>$model
                ]);
            }
            if ($model->claim_type==4) {
                if(TransDetail::find()->where([
                    'claim_type'=>2,
                    'batch_id'=>$model->batch_id,
                ])->one()){
                    throw new \yii\web\HttpException(403, 'Can not apply for this Tranche . Because you applied for Third Claim');
                }
                $searchModel = new StudentResultSearch(['batch_id'=>$model->batch_id,'result1'=>2]);
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                return $this->render('student-result', [
                    'model' =>  TargetBatch::findOne($model->batch_id),
                    'dataProvider' => $dataProvider,
                    'trans'=>$model
                ]);
            }
            if ($model->save()) {
                # code...
                Yii::$app->session->addFlash('successmessage', "Tranche Claimed Successfully");

                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TransDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionDrive()
    {
       

        return $this->render('drive', [
           
        ]);
    }


    /**
     * Deletes an existing TransDetail model.
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TransDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TransDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TransDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
