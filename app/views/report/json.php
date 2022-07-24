<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\CommonModel;
use app\models\IbmResponse;
use app\models\TcenterAddress;
use app\models\TcenterSpocoperation;
use app\models\BatchTrainingType;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function downloadReport1($data,$year){

  $spreadsheet = new Spreadsheet();

  $writer = new Xlsx($spreadsheet);
  $arrayData = [
    $data['scheme']
  ];
  $tpdis=[];
  
  $headerData=[
  ["Scheme Short Name",$arrayData[0]['Scheme Short Name']],
  ["Scheme Full Name",$arrayData[0]['Scheme Full Name']],
  ["About Scheme",$arrayData[0]['About Scheme']],
  ["Finance Year",$arrayData[0]['Finance Year']],
  ["Targets to TPs",$arrayData[0]['Targets to TPs']],
  ["Total Student Enrolled",$arrayData[0]['Total Student Enrolled']],
  ["Remaining Students",$arrayData[0]['Remaining Students']],
  ['Report Generated on',date('d M Y',time()).' at '.date('h:i:a',time())]

  
  ];
  foreach ($data['scheme']['Targets Distributed'] as $key => $value) {
    
  foreach ($value as $key1 => $value1) {
    if ($key1=="About TP") {
      $tpdis[$key]['tp_name'] = $value1['tp_name'];
      $tpdis[$key]['tp_sdms_id'] = $value1['tp_sdms_id'];
    }elseif (is_array($value1)) {
  
    }else{
  
      $tpdis[$key][$key1] = $value1;
    }
  }
   
    # code...
  } 
  
  $spreadsheet->getActiveSheet()->fromArray( $headerData,NULL,'A1' ); 
  $spreadsheet->getActiveSheet()->fromArray( [ ["TP Name","SDMS ID","Target Distributed","Student Enrolled"]],NULL,'A10' ); 
  $spreadsheet->getActiveSheet()->fromArray($tpdis,NULL,'A12' );   
        $styleArray = [
          'font' => [
              'bold' => true,
              'align'=>'left'
          ],
      ];    // Top left coordinate of the worksheet range where
        $spreadsheet->getActiveSheet()->getStyle('A1:A9')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A10:G10')->applyFromArray($styleArray);
  
        foreach (range('A', $spreadsheet->getActiveSheet()->getHighestDataColumn()) as $col) {
          $spreadsheet->getActiveSheet()
                  ->getColumnDimension($col)
                  ->setAutoSize(true);
      } 
      $filePath="downloads/".urlencode($arrayData[0]['Scheme Short Name']."_".$year."_TP_Level").".xlsx";
     $writer->save($filePath);
     return $filePath;

}

