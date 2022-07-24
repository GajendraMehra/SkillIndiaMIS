<?php

namespace app\controllers;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Scheme;
use app\models\Targets;
use app\models\Job;
use app\models\StudentResult;
use app\models\StudentPlacement;
use app\models\TargetsResponse;
use app\models\Tcdetail;
use app\models\TargetBatch;
use app\models\BatchStudents;
use app\models\UkDistrict;
use app\models\TransDetail;
use app\models\TpartnerDetail;
use app\models\search\TargetBatch as TargetBatchSearch;
class ReportController extends \yii\web\Controller
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
        if (Yii::$app->user->identity->role!=1&&Yii::$app->user->identity->role!=5) {
            throw new \yii\web\HttpException(403,
            'You do not have permission to access this page. Contact admin');
        
     
        }
    }
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionBatch($type)
    {
        
        $searchModel = new TargetBatchSearch(['final_submit'=>1,'type'=>$type]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('batch-report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
public function getStudents($bid){
    $connection = Yii::$app->getDb();
    $command = $connection->createCommand("
    SELECT 
    student.*,
    sr.result,
    sp.placed_organisation,
    sp.package_pm
     FROM 
    `tbl_batch_students` as bs INNER JOIN tbl_student AS student on student.id=bs.student_id
    left join student_result as sr on sr.student_id=student.id 
    left join student_placement as sp on sp.student_id=student.id 
    where bs.batch_id=:bid",
     [':bid' =>$bid]);
    $extract=['','hope_id','sip_id','employment_id','student_name','aadhar_no','dob','phone_no','email','mother_name','father_name','result','placed_organisation','package_pm'];
    $returnArray=[];
    $result = $command->queryAll();
    foreach ($result as $key => $value) {
        
        foreach ($value as $key1 => $value1) {

            if(array_search($key1,$extract)!="")
            $returnArray[$key][$key1]=$value1;
        }
        }
       
        
    return $returnArray;
}

public function getStudentsCat($bid){
    $connection = Yii::$app->getDb();
    $command = $connection->createCommand("
    SELECT COUNT(DISTINCT tbl_student.id) as count,category FROM `tbl_batch_students` INNER JOIN `tbl_student` ON tbl_batch_students.student_id = tbl_student.id WHERE `batch_id`=:bid GROUP by tbl_student.category",
     [':bid' =>$bid]);
    $returnArray=[];
    $result = $command->queryAll();
    
        foreach ($result as $key => $value) {
           $returnArray[$value['category']]=$value['count'];
        }
   
        return $returnArray;

}
public function getStudentsGender($bid){
    $connection = Yii::$app->getDb();
    $command = $connection->createCommand("
    SELECT COUNT(DISTINCT tbl_student.id) as count,gender FROM `tbl_batch_students` INNER JOIN `tbl_student` ON tbl_batch_students.student_id = tbl_student.id WHERE `batch_id`=:bid GROUP by tbl_student.gender",
     [':bid' =>$bid]);
    $returnArray=[];
    $result = $command->queryAll();
    
        foreach ($result as $key => $value) {
           $returnArray[$value['gender']]=$value['count'];
        }
   
        return $returnArray;

}
    public function actionJson($id,$year=2021)
    {

        $temp=0;
        $data=[];
        $targetDis=[];
        $transDis=[];
        $data['scheme']=Scheme::find()->where(['id'=>$id])->asArray()->one();
       $target=Targets::find()->where(['scheme_id'=>$id,'year'=>$year])->asArray()->all();
       foreach ($target as $key => $value) {
        $response=TargetsResponse::find()->where(['target_id'=>$value['id'],'status'=>1])->asArray()->all();
        foreach ($response as $key1 => $value1) {
            $temp=0;
            $batchDis=[];
            $responseDis[$key][$key1]['About TC']=Tcdetail::find()->where(['id'=>$value1['tc_id']])->asArray()->one();
            $responseDis[$key][$key1]['About Job']=Job::find()->where(['id'=>$value1['job_id']])->asArray()->one();
            $responseDis[$key][$key1]['Sub Target Alloted']=$value1['response_number'];
            $responseDis[$key][$key1]['District']=UkDistrict::find()->where(['id'=>$value1['district_id']])->asArray()->one()['name'];
            // $responseDis[$key][$key1]['tp_id']=$value1['tp_id'];
            $batch=TargetBatch::find()->where(['sub_target_id'=>$value1['id']])->asArray()->all();
            foreach ($batch as $key2 => $value2) {
                $transDis=[];

                $today=time();

                $startDatestamp = strtotime($value2['start_date']); 
                $endDatestamp = strtotime($value2['end_date']); 
                $start_date = date('d/m/Y', $startDatestamp);
                $end_date = date('d/m/Y', $endDatestamp);
                $startTimestamp = strtotime($value2['start_time']); 
                $endTimestamp = strtotime($value2['end_time']); 
                $start_time = date('h:i:a', $startTimestamp);
                $end_time = date('h:i:a', $endTimestamp);
                if (($startDatestamp <= $today) && ($today <= $endDatestamp)) {
                    $batchDis[$key2]['status']="Running";
                }
                else if($today>$endDatestamp){
                    $batchDis[$key2]['status']="Completed";

                }else{
                    $batchDis[$key2]['status']="Upcoming";

                }
                $batchDis[$key2]['id']=$value2['id'];
                $batchDis[$key2]['sip_id']=$value2['sip_id'];
                $batchDis[$key2]['sub_target_id']=$value2['sub_target_id'];
                $batchDis[$key2]['batch_name']=$value2['batch_name'];
                
                $batchDis[$key2]['sector_name']=Job::findOne($value2['job_id'])->subSector->sector->sector_name;
                $batchDis[$key2]['sub_sector_name']=Job::findOne($value2['job_id'])->subSector->sub_sector_name;
                $batchDis[$key2]['job_name']=Job::findOne($value2['job_id'])->job_name;
                $batchDis[$key2]['date']=$start_date .' to '.$end_date;
                $batchDis[$key2]['time']=$start_time .' to '.$end_time;
                $batchDis[$key2]['trainer_name']=$value2['trainer_name'];
                $batchDis[$key2]['student_enroll']=BatchStudents::find()->where(['batch_id'=>$value2['id']])->count();
                $batchDis[$key2]['student_enroll_cast_wise']=$this->getStudentsCat($value2['id']);
                $batchDis[$key2]['student_enroll_gender_wise']=$this->getStudentsGender($value2['id']);
                $batchDis[$key2]['student_passed']=StudentResult::find()->where(['batch_id'=>$value2['id']])
                ->andWhere(['or',
                        ['result'=>1],
                        ['result1'=>1],
                        ['result2'=>1]
                ])
                ->count();
                $batchDis[$key2]['student_failed']=($batchDis[$key2]['student_passed'])?$batchDis[$key2]['student_enroll']- $batchDis[$key2]['student_passed']:"";
                $batchDis[$key2]['student_placed']=StudentPlacement::find()->where(['batch_id'=>$value2['id'],'result'=>1])
                ->count();
                $temp=$temp+BatchStudents::find()->where(['batch_id'=>$value2['id']])->count();
                $trans=TransDetail::find()->where(['batch_id'=>$value2['id']])->asArray()->all();
                foreach ($trans as $key3 => $value3) {
                    $transDis[$value3['claim_type']]['net_amount']= number_format(($value3['is_tds_deduct'])? 
                    round($value3['net_amount']-$value3['net_amount']*0.1,0)
                    :round($value3['net_amount']*0.1,0),2,'.','');
                }
                $batchDis[$key2]['trans']=$transDis;
                $batchDis[$key2]['students']=$this->getStudents($value2['id']);

            }
            $responseDis[$key][$key1]['Total Student']=array_sum(array_column($batchDis,'student_enroll'));

            $responseDis[$key][$key1]['Batch']=$batchDis;
        }
        // $targetDis[$key]['id']=$value['id'];
        $targetDis[$key]['About TP']=TpartnerDetail::find()->where(['id'=>$value['tp_id']])->asArray()->one();
        $targetDis[$key]['Target Alloted']=$value['number'];
        if($response){
       	    $targetDis[$key]['Total Student']=array_sum(array_column(@$responseDis[@$key],'Total Student'));
        	$targetDis[$key]['TC Response']=$responseDis[$key];
        }else{
            $targetDis[$key]['Total Student']=0;
            $targetDis[$key]['TC Response']="Waiting for response";
        }


       }
       $data['scheme']['Scheme Short Name']=$data['scheme']['short_name'];
       $data['scheme']['Scheme Full Name']=$data['scheme']['full_name'];
       $data['scheme']['About Scheme']=$data['scheme']['description'];
       $data['scheme']['Finance Year']=(String)$year."-".(String)(($year%100)+1);
       $data['scheme']['Targets to TPs']=array_sum(array_column($targetDis,'Target Alloted'));
       $data['scheme']['Total Student Enrolled']=array_sum(array_column($targetDis,'Total Student'));
       $data['scheme']['Remaining Students']=
       array_sum(array_column($targetDis,'Target Alloted'))-
       array_sum(array_column($targetDis,'Total Student'));
       $data['scheme']['Targets Distributed']=$targetDis;
       unset($data['scheme']['short_name']);
       unset($data['scheme']['full_name']);
       unset($data['scheme']['description']);
       unset($data['scheme']['edited_by']);
       unset($data['scheme']['created_at']);
       unset($data['scheme']['updated_at']);
      
        return $this->render('json', [
            'data' => $data,
            'year' => $year,
           
        ]);
    }
       


    public function actionJsonTp($id,$year=2021)
    {
        $temp=0;
        $data=[];
        $targetDis=[];
        $transDis=[];
        $data['tp_details']=TpartnerDetail::find()->where(['id'=>$id])->asArray()->one();
       $target=Targets::find()->where(['tp_id'=>$id])->asArray()->all();
       foreach ($target as $key => $value) {

        $response=TargetsResponse::find()->where(['target_id'=>$value['id'],'status'=>1])->asArray()->all();
        foreach ($response as $key1 => $value1) {
            $temp=0;
            $batchDis=[];
            $responseDis[$key][$key1]['Sub Target Alloted']=$value1['response_number'];
            // $responseDis[$key][$key1]['id']=$value1['id'];
            $responseDis[$key][$key1]['District']=UkDistrict::find()->where(['id'=>$value1['district_id']])->asArray()->one()['name'];
            $responseDis[$key][$key1]['About TC']=Tcdetail::find()->where(['id'=>$value1['tc_id']])->asArray()->one();
            // $responseDis[$key][$key1]['tp_id']=$value1['tp_id'];
            $batch=TargetBatch::find()->where(['sub_target_id'=>$value1['id']])->asArray()->all();
   		    $data['scheme']=Scheme::find()->where(['id'=>$value['scheme_id']])->asArray()->one();

           foreach ($batch as $key2 => $value2) {
            $today=time();

            $startDatestamp = strtotime($value2['start_date']); 
            $endDatestamp = strtotime($value2['end_date']); 
            $start_date = date('d M Y', $startDatestamp);
            $end_date = date('d M Y', $endDatestamp);
            $startTimestamp = strtotime($value2['start_time']); 
            $endTimestamp = strtotime($value2['end_time']); 
            $start_time = date('h:i:a', $startTimestamp);
            $end_time = date('h:i:a', $endTimestamp);
            if (($startDatestamp <= $today) && ($today <= $endDatestamp)) {
                $batchDis[$key2]['status']="Running";
            }
            else if($today>$endDatestamp){
                $batchDis[$key2]['status']="Completed";

            }else{
                $batchDis[$key2]['status']="Upcoming";

            }
            $batchDis[$key2]['id']=$value2['id'];
            $batchDis[$key2]['sip_id']=$value2['sip_id'];
            $batchDis[$key2]['sub_target_id']=$value2['sub_target_id'];
            $batchDis[$key2]['batch_name']=$value2['batch_name'];
            $batchDis[$key2]['sector_name']=Job::findOne($value2['job_id'])->subSector->sector->sector_name;
                $batchDis[$key2]['sub_sector_name']=Job::findOne($value2['job_id'])->subSector->sub_sector_name;
            $batchDis[$key2]['job_name']=Job::findOne($value2['job_id'])->job_name;
            $batchDis[$key2]['date']=$start_date .' to '.$end_date;
            $batchDis[$key2]['time']=$start_time .' to '.$end_time;
            $batchDis[$key2]['trainer_name']=$value2['trainer_name'];
            $batchDis[$key2]['student_enroll']=BatchStudents::find()->where(['batch_id'=>$value2['id']])->count();
            $batchDis[$key2]['student_enroll_cast_wise']=$this->getStudentsCat($value2['id']);
            $batchDis[$key2]['student_enroll_gender_wise']=$this->getStudentsGender($value2['id']);

            $temp=$temp+BatchStudents::find()->where(['batch_id'=>$value2['id']])->count();
            $trans=TransDetail::find()->where(['batch_id'=>$value2['id']])->asArray()->all();

            foreach ($trans as $key3 => $value3) {
                $transDis[$value3['claim_type']]['net_amount']= number_format(($value3['is_tds_deduct'])? 
                round($value3['net_amount']-$value3['net_amount']*0.1,0)
                :round($value3['net_amount']*0.1,0),2,'.','');
            }
            $batchDis[$key2]['trans']=$transDis;
            $batchDis[$key2]['students']=$this->getStudents($value2['id']);

        }
            $responseDis[$key][$key1]['Total Student']=array_sum(array_column($batchDis,'student_enroll'));

            $responseDis[$key][$key1]['Batch']=$batchDis;
        }
        // $targetDis[$key]['id']=$value['id'];
        $targetDis[$key]['scheme']=Scheme::find()->where(['id'=>$value['scheme_id']])->asArray()->one();"<pre>";

        $targetDis[$key]['Target Alloted']=$value['number'];
        if($response){
            $targetDis[$key]['Total Student']=array_sum(array_column(@$responseDis[@$key],'Total Student'));
            $targetDis[$key]['TC Response']=$responseDis[$key];
        }else{
            $targetDis[$key]['Total Student']=0;
            $targetDis[$key]['TC Response']="Waiting for response";
        }
        $targetDis[$key]['scheme']['target_to_tp']=array_sum(array_column($targetDis,'Target Alloted'));
        $targetDis[$key]['scheme']['student_enrolled']=array_sum(array_column($targetDis,'Total Student'));
        $targetDis[$key]['scheme']['remaining_students']=
        array_sum(array_column($targetDis,'Target Alloted'))-
        array_sum(array_column($targetDis,'Total Student'));
       }
     
	if($targetDis){
       $data['scheme']['Scheme Short Name']=$data['scheme']['short_name'];
       $data['scheme']['Scheme Full Name']=$data['scheme']['full_name'];
       $data['scheme']['About Scheme']=$data['scheme']['description'];
       $data['scheme']['Finance Year']=(String)$year."-".(String)(($year%100)+1);
       $data['scheme']['Targets to TPs']=array_sum(array_column($targetDis,'Target Alloted'));
       $data['scheme']['Total Student Enrolled']=array_sum(array_column($targetDis,'Total Student'));
       $data['scheme']['Remaining Students']=
       array_sum(array_column($targetDis,'Target Alloted'))-
       array_sum(array_column($targetDis,'Total Student'));
       $data['scheme']['Targets Distributed']=$targetDis;
       unset($data['scheme']['short_name']);
       unset($data['scheme']['full_name']);
       unset($data['scheme']['description']);
       unset($data['scheme']['edited_by']);
       unset($data['scheme']['created_at']);
       unset($data['scheme']['updated_at']);
	}
  $data['scheme']['Targets Distributed']=$targetDis;
        return $this->render('json', [
            'data' => $data,
            'year'=>$year
           
        ]);
    }
      
    

}
