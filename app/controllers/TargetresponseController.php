<?php

namespace app\controllers;

use Yii;
use app\models\TargetsResponse;
use app\models\CommonModel;
use app\models\Targets;
use app\models\search\TargetsResponse as TargetsResponseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\search\TargetDistrict as TargetDistrictSearch;
use app\models\search\TargetJob as TargetJobSearch;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use app\models\Job;

/**
 * TargetresponseController implements the CRUD actions for TargetsResponse model.
 */
class TargetresponseController extends Controller
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
            ], 'access' => [
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
                // $this->displayError();
            }
            
            return parent::beforeAction($action);
        }
    
        public function displayError()
        {
            // echo "error";
            $actionName=Yii::$app ->controller ->action->id;
            $role_id = 2;

            // die;
            if (Yii::$app ->user ->identity->role != $role_id) {
                throw new \yii\web\HttpException(403, 'You do not have permission to access this page. Contact admin');
                
                $exception = Yii::$app ->errorHandler->exception;
                
                return $this->render('/site/error', ['exception' => $exception, 'name' => "Error", "message" => $exception]);
            }
        }
    /**
     * Lists all TargetsResponse models.
     * @return mixed
     */


    public function actionIndex()
    {
        $tpid = CommonModel::getTpdetailbyuserid()['id'];

        $searchModel = new TargetsResponseSearch(['tp_id'=>$tpid]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title'=>"All ACKNOWLEDGED TARGETS"
        ]);
    }

    public function actionPopulateTargetsJobs($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $jobid=TargetsResponse::findOne($id)->job_id;
        $clientCodes =ArrayHelper::map(Job::find()->where(['id'=>$jobid])->all(), 'id', 'job_name');
        $data = [['id' => '', 'text' => '']];
        foreach ($clientCodes as $key=>$clientCode) {
            $data[] = ['id' => $key, 'text' => $clientCode];
        }
       
        return ['data' => $data,
        'selected'=> $jobid,
            ];
    }
 public function actionAchieved()
    {
        $tpid = CommonModel::getTpdetailbyuserid()['id'];
     
       
        $searchModel = new TargetsResponseSearch(['status'=>1,'tp_id'=>$tpid]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title'=>"Achieved ACKNOWLEDGED TARGETS"
        ]);
    }
 public function actionDeclined()
    {
        $searchModel = new TargetsResponseSearch(['status'=>2]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title'=>"Declined ACKNOWLEDGED TARGETS"
        ]);
    }

    /**
     * Displays a single TargetsResponse model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {  
        $datamodel=$this->findModel($id);
        $target_id=$datamodel->target_id;


        
    
        if(Yii::$app->user->identity->role==2){
            if(Yii::$app->user->identity->id!=$datamodel->center->parenttp->edited_by){
                throw new \yii\web\HttpException(403,
                'You do not have permission to access this page.');
            
            }
           

        }
        elseif(Yii::$app->user->identity->role==3){
            if(Yii::$app->user->identity->email!=$datamodel->center->email){
                throw new \yii\web\HttpException(403,
                'You do not have permission to access this page.');
            
            }

        }


        $searchModel = new TargetsResponseSearch(['id'=>$id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $searchModel1 = new TargetJobSearch(['target_id'=>$id]);
        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams);

        // print_r($model1);
        // $model2=  TargetJob::find()->where(['target_id'=>$id])->all();
        return $this->render('view', [
            'model' => Targets::findOne($target_id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProvider1' => $dataProvider1,
            // 'model2' => $model2,1111
           
        ]);
    }

    /**
     * Creates a new TargetsResponse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TargetsResponse();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TargetsResponse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdateTarget()
    {
        $post=Yii::$app->request->post();
        $model = $this->findModel($post['targetId']);
 
        $assign=TargetsResponse::find()->andWhere(['!=','status',2])->andWhere(['target_id'=>$model->target_id])->sum('response_number');
        $total=Targets::findOne($model->target_id)->number;
         $remaining=$total-($assign-$model->response_number);
         $model->response_number=$post['updatedTarget'];

//          echo "<pre>";
//          print_r($remaining);
//          print_r($assign);
//          print_r(($assign-$model->response_number));
// die;
         if ($remaining>=  $model->response_number) {
            if($model->save()){
            Yii::$app->session->addFlash('successmessage', "Target Updated Successfully");

            };
         }else{
            Yii::$app->session->addFlash('errormessage', "Limit Exceed . Please fill no less than or equal to the remaning target.");
         }

        // if ($post && $model->save()) {
            return $this->redirect(['target/view-response', 'id' => $model->target_id]);
        

        // return $this->render('update', [
        //     'model' => $model,
        // ]);
    }
    /**
     * Deletes an existing TargetsResponse model.
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionDeleteTarget()
    {
        $post=Yii::$app->request->post();
        $model = $this->findModel($post['deleteTargetId']);
        if($model->delete()){
            Yii::$app->session->addFlash('successmessage', "Target Deleted Successfully");

            };

        // if ($post && $model->save()) {
            return $this->redirect(['target/view-response', 'id' => $model->target_id]);
        
    }

    /**
     * Finds the TargetsResponse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TargetsResponse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TargetsResponse::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