function downloadReport2($data,$year){

  $spreadsheet = new Spreadsheet();

  $writer = new Xlsx($spreadsheet);
  $arrayData = [
    $data['scheme']
  ];
  $tpdis=[];
  $tcdis=[];
  $tcBatchDis=[];
  $tpCounter=1;
  $styleArray = [
    'font' => [
        'bold' => true,
        'align'=>'left'
    ],
  ];
  $styleArray = [
    'font' => [
        'bold' => true,
        'align'=>'left'
    ],
  ];
  $marArray = array(
    'borders' => array(
        'outline' => array(
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('argb' => '00000000'),
        ),
    ),
    'fill' => array(
      'fillType' =>\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => array('argb' => '808080')
    )
  );
  $headerData=[
  ["Scheme Short Name",$arrayData[0]['Scheme Short Name']],
  ["Scheme Full Name",$arrayData[0]['Scheme Full Name']],
  ["About Scheme",$arrayData[0]['About Scheme']],
  ["Finance Year",$arrayData[0]['Finance Year']],
  ["Targets to TPs",$arrayData[0]['Targets to TPs']],
  ["Total Student   Enrolled",$arrayData[0]['Total Student Enrolled']],
  ["Remaining Students",$arrayData[0]['Remaining Students']],
  ['Report Generated on',date('d M Y',time()).' at '.date('h:i:a',time())]

  
  ];
  foreach ($data['scheme']['Targets Distributed'] as $key => $value) {
    $tpdis[$key]['key'] = $tpCounter++;
  foreach ($value as $key1 => $value1) {
   
    if ($key1=="About TP") {
 
      $tpdis[$key]['tp_name'] = $value1['tp_name'];
      $tpdis[$key]['tp_sdms_id'] = $value1['tp_sdms_id'];
    }elseif (is_array($value1)) {
      if ($key1=="TC Response") {
       foreach ($value1 as $key2 => $value2) {
        $spoc=TcenterSpocoperation::findOne($value2['About TC']['id']);
        $tadd=TcenterAddress::findOne($value2['About TC']['id']);
      $tcdis[$key][$key2]['tc_name']=$value2['About TC']['name'];
      $tcdis[$key][$key2]['address']=$tadd->address_line;
      $tcdis[$key][$key2]['spoc_name']=$spoc->name;
      $tcdis[$key][$key2]['contact']=$spoc->mobile_no;
      $tcdis[$key][$key2]['tc_id']=$value2['About TC']['smart_tcid'];
      $tcdis[$key][$key2]['email']=$value2['About TC']['email'];
      $tcdis[$key][$key2]['District']=$value2['District'];
      $tcdis[$key][$key2]['sub_target']=$value2['Sub Target Alloted'];
      $tcdis[$key][$key2]['Total Student']=$value2['Total Student'];
        if (sizeof($value2['Batch'])==0) {
          $tcBatchDis[$key][$key2]=[];
        }else{
      foreach ($value2['Batch'] as $key3 => $value3) {
        $tcBatchDis[$key][$key2][$key3]['batch_name']=$value3['batch_name'];
        $tcBatchDis[$key][$key2][$key3]['sip_id']=$value3['sip_id'];
        $tcBatchDis[$key][$key2][$key3]['sector_name']= $value3['sector_name'];
        $tcBatchDis[$key][$key2][$key3]['sub_sector_name']= $value3['sub_sector_name'];
        $tcBatchDis[$key][$key2][$key3]['job_name']= $value3['job_name'];
        $tcBatchDis[$key][$key2][$key3]['trainer_name']=$value3['trainer_name'];
        $tcBatchDis[$key][$key2][$key3]['date']=$value3['date'];
        $tcBatchDis[$key][$key2][$key3]['time']=$value3['time'];
        $tcBatchDis[$key][$key2][$key3]['student_enroll']=$value3['student_enroll'];
        $tcBatchDis[$key][$key2][$key3]['student_enroll_female']=@$value3['student_enroll_gender_wise'][0];
        $tcBatchDis[$key][$key2][$key3]['student_enroll_male']=@$value3['student_enroll_gender_wise'][1];
        $tcBatchDis[$key][$key2][$key3]['General']=@$value3['student_enroll_cast_wise'][1];
        $tcBatchDis[$key][$key2][$key3]['obc']=@$value3['student_enroll_cast_wise'][2];
        $tcBatchDis[$key][$key2][$key3]['st']=@$value3['student_enroll_cast_wise'][3];
        $tcBatchDis[$key][$key2][$key3]['sc']=@$value3['student_enroll_cast_wise'][4];
        $tcBatchDis[$key][$key2][$key3]['status']=$value3['status'];
        $tcBatchDis[$key][$key2][$key3]['student_passed']=@$value3['student_passed'];
        $tcBatchDis[$key][$key2][$key3]['student_failed']=@$value3['student_failed'];
        $tcBatchDis[$key][$key2][$key3]['student_placed']=@$value3['student_placed'];
        $tcBatchDis[$key][$key2][$key3]['claim1']=(isset($value3['trans'][0])&&$value3['trans'][0]['net_amount']!=0)?$value3['trans'][0]['net_amount']:' - ';
        $tcBatchDis[$key][$key2][$key3]['claim2']=(isset($value3['trans'][1])&&$value3['trans'][1]['net_amount']!=0)?$value3['trans'][1]['net_amount']:' - ';
        $tcBatchDis[$key][$key2][$key3]['claim3']=(isset($value3['trans'][2])&&$value3['trans'][2]['net_amount']!=0)?$value3['trans'][2]['net_amount']:' - ';

       }
      }
       }
      }


    }else{
  
      $tpdis[$key][$key1] = $value1;
    }
  }
   
    # code...
  } 

  
  $spreadsheet->getActiveSheet()->fromArray( $headerData,NULL,'A1' ); 

 
  $flag=10;

  foreach ($tpdis as $key => $value) {
    $spreadsheet->getActiveSheet()->fromArray([["Training Partner Details"]],NULL,'A'.$flag++ )->getStyle('A'.($flag-1))->applyFromArray($styleArray);  
    $spreadsheet->getActiveSheet()->fromArray( [ ["TP Name","SDMS ID","Target Distributed","Student Enrolled"]],NULL,'B'.$flag++ )->getStyle('B'.($flag-1).':H'.($flag-1))->applyFromArray($styleArray);; 
    $spreadsheet->getActiveSheet()->fromArray([$value],NULL,'A'.$flag++ );   
    $spreadsheet->getActiveSheet()->fromArray([["Training Center Details"]],NULL,'A'.$flag++ )->getStyle('A'.($flag-1))->applyFromArray($styleArray);   
    
    $spreadsheet->getActiveSheet()->getStyle('A'.($flag-1))->applyFromArray($styleArray);
  if(isset($tcdis[$key]))
    foreach ($tcdis[$key] as $key1 => $value2) {
      $spreadsheet->getActiveSheet()->fromArray( [ ["TC Name","Address","SPOC Name","Contact","Smart TC ID","Center Email","District","Target Distributed","Student Enrolled"]],NULL,'B'.$flag++ )->getStyle('B'.($flag-1).':H'.($flag-1))->applyFromArray($styleArray);;
      $spreadsheet->getActiveSheet()->fromArray($value2,NULL,'B'.$flag++ );   
    $spreadsheet->getActiveSheet()->fromArray([["Batch Details"]],NULL,'A'.$flag++ )->getStyle('A'.($flag-1))->applyFromArray($styleArray);  
    $spreadsheet->getActiveSheet()->fromArray( [ ["Batch Name","Batch SIP ID","Sector Name","Sub Sector Name","Job Name","Trainer Name","Date","Time","Student Enrolled","Female","Male","General","O.B.C","S.T","S.C","Status","Student Passed","Student Failed / Not Appeared","Student Placed","First Trans Amount","Second Trans Amount","Third Trans Amount"]],NULL,'B'.$flag++ )->getStyle('B'.($flag-1).':P'.($flag-1))->applyFromArray($styleArray);;

       $spreadsheet->getActiveSheet()->fromArray($tcBatchDis[$key][$key1],NULL,'B'.$flag++ );   
       # code...
       $flag=$flag+sizeof($tcBatchDis[$key][$key1]);
     }
     $spreadsheet->getActiveSheet()->fromArray([['']],NULL,'A'.$flag++)->getStyle('A'.(($flag-1)).':K'.(($flag-1)))->applyFromArray($marArray);

  }
  // $spreadsheet->getActiveSheet()->fromArray($tpdis,NULL,'A12' );   
        // Top left coordinate of the worksheet range where
        $spreadsheet->getActiveSheet()->getStyle('A1:A9')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A10:G10')->applyFromArray($styleArray);
  
        foreach (range('A', $spreadsheet->getActiveSheet()->getHighestDataColumn()) as $col) {
          $spreadsheet->getActiveSheet()
                  ->getColumnDimension($col)
                  ->setAutoSize(true);
      } 
      $filePath="downloads/".urlencode($arrayData[0]['Scheme Short Name']."_".$year."Batch_Level").".xlsx";
     $writer->save($filePath);
     return $filePath;

}


