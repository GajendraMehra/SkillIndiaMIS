<?php

namespace app\controllers;

use Yii;
use app\models\Job;
use app\models\SchemeJobs;
use app\models\Scheme;
use app\models\search\Job as JobSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * JobController implements the CRUD actions for Job model.
 */
class JobController extends Controller
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
 
    
    public function actionPopulateJobName($id,$tpid)
    {
        // print_r($tpid);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $clientCodes =ArrayHelper::map(Job::find()->where(['sector_id'=>$id])->all(), 'id', 'job_name');
        $data = [['id' => '', 'text' => '']];
        foreach ($clientCodes as $key=>$clientCode) {
            $data[] = ['id' => $key, 'text' => $clientCode];
        }
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT distinct job_id FROM `tbl_targets`  where tp_id = :tp_id")->bindValues([':tp_id' => $tpid]);

        $result = $command->queryAll();
        // print_r($result);
        return ['data' => $data,
                   'disable' =>$result
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
        
        $exception = Yii::$app->errorHandler->exception;
       
        return $this->render('/site/error', ['exception' => $exception
          ,'name'=>"Error",
          "message"=> $exception ]);
        }
    }
    /**
     * Lists all Job models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JobSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Job model.
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
     * Creates a new Job model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Job();
        $model->updated_at = date('Y-m-d H:i:s');
        $model->edited_by = Yii::$app->user->id;
        $model->created_at = date('Y-m-d H:i:s');
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('successcreated', "Created Successfully");

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Job model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->updated_at = date('Y-m-d H:i:s');
        $model->edited_by = Yii::$app->user->id;
        // $model->created_at = date('Y-m-d H:i:s');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('successcreated', "Created Successfully");

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Job model.
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
        throw new \yii\web\HttpException(403,
        'Can not Delete . Critical Data');
        // if($this->findModel($id)->delete())
        // Yii::$app->session->addFlash('successdeleted', "Successfully Deleted");

        return $this->redirect(['index']);
    }

    /**
     * Finds the Job model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Job the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Job::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionMultipleDelete()
    {
        $pk = Yii::$app->request->post('row_id');

        foreach ($pk as $key => $id) 
        {
            if($this->findModel($id)->delete())
        Yii::$app->session->addFlash('successdeleted', "Successfully Deleted");

        }

        return $this->redirect(['index']);

    }
}
