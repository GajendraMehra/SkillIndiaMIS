<?php

namespace app\controllers;

use Yii;
use app\models\AccountantData;
use app\models\search\AccountantData as AccountantDataSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AccdataController implements the CRUD actions for AccountantData model.
 */
class AccdataController extends Controller
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
        if (Yii::$app->user->identity->role!=4) {
            throw new \yii\web\HttpException(403,
            'You do not have permission to access this page. Contact admin');
        
        $exception = Yii::$app->errorHandler->exception;
       
        return $this->render('/site/error', ['exception' => $exception
          ,'name'=>"Error",
          "message"=> $exception ]);
        }
    }
    /**
     * Lists all AccountantData models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountantDataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    

    /**
     * Displays a single AccountantData model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AccountantData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AccountantData();
        $model->updated_at = date('Y-m-d H:i:s');
        $model->edited_by = Yii::$app->user->id;
        $model->created_at = date('Y-m-d H:i:s');

        $model->load(Yii::$app->request->post());
        $model->file_image = UploadedFile::getInstance($model, 'file_image');
        // echo "<pre>";
        // print_r( $model->file_image);die;
        $model->file_name ='';
        if ($model->file_image) {
   
            $model->file_name=$model->upload();
        if ($model->file_name) {
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AccountantData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
  

    /**
     * Deletes an existing AccountantData model.
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
        $model=$this->findModel($id);
        if(file_exists(Yii::$app->basePath . '/web/' . $model->file_name)){
            unlink(Yii::$app->basePath . '/web/' . $model->file_name);
            $model->delete();
            Yii::$app->session->addFlash('successdeleted', "Successfully Deleted");


        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the AccountantData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AccountantData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AccountantData::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
