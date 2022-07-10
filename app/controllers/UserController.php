<?php

namespace app\controllers;
use Yii;
use app\models\Users;
use app\models\PasswordForm;
use app\models\search\Users as UsersSearch;

use yii\web\Controller;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;


class UserController extends Controller
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

    public function actionChangeStatus($id,$status)
    {
        $user=Users::findOne($id);
        $user->status=$status;

        if($user->save()){
            Yii::$app->session->addFlash('successmessage', "Done Successfully");

            return $this->redirect(['view','id'=>$id]);
        }
       
    }
    public function actionIndex()
    {
        
        $model = new PasswordForm;
        // echo Yii::$app->user->identity->profile_pic;
        $modeluser = Users::find()->where([
            'username'=>Yii::$app->user->identity->username
        ])->one();
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                try{
                    $modeluser->password_hash = Yii::$app->security->generatePasswordHash($_POST['PasswordForm']['newpass']);

                    if($modeluser->save()){
                        Yii::$app->getSession()->addFlash(
                            'successmessage','Password changed'
                        );
                        Yii::$app->user->logout();
                        return $this->goHome();
                       
                    }else{
                        Yii::$app->getSession()->addFlash(
                            'errormessage','Password not changed'
                        );
                     
                    }
                }catch(Exception $e){
                    Yii::$app->getSession()->addFlash(
                        'errormessage',"{$e->getMessage()}"
                    );
                   
                }
            }
        }
        return $this->render('index',[
            'model'=> Users::findOne(Yii::$app->user->identity->id),
            'model1'=> new PasswordForm,
            'uploadFile' => new UploadForm()

        ]);
    }

    public function actionAlluser()
    {
        if (Yii::$app ->user ->identity->role!=1&&Yii::$app ->user ->identity->role!=5) {
            throw new \yii\web\HttpException(403, 'You do not have permission to access this page. Contact admin');
        }
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('alluser', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
       
        if (Yii::$app ->user ->identity->role!=1&&Yii::$app ->user ->identity->role!=5) {
            throw new \yii\web\HttpException(403, 'You do not have permission to access this page. Contact admin');
        }

      
        $user=Users::findOne($id);
       
        return $this->render('view', [
            'model' => $user
        ]);
    }

    public function actionSettings()
    {

        if (Yii::$app ->user ->identity->role!=1&&Yii::$app ->user ->identity->role!=5) {
            throw new \yii\web\HttpException(403, 'You do not have permission to access this page. Contact admin');
        }
        Yii::$app->config->set('active_tab', 'nav-general-tab');

        $post=Yii::$app->request->post();
        // print_r($post);
        foreach ($post['theme']?? [] as $key => $value) {
            Yii::$app->config->set('active_tab', 'nav-theme-tab');
           $flag= Yii::$app->config->set($key, $value);
        }
        foreach ($post['general']?? [] as $key => $value) {
            Yii::$app->config->set('active_tab', 'nav-general-tab');

            $flag= Yii::$app->config->set($key, $value);

        }
         foreach ($post['rabitmq']?? [] as $key => $value) {
            Yii::$app->config->set('active_tab', 'nav-rabitmq-tab');

            $flag= Yii::$app->config->set($key, $value);

        } 
        foreach ($post['mail']?? [] as $key => $value) {
            Yii::$app->config->set('active_tab', 'nav-mail-tab');

            $flag= Yii::$app->config->set($key, $value);

        }
        if ($post) {
            Yii::$app->session->addFlash('successmessage', "Setting Saved Suddessfully");

        }

    

        return $this->render('setting',[
           

        ]);
        
    }
    public function actionUploadFile()
    {
        $code=false;
        $model = new UploadForm();
        $model->file = UploadedFile::getInstance($model, 'file');
        $name='uploads/userpics/'.time().'.'.$model->file->extension;

        if ($model->validate()) {                
            $code= $model->file->saveAs( $name ,$model->file->baseName . '.' . $model->file->extension);
        }
        if ($code) {
            $user=Users::findOne(Yii::$app->user->identity->id);
            $user->profile_pic=$name;
            $user->updated_at=time();
            $user->save();
            Yii::$app->getSession()->addFlash(
                'successmessage','Profile Pic changed Successfiully'
            );
           
        }else{
            Yii::$app->getSession()->addFlash(
                'errormessage','Some Error Occurs'
            );
        }
        return $this->redirect(['user/']);
    }

}
