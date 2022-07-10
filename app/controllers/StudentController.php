<?php

namespace app\controllers;

use Yii;
use app\models\Student;
use app\models\BatchStudents;
use app\models\CommonModel;
use app\models\search\Student as StudentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
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
        if (Yii::$app ->user ->identity->role!=5) {

        if (Yii::$app ->user ->identity->role != $role_id&&$role_id>0) {
            throw new \yii\web\HttpException(403, 'You do not have permission to access this page. Contact admin');
            
            $exception = Yii::$app ->errorHandler->exception;
            
            return $this->render('/site/error', ['exception' => $exception, 'name' => "Error", "message" => $exception]);
        }
    }
    }
    /**
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();

        if (Yii::$app ->user ->identity->role==5) {
            $searchModel = new StudentSearch();

        }
        else if (Yii::$app ->user ->identity->role==1) {
            $searchModel = new StudentSearch();

        }else if (Yii::$app ->user ->identity->role==3) {
            $tcdetails=CommonModel::getTcdetailbyuserid();
            $searchModel = new StudentSearch(['selected_tc'=>$tcdetails['id']]);
        }else {
            throw new \yii\web\HttpException(403, 'You do not have permission to access this page. Contact admin');

        }
        

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
  public function actionMyStudents()
    {
        $tcdetails=CommonModel::getTcdetailbyuserid();
        $searchModel = new StudentSearch(['selected_tc'=>$tcdetails['id']]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Student model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $datamodel=$this->findModel($id);
         
       if(Yii::$app->user->identity->role==2){
            if(Yii::$app->user->identity->id!=$datamodel->trainingcenters->parenttp->edited_by){
                throw new \yii\web\HttpException(403,
                'You do not have permission to access this page.');
            
            }
           

        }
        elseif(Yii::$app->user->identity->role==3){
            if(Yii::$app->user->identity->email!=$datamodel->trainingcenters->email){
                throw new \yii\web\HttpException(403,
                'You do not have permission to access this page.');
            
            }

        }
        return $this->render('view', [
            'model' => $datamodel
        ]);
    }

    /**
     * Creates a new Student model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $tcdetails=CommonModel::getTcdetailbyuserid();
        $model = new Student();
        $model->selected_tc=$tcdetails['id'];
        $model->updated_at = date('Y-m-d H:i:s');
        $model->edited_by = Yii::$app->user->id;
        $model->created_at = date('Y-m-d H:i:s');
        $model->load(Yii::$app->request->post());
        $model->adhar_file = UploadedFile::getInstance($model, 'adhar_file');
        $model->adhar_file_name ='';
        if ($model->adhar_file) {
            $model->adhar_file_name=$model->upload();
            if ($model->adhar_file_name) {
            $model->save(false);
            Yii::$app->session->addFlash('successcreated', "Student Added Successfully");

            return $this->redirect(['view', 'id' => $model->id]);
        }

        }elseif(Yii::$app->request->post()){
            Yii::$app->session->addFlash('errormessage', "Plese upload aadhar file. ");

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $datamodel=$this->findModel($id);
         
        if(Yii::$app->user->identity->role==2){
             if(Yii::$app->user->identity->id!=$datamodel->trainingcenters->parenttp->edited_by){
                 throw new \yii\web\HttpException(403,
                 'You do not have permission to access this page.');
             
             }
            
 
         }
         elseif(Yii::$app->user->identity->role==3){
             if(Yii::$app->user->identity->email!=$datamodel->trainingcenters->email){
                 throw new \yii\web\HttpException(403,
                 'You do not have permission to access this page.');
             
             }
 
         }
        $model->load(Yii::$app->request->post());
        $model->adhar_file = UploadedFile::getInstance($model, 'adhar_file');
        $model->adhar_file_name ='';
        if ($model->adhar_file) {
            $model->adhar_file_name=$model->upload();
            if ($model->adhar_file_name) {
            $model->save(false);
            Yii::$app->session->addFlash('successcreated', "Updated Successfully");

            return $this->redirect(['view', 'id' => $model->id]);
        }

        }elseif(Yii::$app->request->post())
        {
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);

        }
       

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Student model.
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
        if (BatchStudents::find()->where(['student_id'=>$id])->count()) {
            throw new \yii\web\HttpException(403,
            'You can not delete this Student . This student is already include in a batch.');
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
