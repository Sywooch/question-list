<?php

namespace igribov\questionlist\controllers;

use Yii;
use igribov\questionlist\models\UsersOffices;
use igribov\questionlist\models\Office;
use igribov\questionlist\models\UsersOfficesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use webvimark\modules\UserManagement\models\User;

/**
 * UsersOfficesController implements the CRUD actions for UsersOffices model.
 */
class UsersOfficesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
            'ghost-access'=> [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
        ];
    }

    /**
     * Lists all UsersOffices models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new UsersOfficesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single UsersOffices model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "UsersOffices #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new UsersOffices model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new UsersOffices();
        $modelsOffice = Office::find()->all();
        $usersRoles = UsersOffices::getRoles();
        $offices = ArrayHelper::map($modelsOffice, 'id', 'name');

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new UsersOffices",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'offices' => $offices,
                        'usersRoles' => $usersRoles,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                $this->addRoleAction($model);
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new UsersOffices",
                    'content'=>'<span class="text-success">Create UsersOffices success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new UsersOffices",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                $this->addRoleAction($model);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {

                return $this->render('create', [
                    'model' => $model,
                    'roleVariants' => ['manager'=>'Менеджер',0 => 'Нет роли'],
                    'offices' => $offices,
                    'usersRoles' => $usersRoles,
                ]);
            }
        }
       
    }

    protected function addRoleAction($model)
    {
        if(!$user = User::findOne(['username'=>$model->profile_id])) return;

        switch($model->role)
        {
            case 'admin' :
                User::assignRole($user->id, 'unicredQuestionListSystemAdmin');
                break;
            case 'manager' :
                User::assignRole($user->id, 'unicredQuestionListSystemManager');
                break;
            case 'empl' :
                break;
            case 'comdir' :
                User::assignRole($user->id, 'unicredQuestionListSystemCommercialDirector');
                break;
        }
    }

    protected function deleteRoleAction($model)
    {
        if(!$user = User::findOne(['username'=>$model->profile_id])) return;

        switch($model->role)
        {
            case 'admin' :
                User::revokeRole($user->id, 'unicredQuestionListSystemAdmin');
                break;
            case 'manager' :
                User::revokeRole($user->id, 'unicredQuestionListSystemManager');
                break;
            case 'empl' :
                break;
            case 'comdir' :
                User::revokeRole($user->id, 'unicredQuestionListSystemCommercialDirector');
                break;
        }
    }

    protected function changeRoleAction($model)
    {
        if(!$user = User::findOne(['username'=>$model->profile_id])) return;

        switch($model->role)
        {
            case 'admin' :
                User::assignRole($user->id, 'unicredQuestionListSystemAdmin');
                User::revokeRole($user->id, 'unicredQuestionListSystemCommercialDirector');
                User::revokeRole($user->id, 'unicredQuestionListSystemManager');
                break;
            case 'manager' :
                User::assignRole($user->id, 'unicredQuestionListSystemManager');
                User::revokeRole($user->id, 'unicredQuestionListSystemCommercialDirector');
                User::revokeRole($user->id, 'unicredQuestionListSystemAdmin');
                break;
            case 'empl' :
                User::assignRole($user->id, 'unicredQuestionListSystemManager');
                User::revokeRole($user->id, 'unicredQuestionListSystemCommercialDirector');
                User::revokeRole($user->id, 'unicredQuestionListSystemAdmin');
                break;
            case 'comdir' :
                User::assignRole($user->id, 'unicredQuestionListSystemCommercialDirector');
                User::revokeRole($user->id, 'unicredQuestionListSystemManager');
                User::revokeRole($user->id, 'unicredQuestionListSystemAdmin');
                break;
        }
    }

    /**
     * Updates an existing UsersOffices model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $modelsOffice = Office::find()->all();
        $usersRoles = UsersOffices::getRoles();
        $offices = ArrayHelper::map($modelsOffice, 'id', 'name');

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update UsersOffices #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'offices' => $offices,
                        'usersRoles' => $usersRoles,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                $this->changeRoleAction($model);
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "UsersOffices #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update UsersOffices #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                $this->changeRoleAction($model);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'offices' => $offices,
                    'usersRoles' => $usersRoles,
                ]);
            }
        }
    }

    /**
     * Delete an existing UsersOffices model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $this->deleteRoleAction($model);
        $model->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing UsersOffices model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = $request->post('pks'); // Array or selected records primary keys
        foreach (UsersOffices::findAll(json_decode($pks)) as $model) {
            $this->deleteRoleAction($model);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the UsersOffices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UsersOffices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsersOffices::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
