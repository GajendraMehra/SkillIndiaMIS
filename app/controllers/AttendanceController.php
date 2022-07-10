<?php

namespace app\controllers;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\TargetBatch;
use app\models\search\TargetBatch as TargetBatchSearch;
use app\models\StudentAttendance;
use app\models\Student;
use app\models\UploadForm;
use yii\web\Response;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use app\models\CommonModel;
use app\models\search\BatchStudents as BatchStudentsSearch;
use yii\web\UploadedFile;


class AttendanceController extends \yii\web\Controller

{

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
        // echo "error";
        $actionName=Yii::$app ->controller ->action->id;
        
        if ($actionName == "viewStudent"
        
            )
        {
            $role_id = 1;
        }elseif($actionName=="view"
        ||$actionName=="update"
        ||$actionName=="index"
        ||$actionName=="delete"
        ){
            $role_id = 0;
        }
        else
        {
            $role_id = 3;
        }
        // die;
        if (Yii::$app ->user ->identity->role != 3
        &&Yii::$app ->user ->identity->role != 1
        ) {
            throw new \yii\web\HttpException(403, 'You do not have permission to access this page. Contact admin');
            
         
        }
    }
    public function actionIndex($type=1)
    {
        $type=1;
        // mark final submit if not submitted by training center after checking end dates 

        $ids=TargetBatch::find()->select('id')->where(['<=','start_date',date('Y-m-d')])->asArray()->all();

        foreach ($ids as $key => $value) {
            // $model=TargetBatch::findOne($value['id']);
            // $model->final_submit=1;
            // $model->save();

        }
   
        if (Yii::$app->user->identity->role==1) {
            $searchModel = new TargetBatchSearch(['final_submit'=>1,'type'=>$type]);
           
        }else{
        $tcdetails=CommonModel::getTcdetailbyuserid();

            

            $searchModel = new TargetBatchSearch(['tc_id'=>$tcdetails['id'],'type'=>$type]);
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      
        // echo "<pre>";
      
    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionAllBatch(){
        $type=3;
        // mark final submit if not submitted by training center after checking end dates 

        $ids=TargetBatch::find()->select('id')->where(['<=','start_date',date('Y-m-d')])->asArray()->all();

        foreach ($ids as $key => $value) {
            // $model=TargetBatch::findOne($value['id']);
            // $model->final_submit=1;
            // $model->save();

        }
        if (Yii::$app->user->identity->role==1) {
            $searchModel = new TargetBatchSearch(['final_submit'=>1,'type'=>$type]);
           
        }else{
            $tcdetails=CommonModel::getTcdetailbyuserid();

            

            $searchModel = new TargetBatchSearch(['tc_id'=>$tcdetails['id'],'type'=>$type]);
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('attendancebatch', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
    
        $searchModel = new BatchStudentsSearch(['batch_id'=>$id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
            'model' => TargetBatch::findOne($id),
            'dataProvider' => $dataProvider
        ]);
    } 
    public function actionBatchAttendance($id)
    {
        $model=StudentAttendance::findOne(['batch_id'=>$id]);
        if (!@$model->attendance_data) {
            Yii::$app->session->addFlash('errormessage', "No Reprot found for this Batch");

            return $this->redirect(['all-batch','type' => 3]);

        }
       $dates=array_keys((Array)json_decode($model->attendance_data));
       $values=array_values((Array)json_decode($model->attendance_data));
   
       foreach ($values as $key => $value) {
           $dataArray=array_values((array)$value);
           $dataKey=array_keys((array)$value);
    //    var_dump($dataKey);

           for ($i=0; $i < sizeof($dataArray); $i++) { 
               

            $output[$i][]=$dataArray[$i];
           }
    //    print_r($output);

        //    array_unshift($output[$key], $dataKey);
         
       }
   
       foreach ($dataKey as $key => $value) {
          $studentData= Student::findOne($value);
          $counts = array_count_values($output[$key]);

       

          array_unshift($output[$key], round($counts['1']/sizeof($output[$key])*100,'2') .' %');
          array_unshift($output[$key], $studentData->student_name);
           array_unshift($output[$key], $studentData->sip_id);
            //   $output[$key][]=63;
        

        //  array_unshift($studentData->hope_id, $dataKey[$key]);
        //  array_unshift($studentData->student_name, $dataKey[$key]);

       }
   

        return $this->render('view-batch-attendance',
        [
            'dates'=>$dates,
            'attendance'=>$output,
            'bid'=>$id,
            'model' =>  TargetBatch::findOne($id),
        ]
        
    );
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
        'model' =>  TargetBatch::findOne($id),
        'dataProvider' => $dataProvider,
        'uploadForm' => new UploadForm()
    ]);
}

    
       

public function actionUpload($bid)
{
    $model = new UploadForm();

    $code=0;
    $message="Error While uploading";
    Yii::$app->response->format = Response::FORMAT_JSON;
    if (Yii::$app->request->isPost) {
        $foldername=realpath(Yii::$app->basePath).'/web/uploads/attendance/'.$bid;
        if (!is_dir($foldername)) {
            # code...
           mkdir($foldername, 0755, true);
        }
           
        
        $model->file = UploadedFile::getInstance($model, 'file');
        // echo "<pre>";
        // print_r($model->file);
        // die;
        $name=$foldername.'/'.date('Y-m-d').'.'.$model->file->extension;
        if ($model->validate()) {                
            $code= $model->file->saveAs( $name ,$model->file->baseName . '.' . $model->file->extension);
            $sizes = getimagesize ( $name ); 
            if ($model->file->size<=2097152&&$model->file->size>1572864) {
               $factor=8;
            }elseif ($model->file->size<=1572864&&$model->file->size>1048576) {
               $factor=5;
            }elseif ($model->file->size<=1048576&&$model->file->size>524288) {
               $factor=3;
            }
            elseif ($model->file->size<=524288&&$model->file->size>153600) {
               $factor=2;
            }else{
                $factor=1;
            }
            Image::getImagine()->open($name)->thumbnail(new Box($sizes[0]/$factor,$sizes[1]/$factor))->save($name , ['quality' => 30]);
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

public function actionSnaps($id)
{
    $files=[];
 
    $dir=realpath(Yii::$app->basePath).'/web/uploads/attendance/'.$id;
 
    if(is_dir($dir)) {
        $files = array_diff(scandir($dir,SCANDIR_SORT_DESCENDING), array('..', '.'));
    
    return $this->render('snaps', [
        'model' =>  TargetBatch::findOne($id),
        'files' =>  $files
    ]);
    } else {
      throw new \yii\web\HttpException(403, 'No Snaps Avaliabel for this Batch.');
    }
    // echo $dir;
  
}
      

}
