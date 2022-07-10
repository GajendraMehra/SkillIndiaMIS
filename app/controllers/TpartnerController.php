<?php
namespace app\controllers;
use Yii;
use app\models\Test;

use app\models\TpartnerDetail;
use app\models\search\TpartnerDetail as TpartnerDetailSearch;
use app\models\Villages;
use app\models\Cities;
use app\models\Users as User;
use app\models\TpartnerInvoice;
use app\models\TpartnerBank;
use app\models\TpdetailSpocoperation;
use app\models\TpdetailSpocfinance;
use app\models\TpdetailAddress;
use app\models\TpdetailCeo;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use yii\web\Response;
use yii\filters\VerbFilter;

class TpartnerController extends \yii\web\Controller
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
        $actionName=Yii::$app ->controller ->action->id;
        if (Yii::$app ->user ->identity->role!=5) {
            # code...
        if ($actionName == "view"
            ||$actionName=="change-status"
       
            ||$actionName=="index"
            )
        {
            $role_id = 1;
        }
        else
        {
            $role_id = 2;
        }
        if ($actionName == "accview"){
        $role_id = 4;
    }
        // die;
        if (Yii::$app ->user ->identity->role != $role_id) {
            throw new \yii\web\HttpException(403, 'You do not have permission to access this page. Contact admin');
            
            $exception = Yii::$app ->errorHandler->exception;
            
            return $this->render('/site/error', ['exception' => $exception, 'name' => "Error", "message" => $exception]);
        }
    }
    }
    public function actionCreate()
    {
        
        $tpdata = TpartnerDetail::findOne(['edited_by' => Yii::$app ->user ->identity->id]);
        if (isset($tpdata['final_submit'])){

            if ($tpdata['final_submit']==1)
            {
                return $this->render('status', ['tpdata' => $tpdata]);
            }
        }
        
        // print_r($formStatus);
        return $this->render('create');
    }

    public function actionIndex()
    {
        $searchModel = new TpartnerDetailSearch(['final_submit' => 1]);
        // $searchModel =  $searchModel->find() ->andWhere(['final_submit' => 1])->all();
        
        $dataProvider = $searchModel->search(Yii::$app ->request ->queryParams);
        
        return $this->render('index', 
        ['searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        // $modelTpartner = new TpartnerDetail();
        $modelTpartnerBank = new TpartnerBank();
        $modelTpartnerInvoice = new TpartnerInvoice();
        $modelTpdetailAddress = new TpdetailAddress();
        $modelTpdetailSpocoperation = new TpdetailSpocoperation();
        $modelTpdetailSpocfinance = new TpdetailSpocfinance();
        $modelTpdetailCeo = new TpdetailCeo();

        return $this->render('view', [
            'model' => TpartnerDetail::findOne($id),
             'modelTpartnerBank' => $modelTpartnerBank->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpartnerInvoice' => $modelTpartnerInvoice->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpdetailAddress' => $modelTpdetailAddress->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpdetailSpocoperation' => $modelTpdetailSpocoperation->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpdetailSpocfinance' => $modelTpdetailSpocfinance->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpdetailCeo' => $modelTpdetailCeo->find() ->andWhere(['tp_id' => $id])->one() ,
        
        ]);
    }

    
    public function actionAccview($id)
    {
        // $modelTpartner = new TpartnerDetail();
        $modelTpartnerBank = new TpartnerBank();
        $modelTpartnerInvoice = new TpartnerInvoice();
        $modelTpdetailAddress = new TpdetailAddress();
        $modelTpdetailSpocoperation = new TpdetailSpocoperation();
        $modelTpdetailSpocfinance = new TpdetailSpocfinance();
        $modelTpdetailCeo = new TpdetailCeo();

        return $this->render('view', [
            'model' => TpartnerDetail::findOne($id),
             'modelTpartnerBank' => $modelTpartnerBank->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpartnerInvoice' => $modelTpartnerInvoice->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpdetailAddress' => $modelTpdetailAddress->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpdetailSpocoperation' => $modelTpdetailSpocoperation->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpdetailSpocfinance' => $modelTpdetailSpocfinance->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpdetailCeo' => $modelTpdetailCeo->find() ->andWhere(['tp_id' => $id])->one() ,
        
        ]);
    }
    public function actionViewApplication($id)
    {
        // $modelTpartner = new TpartnerDetail();
        $modelTpartnerBank = new TpartnerBank();
        $modelTpartnerInvoice = new TpartnerInvoice();
        $modelTpdetailAddress = new TpdetailAddress();
        $modelTpdetailSpocoperation = new TpdetailSpocoperation();
        $modelTpdetailSpocfinance = new TpdetailSpocfinance();
        $modelTpdetailCeo = new TpdetailCeo();

        return $this->render('view', [
            'model' => TpartnerDetail::findOne($id),
             'modelTpartnerBank' => $modelTpartnerBank->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpartnerInvoice' => $modelTpartnerInvoice->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpdetailAddress' => $modelTpdetailAddress->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpdetailSpocoperation' => $modelTpdetailSpocoperation->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpdetailSpocfinance' => $modelTpdetailSpocfinance->find() ->andWhere(['tp_id' => $id])->one() ,
             'modelTpdetailCeo' => $modelTpdetailCeo->find() ->andWhere(['tp_id' => $id])->one() ,
        
        ]);
    }
    public function actionPopulateCityName($id)
    {
        Yii::$app
        ->response->format = Response::FORMAT_JSON;
        $clientCodes = Cities::find()->andWhere(['state_id' => $id])->all();
        $data = [['id' => '', 'text' => '']];
        foreach ($clientCodes as $clientCode)
        {
            $data[] = ['id' => $clientCode->id, 'text' => $clientCode->city];
        }
        return ['data' => $data];
    }
    public function actionAjaxTest()
    {
       
        $modelName = key(array_slice(Yii::$app ->request ->post() , -1, 1, true));
       
        switch ($modelName)
        {
            case 'TpartnerDetail':
                $model = new TpartnerDetail();
                $model->final_submit=0;
                $model->is_approved=2;
                $editedBy = $model->find() ->where(['edited_by' => Yii::$app ->user ->identity ->id]) ->one();
                
            break;
            case 'TpartnerInvoice':
                // $model = new TpartnerInvoice();
                $modelTpartner = new TpartnerDetail();
                $mtdetails = $modelTpartner->find() ->where(['edited_by' => Yii::$app ->user ->identity ->id]) ->one();
                $model = new TpartnerInvoice();
                $model->tp_id = $mtdetails['id'];
                $model->status=1;
                $editedBy = $model->find() ->where(['edited_by' => Yii::$app ->user ->identity ->id]) ->one();
                
            break;
            
            case 'TpartnerBank':
                // $model = new TpartnerInvoice();
                $modelTpartner = new TpartnerDetail();
                $mtdetails = $modelTpartner->find() ->where(['edited_by' => Yii::$app ->user ->identity ->id]) ->one();
                $model = new TpartnerBank();
                $model->tp_id = $mtdetails['id'];
                
                $editedBy = $model->find() ->where(['edited_by' => Yii::$app ->user ->identity ->id]) ->one();
                
            break;
            case 'TpdetailSpocoperation':
                // $model = new TpartnerInvoice();
                $modelTpartner = new TpartnerDetail();
                $mtdetails = $modelTpartner->find() ->where(['edited_by' => Yii::$app ->user ->identity ->id]) ->one();
                $model = new TpdetailSpocoperation();
                $model->tp_id = $mtdetails['id'];
                $editedBy = $model->find() ->where(['edited_by' => Yii::$app ->user ->identity ->id]) ->one();
                
            break;
            case 'TpdetailSpocfinance':
                // $model = new TpartnerInvoice();
                $modelTpartner = new TpartnerDetail(); 
                $mtdetails = $modelTpartner->find() ->where(['edited_by' => Yii::$app ->user ->identity ->id]) ->one();
                $model = new TpdetailSpocfinance();
                $model->tp_id = $mtdetails['id'];
                $editedBy = $model->find() ->where(['edited_by' => Yii::$app ->user ->identity ->id]) ->one();
                
            break;
            case 'TpdetailCeo':
                // $model = new TpartnerInvoice();
                $modelTpartner = new TpartnerDetail();
                $mtdetails = $modelTpartner->find() ->where(['edited_by' => Yii::$app ->user ->identity ->id]) ->one();
                $model = new TpdetailCeo();
                $model->tp_id = $mtdetails['id'];
                $editedBy = $model->find() ->where(['edited_by' => Yii::$app ->user ->identity ->id]) ->one();
                $mtdetails->final_submit = 1;
               
                
            break;
            case 'TpdetailAddress':
                // $model = new TpartnerInvoice();
                $modelTpartner = new TpartnerDetail();
                $mtdetails = $modelTpartner->find() ->where(['edited_by' => Yii::$app ->user ->identity ->id]) ->one();
                $model = new TpdetailAddress();
                $model->tp_id = $mtdetails['id'];
                $editedBy = $model->find() ->where(['edited_by' => Yii::$app ->user ->identity ->id]) ->one();
                
            break;
            
            default:
            # code...
            
            break;
        }
        $id = Yii::$app ->request ->post() [$modelName]['id'];
        if ($editedBy == "")
        {
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');
            $model->edited_by = Yii::$app ->user ->identity->id;
            
        }
        else
        {
            $model = $model->findOne($editedBy['id']);
            $model->updated_at = date('Y-m-d H:i:s');
            $model->edited_by = Yii::$app ->user ->identity->id;
            
        }
    
        // print_r(end());
        if (Yii::$app ->request ->isAjax)
        {
            Yii::$app ->response->format = \yii\web\Response::FORMAT_JSON;
            
            if ($model->load(Yii::$app ->request ->post()) && $model->save()) {

                if ($modelName=="TpdetailCeo") {
                    $mtdetails->save();
                }
                return ['data' => ['success' => true, 'model' => $model, 'message' => 'Model has been saved.', ], 'code' => 0, ];
            }
            else
            {
                $message="";
                foreach ( $model->errors as $key => $value) {
                   $message .=$value[0] ."\n";
                }
                // print_r(array_values($model->errors));
                return ['data' => ['success' => false, 'model' => $model->errors, 'message' => $message , ], 'code' => 1, // Some semantic codes that you know them for yourself
                ];
            }
        }
    }

    public function actionAjaxGet()
    {
        
        if (Yii::$app ->request ->isAjax)
        {
            $modeltpartner=new TpartnerDetail();
            $tpid=$modeltpartner->find()->where(['edited_by' => Yii::$app->user->identity->id])->one()['id'];
            if(Yii::$app ->request ->post()['tableName']=='copyspoc'){
                $model = new TpdetailSpocoperation();

            }else if(Yii::$app ->request ->post()['tableName']=='copyspocfinance'){
                $model = new TpdetailSpocfinance();
            }
            Yii::$app ->response->format = Response::FORMAT_JSON;
            return $model->find() ->andWhere(['tp_id' => $tpid])->one();
        }
        
    }
    public function actionValidate($id = null)
    {   
            switch (Yii::$app ->request ->post('ajax'))
            {
                case 'tpform-1':
                    $model = $id === null ? new TpartnerDetail() : TpartnerDetail::findOne($id);
                break;
                
                case 'tpform-2':
                    $model = $id === null ? new TpartnerInvoice() : TpartnerInvoice::findOne($id);
                break;
                
                case 'tpform-3':
                    $model = $id === null ? new TpartnerBank() : TpartnerBank::findOne($id);
                break;
                
                case 'tpform-5':
                    $model = $id === null ? new TpdetailAddress() : TpdetailAddress::findOne($id);
                break;
                case 'tpform-6':
                    $model = $id === null ? new TpdetailSpocoperation() : TpdetailSpocoperation::findOne($id);
                break;
                
                case 'tpform-7':
                    $model = $id === null ? new TpdetailSpocfinance() : TpdetailSpocfinance::findOne($id);
                break;
                
                case 'tpform-8':
                    $model = $id === null ? new TpdetailCeo() : TpdetailCeo::findOne($id);
                break;
                
                default:
                # code...
                
                break;
            }
        
            if ($model->load(Yii::$app ->request ->post())&&Yii::$app ->request->isAjax)
            {
                Yii::$app ->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
    }
    public function actionGetform()
    {
        return $this->render('service.php');
    }


    public function actionChangeStatus($id)
    {

       
        $model = TpartnerDetail::findOne($id);
        $model->is_approved=Yii::$app->request->post()['is_approved'];
        if ($model->save()) {
            if (Yii::$app->request->post()['is_approved']==1) {
                $this->sendEmail($model);
                Yii::$app->session->addFlash('success', $model->tp_name ." is approved.");
                
            }else{
                $this->sendEmail($model);
                Yii::$app->session->addFlash('error', $model->tp_name ." is rejected.");

            }

            return $this->redirect(['view', 'id' => $model->id]);
        }
        Yii::$app->session->addFlash('error',"Some Error occurs");

        // return $this->render('service.php');
    }


    protected function sendEmail($tp,$username="")
    {
       
        Yii::$app->mailer->setTransport([
            'class' => 'Swift_SmtpTransport',
           'host' => Yii::$app->config->get('mail-host'),
           'username' => Yii::$app->config->get('mail-username'),
           'password' => Yii::$app->config->get('mail-password'),
           'port' => Yii::$app->config->get('mail-port'),
           'encryption' => Yii::$app->config->get('mail-encryption'),
       
        ]);
            # code...
            $userdetail = User::find()->where(['id' => $tp->edited_by])->one(); 
    
    
            try
            {
                return Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'emailApplicant'],
                    ['tpartner' => $tp,'user'=>$userdetail]
                )
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' Mail Service'])
                ->setTo($userdetail->email)
                ->setSubject('Application status at ' . Yii::$app->name)
                ->send();
    
            }
            catch(\Swift_TransportException $exception)
            {
                User::findOne($user->id)->delete();;
    
                Yii::$app->session->addFlash('register-error',"Mail Server Error :" .$exception->getMessage());
    
                return false;
            }
    }

}