function downloadReport2_1($data,$year){

  $spreadsheet = new Spreadsheet();

  $writer = new Xlsx($spreadsheet);
  $arrayData = [
    $data['scheme']
  ];
  $tpdis=[];
  $tcdis=[];
  $tcBatchDis=[];
  $tpCounter=1;
  $styleArray = [
    'font' => [
        'bold' => true,
        'align'=>'left'
    ],
  ];
  $styleArray = [
    'font' => [
        'bold' => true,
        'align'=>'left'
    ],
  ];
  $marArray = array(
    'borders' => array(
        'outline' => array(
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('argb' => '00000000'),
        ),
    ),
    'fill' => array(
      'fillType' =>\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => array('argb' => '808080')
    )
  );
  $headerData=[
  ["Scheme Short Name",$arrayData[0]['Scheme Short Name']],
  ["Scheme Full Name",$arrayData[0]['Scheme Full Name']],
  ["About Scheme",$arrayData[0]['About Scheme']],
  ["Finance Year",$arrayData[0]['Finance Year']],
  ["Targets to TPs",$arrayData[0]['Targets to TPs']],
  ["Total Student   Enrolled",$arrayData[0]['Total Student Enrolled']],
  ["Remaining Students",$arrayData[0]['Remaining Students']],
  ['Report Generated on',date('d M Y',time()).' at '.date('h:i:a',time())]
  ];
  foreach ($data['scheme']['Targets Distributed'] as $key => $value) {
    $tpdis[$key]['key'] = $tpCounter++;
  foreach ($value as $key1 => $value1) {
    if ($key1=="About TP") {
      $tpdis[$key]['tp_name'] = $value1['tp_name'];
      $tpdis[$key]['tp_sdms_id'] = $value1['tp_sdms_id'];
    }elseif (is_array($value1)) {
      if ($key1=="TC Response") {
       foreach ($value1 as $key2 => $value2) {
        $spoc=TcenterSpocoperation::findOne($value2['About TC']['id']);
        $tadd=TcenterAddress::findOne($value2['About TC']['id']);
      $tcdis[$key][$key2]['tc_name']=$value2['About TC']['name'];
      $tcdis[$key][$key2]['address']=$tadd->address_line;
      $tcdis[$key][$key2]['spoc_name']=$spoc->name;
      $tcdis[$key][$key2]['contact']=$spoc->mobile_no;
      $tcdis[$key][$key2]['tc_id']=$value2['About TC']['smart_tcid'];
      $tcdis[$key][$key2]['email']=$value2['About TC']['email'];
      $tcdis[$key][$key2]['District']=$value2['District'];
      $tcdis[$key][$key2]['sub_target']=$value2['Sub Target Alloted'];
      $tcdis[$key][$key2]['Total Student']=$value2['Total Student'];
        if (sizeof($value2['Batch'])==0) {
          $tcBatchDis[$key][$key2]=[];
        }else{
      foreach ($value2['Batch'] as $key3 => $value3) {
        $tcBatchDis[$key][$key2][$key3]['finanace_year']=$arrayData[0]['Finance Year'];
        $tcBatchDis[$key][$key2][$key3]['scheme_name']=$arrayData[0]['Scheme Short Name'];
        $tcBatchDis[$key][$key2][$key3]['scheme_full_name']=$arrayData[0]['Scheme Full Name'];
        $tcBatchDis[$key][$key2][$key3]['tp_name']=$tpdis[$key]['tp_name'];
        $tcBatchDis[$key][$key2][$key3]['tp_sdms_id']=$tpdis[$key]['tp_sdms_id'];
        $tcBatchDis[$key][$key2][$key3]['tc_name']=$tcdis[$key][$key2]['tc_name'];
        $tcBatchDis[$key][$key2][$key3]['address']=$tadd->address_line;
        $tcBatchDis[$key][$key2][$key3]['spoc_name']=$spoc->name;
        $tcBatchDis[$key][$key2][$key3]['contact']=$spoc->mobile_no;
        $tcBatchDis[$key][$key2][$key3]['tc_id']=$value2['About TC']['smart_tcid'];
        $tcBatchDis[$key][$key2][$key3]['email']=$value2['About TC']['email'];
        $tcBatchDis[$key][$key2][$key3]['District']=$value2['District'];
        $tcBatchDis[$key][$key2][$key3]['sub_target']=$value2['Sub Target Alloted'];
        $tcBatchDis[$key][$key2][$key3]['batch_name']=$value3['batch_name'];
        $tcBatchDis[$key][$key2][$key3]['sip_id']=$value3['sip_id'];
        $tcBatchDis[$key][$key2][$key3]['sector_name']= $value3['sector_name'];
        $tcBatchDis[$key][$key2][$key3]['sub_sector_name']= $value3['sub_sector_name'];
        $tcBatchDis[$key][$key2][$key3]['job_name']= $value3['job_name'];
        $tcBatchDis[$key][$key2][$key3]['trainer_name']=$value3['trainer_name'];
        $tcBatchDis[$key][$key2][$key3]['start_date']=explode("to",$value3['date'])[0];
        $tcBatchDis[$key][$key2][$key3]['end_date']=@explode("to",$value3['date'])[1];
        $tcBatchDis[$key][$key2][$key3]['time']=$value3['time'];
        $tcBatchDis[$key][$key2][$key3]['student_enroll']=$value3['student_enroll'];
        $tcBatchDis[$key][$key2][$key3]['student_enroll_female']=@$value3['student_enroll_gender_wise'][0];
        $tcBatchDis[$key][$key2][$key3]['student_enroll_male']=@$value3['student_enroll_gender_wise'][1];
        $tcBatchDis[$key][$key2][$key3]['General']=@$value3['student_enroll_cast_wise'][1];
        $tcBatchDis[$key][$key2][$key3]['obc']=@$value3['student_enroll_cast_wise'][2];
        $tcBatchDis[$key][$key2][$key3]['st']=@$value3['student_enroll_cast_wise'][3];
        $tcBatchDis[$key][$key2][$key3]['sc']=@$value3['student_enroll_cast_wise'][4];
        $tcBatchDis[$key][$key2][$key3]['status']=$value3['status'];
        $tcBatchDis[$key][$key2][$key3]['student_passed']=@$value3['student_passed'];
        $tcBatchDis[$key][$key2][$key3]['student_failed']=@$value3['student_failed'];
        $tcBatchDis[$key][$key2][$key3]['student_placed']=@$value3['student_placed'];
        $tcBatchDis[$key][$key2][$key3]['claim1']=(isset($value3['trans'][0])&&$value3['trans'][0]['net_amount']!=0)?$value3['trans'][0]['net_amount']:' - ';
        $tcBatchDis[$key][$key2][$key3]['claim2']=(isset($value3['trans'][1])&&$value3['trans'][1]['net_amount']!=0)?$value3['trans'][1]['net_amount']:' - ';
        $tcBatchDis[$key][$key2][$key3]['claim3']=(isset($value3['trans'][2])&&$value3['trans'][2]['net_amount']!=0)?$value3['trans'][2]['net_amount']:' - ';

       }
      }
       }
      }


    }else{
  
      $tpdis[$key][$key1] = $value1;
    }
  }
   
    # code...
  } 
  // $spreadsheet->getActiveSheet()->fromArray( $headerData,NULL,'A1' ); 
  $flag=1;
  $spreadsheet->getActiveSheet()->fromArray( [ [
    "Finance Year",
    "Scheme Short Name",
    "Scheme Full Name",
    "TP Name",
    "SDMS ID",
    "TC Name",
    "Address",
    "SPOC Name",
    "Contact","Smart TC ID","Center Email","District","Target Distributed",
    "Batch Name",
    "Batch SIP ID",
    "Sector Name","Sub Sector Name","Job Name",
    "Trainer Name",
    "Start Date",
    "End Date",
    "Time",
    "Student Enrolled","Female","Male",
    "General","O.B.C","S.T","S.C","Status","Student Passed","Student Failed / Not Appeared","Student Placed","First Trans Amount","Second Trans Amount","Third Trans Amount"]],NULL,'B'.$flag++ )->getStyle('B'.($flag-1).':P'.($flag-1))->applyFromArray($styleArray);;
  foreach ($tpdis as $key => $value) {
    // $spreadsheet->getActiveSheet()->fromArray([["Training Partner Details"]],NULL,'A'.$flag++ )->getStyle('A'.($flag-1))->applyFromArray($styleArray);  
    // $spreadsheet->getActiveSheet()->fromArray( [ ["TP Name","SDMS ID","Target Distributed","Student Enrolled"]],NULL,'B'.$flag++ )->getStyle('B'.($flag-1).':H'.($flag-1))->applyFromArray($styleArray);; 
    // $spreadsheet->getActiveSheet()->fromArray([$value],NULL,'A'.$flag++ );   
    // $spreadsheet->getActiveSheet()->fromArray([["Training Center Details"]],NULL,'A'.$flag++ )->getStyle('A'.($flag-1))->applyFromArray($styleArray);   
    
    $spreadsheet->getActiveSheet()->getStyle('A'.($flag-1))->applyFromArray($styleArray);
  if(isset($tcdis[$key]))
    foreach ($tcdis[$key] as $key1 => $value2) {
      // $spreadsheet->getActiveSheet()->fromArray( [ ["TC Name","Address","SPOC Name","Contact","Smart TC ID","Center Email","District","Target Distributed","Student Enrolled"]],NULL,'B'.$flag++ )->getStyle('B'.($flag-1).':H'.($flag-1))->applyFromArray($styleArray);;
      // $spreadsheet->getActiveSheet()->fromArray($value2,NULL,'B'.$flag++ );   
    // $spreadsheet->getActiveSheet()->fromArray([["Batch Details"]],NULL,'A'.$flag++ )->getStyle('A'.($flag-1))->applyFromArray($styleArray);  
    

       $spreadsheet->getActiveSheet()->fromArray($tcBatchDis[$key][$key1],NULL,'B'.$flag++ );   
       # code...
       $flag=$flag+sizeof($tcBatchDis[$key][$key1])-1;
     }

  }
  // $spreadsheet->getActiveSheet()->fromArray($tpdis,NULL,'A12' );   
        // Top left coordinate of the worksheet range where
        // $spreadsheet->getActiveSheet()->getStyle('A1:A30')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A1:AM1')->applyFromArray($styleArray);

        foreach (range('A',"Z") as $col) {
          $spreadsheet->getActiveSheet()
                  ->getColumnDimension($col)
                  ->setAutoSize(true);
      } 
      $filePath="downloads/".urlencode($arrayData[0]['Scheme Short Name']."_".$year."Batch_Level_Table").".xlsx";
     $writer->save($filePath);
     return $filePath;

}


