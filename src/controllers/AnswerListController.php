<?php

namespace igribov\questionlist\controllers;

use Yii;
use igribov\questionlist\models\AnswerList;
use igribov\questionlist\models\AnswerListSearch;
use igribov\questionlist\controllers\ModuleBaseController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use igribov\questionlist\models\QuestionList;
use igribov\questionlist\models\Office;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use webvimark\modules\UserManagement\models\User;

/**
 * AnswerListController implements the CRUD actions for AnswerList model.
 */
class AnswerListController extends Controller
{

    /**
     * Lists all AnswerList models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new AnswerListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $statusList = AnswerList::getStatusList();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusList' => $statusList,
        ]);
    }


    /**
     * Displays a single AnswerList model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "AnswerList #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'answersDataProvider' => new ArrayDataProvider([
                            'allModels' => $model->answers,
                        ]),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $model,
                'answersDataProvider' => new ArrayDataProvider([
                    'allModels' => $model->answers,
                ]),
            ]);
        }
    }

    /**
     * Creates a new AnswerList model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new AnswerList();
        $modelsQuestionList = QuestionList::find()->all();
        $questionLists = ArrayHelper::map($modelsQuestionList, 'id', 'title');

        $modelsOffice = Office::find()->all();
        $DoList = ArrayHelper::map($modelsOffice, 'id', 'name');

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new AnswerList",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'questionLists' => $questionLists,
                        'DoList' => $DoList,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) ){
                $model->status = 'clear';
                $model->list_name = $model->questionList->title;
                if($model->save()){
                    return $this->redirect(['index']);
                }
            }else{           
                return [
                    'title'=> "Create new AnswerList",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'questionLists' => $questionLists,
                        'DoList' => $DoList,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load(Yii::$app->request->post()) ) {
                $model->status = 'clear';
                $model->list_name = $model->questionList->title;
                if($model->save()) return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'questionLists' => $questionLists,
                    'DoList' => $DoList,
                ]);
            }
        }
       
    }

    public function actionUpdateStatus($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $statusList = $model->statusList;

        /*if(User::hasRole(['unicredQuestionListSystemCommercialDirector']))
        {
            die();
        }*/

    }

    /**
     * Updates an existing AnswerList model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $modelsQuestionList = QuestionList::find()->all();
        $questionLists = ArrayHelper::map($modelsQuestionList, 'id', 'title');
        $statusList = $model->statusList;

        $viewName = 'update';

        $modelsOffice = Office::find()->all();
        $DoList = ArrayHelper::map($modelsOffice, 'id', 'name');

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update AnswerList #".$id,
                    'content'=>$this->renderAjax($viewName, [
                        'model' => $model,
                        'questionLists' => $questionLists,
                        'DoList' => $DoList,
                        'statusList' => $statusList,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post())){
                $model->list_name = $model->questionList->title;
                if($model->save()){
                    return $this->redirect(['index']);
                }
                /*if ($model->save()) return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "AnswerList #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'questionLists' => $questionLists,
                        'DoList' => $DoList,
                        'answersDataProvider' => new ArrayDataProvider([
                            'allModels' => $model->answers,
                        ]),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];*/
            }else{
                 return [
                    'title'=> "Update AnswerList #".$id,
                    'content'=>$this->renderAjax($viewName, [
                        'model' => $model,
                        'questionLists' => $questionLists,
                        'DoList' => $DoList,
                        'statusList' => $statusList,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post())) {
                $model->list_name = $model->questionList->title;
                if ($model->save()) return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render($viewName, [
                    'model' => $model,
                    'questionLists' => $questionLists,
                    'DoList' => $DoList,
                    'statusList' => $statusList,
                ]);
            }
        }
    }

    /**
     * Delete an existing AnswerList model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            $this->redirect(['index']);
            return 'Запись успешно удалена.';
            //Yii::$app->response->format = Response::FORMAT_JSON;
            //return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing AnswerList model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = $request->post('pks'); // Array or selected records primary keys
        foreach (AnswerList::findAll(json_decode($pks)) as $model) {
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            //Yii::$app->response->format = Response::FORMAT_JSON;
            $this->redirect(['index']);
            return 'Записи успешно удалены.';
            //return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the AnswerList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AnswerList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AnswerList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
