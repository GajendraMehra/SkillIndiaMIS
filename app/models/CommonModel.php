<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CommonModel".
 *
 * @property int $id
 * @property int $email
 */
class CommonModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */


    /**
     * {@inheritdoc}
     */


    /**
     * {@inheritdoc}
     */
   public static function labels($id)
    {
        if ($id) {
            # code...
            return  "Yes";
        }
        else{
            return "No";
        }
    }
    public static function labelsGender($id)
    {
        if ($id==1) {
            # code...
            return  "Male";
        }
        else if ($id==0){
            return "Female";
        } else{
            return "Other";
        }
    }
   public static function labelsYesNo($id)
    {
        if ($id==1) {
            # code...
            return  "true";
        }
      return "false";
    }

   public static function labelsStatus($id)
    {
        if ($id) {
            # code...
            return '<span class="badge badge-success"> Active </span>';

        }
        else{
            return '<span class="badge badge-danger">Not active</span>';
            // return "No";
        }
    }  public static function UserStatus($id)
    {
        if ($id==10) {
            # code...
            return '<span class="badge badge-success"> Active </span>';

        }
        elseif ($id==9) {
            # code...
            return '<span class="badge badge-warning"> Waiting for Email Verification </span>';

        }
        else{
            return '<span class="badge badge-danger">Deactive</span>';
            // return "No";
        }
    }  
    
   public static function labelsBatchStatus($id)
    {
        if ($id) {
            # code...
            return '<span class="badge badge-success"> Submitted </span>';

        }
        else{
            return '<span class="badge badge-danger">Not Submitted</span>';
            // return "No";
        }
    }    
    
   public static function labelsResultStatus($id)
    {
        if ($id==1) {
            # code...
            return '<span class="badge badge-success"> Pass </span>';

        }
        else if ($id==2) {
            return '<span class="badge badge-danger">Fail</span>';
            // return "No";
        }else{
            return '<span class="badge badge-warning">Absent</span>';

        }
    }public static function labelsPlacementStatus($id)
    {
        if ($id==1) {
            # code...
            return '<span class="badge badge-success"> Placed </span>';

        }
        else if ($id==0) {
            return '<span class="badge badge-danger">Not Placed</span>';
            // return "No";
        }
    }
   public static function labelsApprovedstatus($id)
    {
        if ($id==1) {
            # code...
            return '<span class="badge badge-success"> Approved </span>';

        }else if($id==2){
            return '<span class="badge badge-danger"> Declined </span>';

        }
        else{
            return '<span class="badge badge-warning">Action Required</span>';
            // return "No";
        }
    }

  
    public static function labelsTargetApprovedstatus($id)
    {
        if ($id==1) {
            # code...
            return '<span class="badge badge-success"> Approved By Admin </span>';

        }else if($id==2){
            return '<span class="badge badge-danger"> Declined By Admin </span>';

        }
        else{
            return '<span class="badge badge-warning">Waiting for admin response</span>';
            // return "No";
        }
    }
   public static function ceneterTypelabels($id)
    {
        $type=['Mobile','Permanent'];
        return $type[$id];
    }
   public static function getCeneterTypelabels()
    {
        $type=['Mobile','Permanent'];
        return $type;
    } 
    
   public static function getTransStage()
    {
        $type=['','First','Second','Third',"Reassesment 1","Reassesment 2"];
        array_shift($type);
        return $type;
    }  
    
   public static function getTransStatus($id="")
    {

        switch ($id) {
            case 0:
                         return '<span class="badge badge-warning"> Waiting for Admin Response </span>';

                break;
              case 1:
                        return '<span class="badge badge-info"> Waiting for Finanace Department </span>';

                break;
              case 2:
                         return '<span class="badge badge-danger"> Declined By Admin </span>';

                break;  
                 case 3:
                         return '<span class="badge badge-success"> Bill of Supply Generated </span>';

                break;  
                case 4:
                         return '<span class="badge badge-danger"> Declined By Accountant </span>';

                break;
            
            default:
                # code...
                break;
        }
       
    }
   public static function transStatus($id="")
    {
        if (Yii::$app->user->identity->role==4) {
            $data=[
                1=>'Waiting for Action',
                3=>'Bill of Supply Generated',
                4=>'Declined'
            ];
            return $data;
        }else{

            return ['Waiting for Admin Response ','Waiting for Finanace Department','Declined By Admin','Bill of Supply Generated','Declined By Accountant'];
        }
   
    }
   public static function getTpdetailbyuserid()
    {
        $tp=TpartnerDetail::find()->where(['edited_by' => Yii::$app->user->identity->id])->one();


        return $tp;

        // return $tp['is_approved']=0;
    }
     public static function getTcdetailbyuserid()
    {
        $tc=Tcdetail::find()->where(['email' => Yii::$app->user->identity->email])->one();
 

        return $tc;

        // return $tp['is_approved']=0;
    } 
    public static function getTcAlljobs()
    {
        $connection = Yii::$app->getDb();

        $tc=Tcdetail::find()->where(['email' => Yii::$app->user->identity->email])->one();
        if (!$tc) {
           $command = $connection->createCommand("SELECT tbl_jobs.id,tbl_jobs.job_name FROM tbl_targets_response inner join tbl_jobs on tbl_jobs.id=tbl_targets_response.job_id where tbl_targets_response.status=1");
           # code...
        }else{
           $command = $connection->createCommand("SELECT tbl_jobs.id,tbl_jobs.job_name FROM tbl_targets_response inner join tbl_jobs on tbl_jobs.id=tbl_targets_response.job_id where tbl_targets_response.status=1 and tbl_targets_response.tc_id=:tc_id")
           ->bindValues([':tc_id' => $tc['id']]);
           

        }
            $result = $command->queryAll();
        
        return $result;

       
    }   public static function getTcjobs($id="",$tcid="")
    {
        
        if (Yii::$app->user->isGuest||Yii::$app->user->identity->role==1) {
            $tc['id']=$tcid;
         }else{
 
             $tc=Tcdetail::find()->where(['email' => Yii::$app->user->identity->email])->one();
         }
           $connection = Yii::$app->getDb();
           $command = $connection->createCommand("SELECT tbl_jobs.id,tbl_jobs.job_name FROM `tbl_targets_response` inner join tbl_jobs on tbl_jobs.id=tbl_targets_response.job_id 
           inner join tbl_sub_sectors on tbl_sub_sectors.nsdc_sub_sector_id=tbl_jobs.sub_sector_id
           inner join tbl_sectors on tbl_sub_sectors.sector_id=tbl_sectors.nsdc_sector_id
           where tbl_targets_response.status=1 and tbl_sectors.id= :id and tbl_targets_response.tc_id=:tc_id")
            ->bindValues([':tc_id' => $tc['id']])
            ->bindValues([':id' => $id]);
           
            $result = $command->queryAll();
        
        return $result;

       
    } public static function getTcsectors($tcid="",$did="")
    {

        if (Yii::$app->user->isGuest||Yii::$app->user->identity->role==1) {
           $tc['id']=$tcid;
        }else{

            $tc=Tcdetail::find()->where(['email' => Yii::$app->user->identity->email])->one();
        }
           $connection = Yii::$app->getDb();
           $command = $connection->createCommand("SELECT tbl_sectors.id,tbl_sectors.sector_name FROM `tbl_targets_response` inner join tbl_jobs on tbl_jobs.id=tbl_targets_response.job_id 
           inner join tbl_sub_sectors on tbl_sub_sectors.nsdc_sub_sector_id=tbl_jobs.sub_sector_id
           inner join tbl_sectors on tbl_sectors.nsdc_sector_id=tbl_sub_sectors.sector_id
           where tbl_targets_response.status=1 and tbl_targets_response.tc_id=:tc_id and tbl_targets_response.district_id=:did" )
            ->bindValues([':tc_id' => $tc['id']])
            ->bindValues([':did' => $did]);
          
            $result = $command->queryAll();

        return $result;

        // return $tp['is_approved']=0;
    }

   public static function getStudentData($tcid ="")
    {
        $tp=UkDistrict::find()->asArray()->all();
        $condition="";
        if ($tcid) {
          $condition=" where tbl_student.selected_tc=:tc_id";
        }
        $sql = "SELECT  count(districts.id) as student  ,districts.id FROM `districts` left join tbl_blocks on tbl_blocks.district_id=districts.id inner join tbl_student on tbl_student.block_id=tbl_blocks.id ".$condition." GROUP by districts.id";

        $data1=Yii::$app->db->createCommand($sql);
        if ($tcid) {
        $data1->bindValues([':tc_id' => $tcid]);
        }
        
          $data1=$data1->queryAll();
          $data2=[];
        foreach ($data1 as $key => $value) {
           $data2[$value['id']]=$value['student'];
        }
        foreach ($tp as $key => $value) {
            $ntp[$value['id']]['name']=$value['name'];
            $ntp[$value['id']]['students']= isset($data2[$value['id']]) ? $data2[$value['id']] : 0 ;

        }
        // print_r($ntp);
        return $ntp;

        // return $tp['is_approved']=0;
    }

    


}
