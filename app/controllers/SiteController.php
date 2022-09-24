<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\SignupForm;
use app\models\Student;
use app\models\UkBlocks;
use app\models\EducationLevel;
use app\models\Sector;
use app\models\TcenterAddress;
use app\models\CommonModel;
use app\models\Tcdetail;
use app\models\Job;
use frontend\models\ContactForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller
{
    // public $enableCsrfValidation = false;
    /**
     * {@inheritdoc}
     */

  
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login','populate-sector-jobs','populate-tc-sector-jobs','populate-tc-sectors','populate-centers','populate-sectors','populate-district-block', 'error','login1','signup','verify-email','student-signup','tp-signup','forget-password','reset-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout','getfile', 'index','error'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionGetfile($name="") 
    { 
        // $download = PstkIdentifikasi::findOne($id); 
        $rootPath = Yii::getAlias('@webroot/').$name;
        $temp=explode("/",$name);
        $fileName=end($temp);
      
        if(!$fileName)
        throw new \yii\web\HttpException(403,
            'No such file found');
        // if (file_exists($path)) {
            return Yii::$app->response->sendFile($rootPath, $fileName);
        // }
    }

    public function actionPopulateSectorJobs($id)
    {
        // print_r($tpid);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $clientCodes =ArrayHelper::map(CommonModel::getTcjobs($id), 'id', 'job_name');
        $data = [['id' => '', 'text' => '']];
        foreach ($clientCodes as $key=>$clientCode) {
            $data[] = ['id' => $key, 'text' => $clientCode];
        }

        // print_r($result);
        return ['data' => $data];
    }
    public function actionPopulateTcSectorJobs($id,$centerId="")
    {
        // print_r($tpid);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $clientCodes =ArrayHelper::map(CommonModel::getTcjobs($id,$centerId), 'id', 'job_name');
        $data = [['id' => '', 'text' => '']];
        foreach ($clientCodes as $key=>$clientCode) {
            $data[] = ['id' => $key, 'text' => $clientCode];
        }

        // print_r($result);
        return ['data' => $data];
    }public function actionPopulateTcSectors($id="",$did="")
    {
        // print_r($tpid);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $clientCodes =ArrayHelper::map(CommonModel::getTcsectors($id,$did), 'id', 'sector_name');
        $data = [['id' => '', 'text' => '']];
        foreach ($clientCodes as $key=>$clientCode) {
            $data[] = ['id' => $key, 'text' => $clientCode];
        }

        // print_r($result);
        return ['data' => $data];
    }
    public function actionPopulateSectors($id)
    {
        // print_r($tpid);
        Yii::$app->response->format = Response::FORMAT_JSON;
    //     echo "<pre>";
    //     print_r(Student::find()
    //     ->innerJoinWith('job', 'Student.prefrence_job = Job.id')
    //     ->innerJoinWith('sector', 'Sector.id = Job.sector_id')
    //     // ->andWhere(['T.productFeatureValueId' => ''])
    //    ->all());
        $clientCodes =ArrayHelper::map(Sector::find()
        ->innerJoinWith('tbl_jobs', 'Sector.id = tbl_jobs.sector_id')
        // ->andWhere(['T.productFeatureValueId' => ''])
       ->all(), 'id', 'job_name');
        $data = [['id' => '', 'text' => '']];
        foreach ($clientCodes as $key=>$clientCode) {
            $data[] = ['id' => $key, 'text' => $clientCode];
        }

        // print_r($result);
        return ['data' => $data];
    }
    public function actionPopulateCenters($id)
    { $data=[];
        Yii::$app->response->format = Response::FORMAT_JSON;

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT  center.*,address.address_line, CONCAT(center.name, ' ( Address : ', address.address_line ,' )' ) full_name  from tbl_tcdetail as center inner join tbl_tcenter_address as address on address.tc_id=center.id where address.city_id=:id")
        ->bindValues([':id' => $id]);
   
        $result = $command->queryAll();

        $c=ArrayHelper::map($result, 'id', 'full_name');

        foreach ($c as $key=>$clientCode) {
            $data[] = ['id' => $key, 'text' => $clientCode];
        }

        // print_r($result);
        return ['data' => $data];
    }

    public function actionPopulateDistrictBlock($id)
    {
        // print_r($tpid);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $clientCodes =ArrayHelper::map(UkBlocks::find()->where(['district_id'=>$id])->all(), 'id', 'name');
        $data = [['id' => '', 'text' => '']];
        foreach ($clientCodes as $key=>$clientCode) {
            $data[] = ['id' => $key, 'text' => $clientCode];
        }

        // print_r($result);
        return ['data' => $data];
    }

    public function actionStudentSignup()
    {
        if(Yii::$app->user->id!=""){
           
            throw new \yii\web\HttpException(403,
            'Please Logout To Access This Page');
            return 1;
        }
        $model = new Student();
        $model->updated_at = date('Y-m-d H:i:s');
        $model->edited_by = 0;
        $model->created_at = date('Y-m-d H:i:s');
        $model->load(Yii::$app->request->post());
        $model->adhar_file = UploadedFile::getInstance($model, 'adhar_file');
        $model->adhar_file_name ='';
        if ($model->adhar_file) {
            $model->adhar_file_name=$model->upload();
            if ($model->adhar_file_name) {
                // $model->adhar_file = null;
                if($model->save(false)){
                    Yii::$app->session->addFlash('Successfully Registered', 'Contact your Training Center.');

                    return $this->redirect(['login']);
                }
               
        
         }
        }elseif(Yii::$app->request->post()){
            Yii::$app->session->addFlash('errormessage', "Plese upload aadhar file. ");

        }
      

        return $this->render('student-signup', [
            'model' => $model,
        ]);


    }
    public function actionTpSignup()
        {
            Yii::$app->user->logout(); 
         
            return $this->render('tp-signup');


        }

    public function actionForgetPassword()
    {


        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(false)) {
                Yii::$app->session->addFlash('Check Email', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
              
                Yii::$app->session->addFlash('Error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }
        if ($model->errors) {
            Yii::$app->session->addFlash('Error', $model->errors['email'][0]);

        }
        return $this->goHome();

    }
    public function actionSignup()
    {
        $model = new SignupForm();
        $model->role=2;
        $model->load(Yii::$app->request->post());
        $tcCheck=Tcdetail::find()->where(['email'=>$model->email])->asArray()->all();
        if($tcCheck){
            Yii::$app->session->addFlash('register-error',"Duplicate Email ! This Email is already used by one of the TC.");
        }else{
                if ($model->signup()) {
                    Yii::$app->session->addFlash('register-success', 'Thank you for registration. Please check your inbox for verification email.');
                    return $this->goHome();
                }
                foreach ($model->errors as $key => $value) {
                    Yii::$app->session->addFlash('register-error', $value[0]);

                }
                }
           return $this->redirect(['tp-signup']);

    }


    public function actionResetPassword($token)
    {
      Yii::$app->session->addFlash('Error', 'Mail service is bloked by ITDA . Please contact admin to reset password.');
      return false;

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->addFlash('Success', 'Password Reset Successfully');

            return $this->goHome();
        }

        foreach ($model->errors as $key => $value) {
            Yii::$app->session->addFlash('Error', $value[0]);

           }
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {

	 $lastBackup=Yii::$app->config->get('last_backup',2919);

	$filename='database_backup_'.date('m_d_y').'.sql';
	if(strcmp($lastBackup,$filename)!==0){
	$result=exec('mysqldump skill_prod --password=SkillItda@2020 --user=root --single-transaction >/var/www/html/app/web/backups/'.$filename,$output);
	        Yii::$app->config->set('last_backup',$filename);

 	Yii::$app->mailer->setTransport([
            'class' => 'Swift_SmtpTransport',
           'host' => Yii::$app->config->get('mail-host'),
           'username' => Yii::$app->config->get('mail-username'),
           'password' => Yii::$app->config->get('mail-password'),
           'port' => Yii::$app->config->get('mail-port'),
           'encryption' => Yii::$app->config->get('mail-encryption'),
       
        ]);
       
    
    
            try
            {
                Yii::$app
                ->mailer
                ->compose()
		->attach('/var/www/html/app/web/backups/'.$filename)
		->setHtmlBody("Here is your daily backup of date ".date('d m Y')." <a href = '".Url::base('http').'/backups/'.$filename."'>Click here to download</a>")
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' Daily Backup'])
                ->setTo("manager.mis.uksdm@gmail.com")
                ->setSubject('Daily Backup ' . Yii::$app->name)
                ->send();
    
            }
            catch(\Swift_TransportException $exception)
            {
                   
                Yii::$app->session->addFlash('register-error',"Mail Server Error :" .$exception->getMessage());
    

            }

	}
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if ($model->user) {
                $this->setSessionToken($model->user);
                $count=Yii::$app->config->get('mis-counter',2919);
                $count=(Integer)$count+1;
              
                
                Yii::$app->config->set('mis-counter',$count);
                Yii::$app->session->addFlash('login-success', "Welcome ".$model->user->username);
                if(\yii::$app->user->identity->role=="5"){
                    Yii::$app->session->addFlash('', "Please do not modify any data in the MIS . You have only read only permission.");

                    # code...
                } else {
                    # code...
                    Yii::$app->session->addFlash('', "For Technical Help Please email at utmvcare@gmail.com\n and for other support connect at manager.mis.uksdm@gmail.com.
");
                }
                
            }
            return $this->goBack();
        } else {
            $model->password = '';
           foreach ($model->errors as $key => $value) {
            Yii::$app->session->addFlash('Error', $value[0]);

           }

            return $this->render('signup', [
                'model' => $model,
            ]);
        }
    }
    public function actionLogin1()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if ($model->user) {
               
                Yii::$app->session->addFlash('login-success', "Welcome ".$model->user->username);

            }

            // return $this->render('signup1', [
            //     'model' => $model,
            // ]);
            return $this->goBack();
        } else {
            $model->password = '';
           foreach ($model->errors as $key => $value) {
            Yii::$app->session->addFlash('login-error', $value[0]);

           }

            return $this->render('signup1', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


        public function setSessionToken($model)
        {
            $jwt = Yii::$app->jwt;
                        $time = time();
                        $token = Yii::$app->jwt->getBuilder()
                        ->identifiedBy('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
                        ->issuedAt($time) // Configures the time that the token was issue (iat claim)
                        ->withClaim('password_hash', $model->password_hash) // Configures a new claim, called "uid"
                        ->withClaim('session_token', Yii::$app->session->getId()) // Configures a new claim, called "uid"
                        ->getToken(); 
                        $model->session_token=(String)$token;
                        $model->save();
        }

        public function actionVerifyEmail($token)
        {
            Yii::$app->user->logout();
            try {
                $model = new VerifyEmailForm($token);
            } catch (InvalidArgumentException $e) {
                throw new BadRequestHttpException($e->getMessage());
            }
            if ($user = $model->verifyEmail()) {
                // if (Yii::$app->user->login($user)) {
                //    $this->setSessionToken($user);
                  
                // }
                Yii::$app->session->addFlash('register-success', 'Email Verified Successfully . Please Login ');
                return $this->goHome();
            }

            Yii::$app->session->addFlash('error', 'Sorry, we are unable to verify your account with provided token.');
            return $this->goHome();
        }
}