function downloadReport3($data,$year){

  $spreadsheet = new Spreadsheet();

  $writer = new Xlsx($spreadsheet);
  $arrayData = [
    $data['scheme']
  ];
  $tpdis=[];
  $tcdis=[];
  $tcBatchDis=[];
  $tcBatchStudent=[];
  $tpCounter=1;
  $styleArray = [
    'font' => [
        'bold' => true,
        'align'=>'left'
    ],
  ];
  $styleArray = [
    'font' => [
        'bold' => true,
        'align'=>'left'
    ],
  ];
  $marArray = array(
    'borders' => array(
        'outline' => array(
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('argb' => '00000000'),
        ),
    ),
    'fill' => array(
      'fillType' =>\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => array('argb' => '808080')
    )
  );
  date_default_timezone_set('Asia/Kolkata');
  $headerData=[
  ["Scheme Short Name",$arrayData[0]['Scheme Short Name']],
  ["Scheme Full Name",$arrayData[0]['Scheme Full Name']],
  ["About Scheme",$arrayData[0]['About Scheme']],
  ["Finance Year",$arrayData[0]['Finance Year']],
  ["Targets to TPs",$arrayData[0]['Targets to TPs']],
  ["Total Student Enrolled",$arrayData[0]['Total Student Enrolled']],
  ["Remaining Students",$arrayData[0]['Remaining Students']],
  ['Report Generated on',date('d M Y',time()).' at '.date('h:i:a',time())]

  
  ];
  foreach ($data['scheme']['Targets Distributed'] as $key => $value) {
    $tpdis[$key]['key'] = $tpCounter++;
  foreach ($value as $key1 => $value1) {
   
    if ($key1=="About TP") {
    
      $tpdis[$key]['tp_name'] = $value1['tp_name'];
      $tpdis[$key]['tp_sdms_id'] = $value1['tp_sdms_id'];
    }elseif (is_array($value1)) {

      if ($key1=="TC Response") {
       foreach ($value1 as $key2 => $value2) {
        $spoc=TcenterSpocoperation::findOne($value2['About TC']['id']);
        $tadd=TcenterAddress::findOne($value2['About TC']['id']);
      $tcdis[$key][$key2]['tc_name']=$value2['About TC']['name'];
      $tcdis[$key][$key2]['address']=$tadd->address_line;
      $tcdis[$key][$key2]['spoc_name']=$spoc->name;
      $tcdis[$key][$key2]['contact']=$spoc->mobile_no;
      $tcdis[$key][$key2]['tc_id']=$value2['About TC']['smart_tcid'];
      $tcdis[$key][$key2]['email']=$value2['About TC']['email'];
      $tcdis[$key][$key2]['District']=$value2['District'];
      $tcdis[$key][$key2]['sub_target']=$value2['Sub Target Alloted'];
      $tcdis[$key][$key2]['Total Student']=$value2['Total Student'];
        if (sizeof($value2['Batch'])==0) {
          $tcBatchDis[$key][$key2]=[];
        }else{
      foreach ($value2['Batch'] as $key3 => $value3) {
        $tcBatchDis[$key][$key2][$key3]['batch_name']=$value3['batch_name'];
        $tcBatchDis[$key][$key2][$key3]['sip_id']=$value3['sip_id'];
        $tcBatchDis[$key][$key2][$key3]['sector_name']= $value3['sector_name'];
        $tcBatchDis[$key][$key2][$key3]['sub_sector_name']= $value3['sub_sector_name'];
        $tcBatchDis[$key][$key2][$key3]['job_name']= $value3['job_name'];
        $tcBatchDis[$key][$key2][$key3]['trainer_name']=$value3['trainer_name'];
        $tcBatchDis[$key][$key2][$key3]['date']=$value3['date'];
        $tcBatchDis[$key][$key2][$key3]['time']=$value3['time'];
        $tcBatchDis[$key][$key2][$key3]['student_enroll']=$value3['student_enroll'];
        $tcBatchDis[$key][$key2][$key3]['student_enroll_female']=@$value3['student_enroll_gender_wise'][0];
        $tcBatchDis[$key][$key2][$key3]['student_enroll_male']=@$value3['student_enroll_gender_wise'][1];
        $tcBatchDis[$key][$key2][$key3]['General']=@$value3['student_enroll_cast_wise'][1];
        $tcBatchDis[$key][$key2][$key3]['obc']=@$value3['student_enroll_cast_wise'][2];
        $tcBatchDis[$key][$key2][$key3]['st']=@$value3['student_enroll_cast_wise'][3];
        $tcBatchDis[$key][$key2][$key3]['sc']=@$value3['student_enroll_cast_wise'][4];
        $tcBatchDis[$key][$key2][$key3]['status']=$value3['status'];
        $tcBatchDis[$key][$key2][$key3]['student_passed']=@$value3['student_passed'];
        $tcBatchDis[$key][$key2][$key3]['student_failed']=@$value3['student_failed'];
        $tcBatchDis[$key][$key2][$key3]['student_placed']=@$value3['student_placed'];

        $tcBatchDis[$key][$key2][$key3]['claim1']=(isset($value3['trans'][0])&&$value3['trans'][0]['net_amount']!=0)?$value3['trans'][0]['net_amount']:' - ';
        $tcBatchDis[$key][$key2][$key3]['claim2']=(isset($value3['trans'][1])&&$value3['trans'][1]['net_amount']!=0)?$value3['trans'][1]['net_amount']:' - ';
        $tcBatchDis[$key][$key2][$key3]['claim3']=(isset($value3['trans'][2])&&$value3['trans'][2]['net_amount']!=0)?$value3['trans'][2]['net_amount']:' - ';
      
        $tcBatchStudent[$key][$key2][$key3]=$value3['students'];

       }
      }
       }
      }


    }else{
  
      $tpdis[$key][$key1] = $value1;
    }
  }
   
    # code...
  } 

  
  $spreadsheet->getActiveSheet()->fromArray( $headerData,NULL,'A1' ); 

 
  $flag=10;

  foreach ($tpdis as $key => $value) {
    $spreadsheet->getActiveSheet()->fromArray([["Training Partner Details"]],NULL,'A'.$flag++ )->getStyle('A'.($flag-1))->applyFromArray($styleArray);  
    $spreadsheet->getActiveSheet()->fromArray( [ ["TP Name","SDMS ID","Target Distributed","Student Enrolled"]],NULL,'B'.$flag++ )->getStyle('B'.(($flag-1)).':H'.(($flag-1)))->applyFromArray($styleArray);; 
    $spreadsheet->getActiveSheet()->fromArray([$value],NULL,'A'.$flag++ );   
  if(isset($tcdis[$key]))
    foreach ($tcdis[$key] as $key1 => $value1) {
      $spreadsheet->getActiveSheet()->fromArray([["Training Center Details"]],NULL,'A'.$flag++ )->getStyle('A'.($flag-1))->applyFromArray($styleArray);   
    
      $spreadsheet->getActiveSheet()->getStyle('A'.($flag-1))->applyFromArray($styleArray);
      $spreadsheet->getActiveSheet()->fromArray( [ ["TC Name","Address","SPOC Name","Contact","Smart TC ID","Center Email","District","Target Distributed","Student Enrolled"]],NULL,'B'.$flag++ )->getStyle('B'.(($flag-1)).':H'.(($flag-1)))->applyFromArray($styleArray);;
      $spreadsheet->getActiveSheet()->fromArray($value1,NULL,'B'.$flag++ );   
      foreach ($tcBatchDis[$key][$key1] as $key2 => $value2) {
        $spreadsheet->getActiveSheet()->fromArray([["Batch Details"]],NULL,'A'.$flag++ )->getStyle('A'.($flag-1))->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->fromArray( [ ["Batch Name","Batch SIP ID","Sector Name","Sub Sector Name","Job Name","Trainer Name","Date","Time","Student Enrolled","Female","Male","General","O.B.C","S.T","S.C","Status","Student Passed","Student Failed / Not Appeared","Student Placed","First Trans Amount","Second Trans Amount","Third Trans Amount"]],NULL,'B'.$flag++ )->getStyle('B'.(($flag-1)).':P'.(($flag-1)))->applyFromArray($styleArray);;

       $spreadsheet->getActiveSheet()->fromArray($value2,NULL,'B'.$flag++ );
       $spreadsheet->getActiveSheet()->fromArray([["Student Details"]],NULL,'A'.$flag++ )->getStyle('A'.($flag-1))->applyFromArray($styleArray);  

       $spreadsheet->getActiveSheet()->fromArray( [
       
        [
  'HOPE ID',
        'SIP ID',
        'Employment Id',
        'Student Name',
        'Email',
        "Mother's Name",
        "Father's Name",
        'D.O.B',
        'Aadhar No.',
        'Phone No.',
        'Result',
        'Placed Organisation',
        'Package per Month'
        ]
       ],NULL,'B'.$flag++ )->getStyle('B'.(($flag-1)).':P'.(($flag-1)))->applyFromArray($styleArray);;

       if(isset($tcBatchStudent[$key][$key1][$key2]))   {

         $spreadsheet->getActiveSheet()->fromArray($tcBatchStudent[$key][$key1][$key2],NULL,'B'.$flag++ );   
       }

       $flag=$flag+sizeof($tcBatchStudent[$key][$key1][$key2]);

      }
       # code...
     }
     $spreadsheet->getActiveSheet()->fromArray([['']],NULL,'A'.$flag++)->getStyle('A'.(($flag-1)).':K'.(($flag-1)))->applyFromArray($marArray);

  }
  // $spreadsheet->getActiveSheet()->fromArray($tpdis,NULL,'A12' );   
        // Top left coordinate of the worksheet range where
        $spreadsheet->getActiveSheet()->getStyle('A1:A9')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A10:G10')->applyFromArray($styleArray);
  
        foreach (range('A:N', $spreadsheet->getActiveSheet()->getHighestDataColumn()) as $col) {
          $spreadsheet->getActiveSheet()
                  ->getColumnDimension($col)
                  ->setAutoSize(true);
        } 
      


  $spreadsheet->getActiveSheet()
    ->getStyle('B')
    ->getNumberFormat()
    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    $spreadsheet->getActiveSheet()
    ->getStyle('J')
    ->getNumberFormat()
    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

      $filePath="downloads/".urlencode($arrayData[0]['Scheme Short Name']."_".$year."Student_Level").".xlsx";
     $writer->save($filePath);
     return $filePath;

}


if($data['scheme']['Targets Distributed'])
$filePath1=downloadReport1($data,$year);
$filePath2=downloadReport2($data,$year);
$filePath2_1=downloadReport2_1($data,$year);
$filePath3=downloadReport3($data,$year);
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TargetBatch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ($data['scheme']['Targets Distributed'])?$data['scheme']['Scheme Short Name']:"" ." Summary Report";
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];

$this->params['breadcrumbs'][] =$this->title;

?>
<style>
#container 
{
	overflow: auto;
	overflow-x: scroll;
  width: 70vw;

}
</style>
  <script src="https://unpkg.com/@araujoigor/json-grid/dist/JSONGrid.min.js"></script>

<div class="ibm-response-view">
<div class="card card-primary border-info" id="card">
      <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
      <h5 class="pull-left"><?= $this->title ?></h5>
      <h5 class="pull-right"> <?=($data['scheme']['Targets Distributed'])? "Year :".$data['scheme']['Finance Year']:"" ?></h5>
      </div>
      <div class="card-body">
      <?= $this->render('_year',
      [
        'year'=>$year,
        'filePath1'=>@$filePath1,
        'filePath2'=>@$filePath2,
        'filePath2_1'=>@$filePath2_1,
        'filePath3'=>@$filePath3
        
      ]
      ) ?>
      <div id="container"></div>
      <input type="hidden" name="">
      <!-- <textarea style="" id="myTextArea" style="display:none" readonly></textarea> -->
    </div>
    </div>
</div>
<script type="text/javascript">
$( document ).ready(function() {
var container = document.getElementById("container");
    var data =JSON.parse('<?= str_replace ("'","\'",json_encode($data['scheme'])) ?>') ;
    console.log(data);
if(data['Targets Distributed'].length==0)
alert("No Target Distributed")
    var jsonGrid = new JSONGrid(data, container);
    jsonGrid.render();
});
</script>
<script>
$('#container').width($('#card').width())
function populateSchemeData(year){
  var url=window.location.href;
if (url.search("year")) {
  window.location.href= url.split('year')[0]+"&year="+year
}else{
  window.location.href=  url+"&year="+year
}

}
</script>