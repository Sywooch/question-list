<?php

namespace app\modules\unicred\questionlist\controllers;

use Yii;
use app\modules\unicred\questionlist\models\AnswerList;
use app\modules\unicred\questionlist\models\Office;
use app\modules\unicred\questionlist\models\QuestionList;
use app\modules\unicred\questionlist\models\AnswerListSearch;
use yii\helpers\ArrayHelper;
use app\modules\unicred\questionlist\controllers\ModuleBaseController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;

/**
 * AnswerList2Controller implements the CRUD actions for AnswerList model.
 */
class AnswerListController extends Controller
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
                    'archive' => ['post'],
                    'bulk-archive' => ['post'],
                ],
            ],
        ];
    }

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
        $model = $this->findModelAnswerList($id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "AnswerList #".$id,
                    'content'=>$this->renderAjax('view', [
                        'modelAnswerList' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'modelAnswerList' => $model,
                'noAjax' => true,
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
        $model = new AnswerList(['scenario'=>'create']);

        $model->date_from = (new \DateTime())->format('Y-m-d');
        $model->date_to = (new \DateTime('+1 month'))->format('Y-m-d');

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
                    'title'=> "Назначить опрос отделению",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'questionLists' => $questionLists,
                        'DoList' => $DoList,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Назначить опрос отделению",
                    'content'=>'<span class="text-success">Опрос назначен</span>',
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Назначить еще',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Назначить опрос отделению",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'questionLists' => $questionLists,
                        'DoList' => $DoList,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Сохранить',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'questionLists' => $questionLists,
                    'DoList' => $DoList,
                ]);
            }
        }
       
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
        $model = $this->findModelAnswerList($id);
        if($model->status != 'clear'){

            if($request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'title'=> "Обновить невозможно",
                    'content'=>$this->renderAjax('view', [
                        'modelAnswerList' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];
            }
            else {
                return $this->render('view', [
                    'modelAnswerList' => $model,
                ]);
            }
        }
        $modelsQuestionList = QuestionList::find()->all();
        $questionLists = ArrayHelper::map($modelsQuestionList, 'id', 'title');
        $statusList = $model->statusList;

        $modelsOffice = Office::find()->all();
        $DoList = ArrayHelper::map($modelsOffice, 'id', 'name');

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Изменение опроса №".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'questionLists' => $questionLists,
                        'DoList' => $DoList,
                        'statusList' => $statusList,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Опросный лист №".$id,
                    'content'=>$this->renderAjax('view', [
                        'modelAnswerList' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Изменение опроса №".$id,
                    'content'=>$this->renderAjax('update', [
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
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
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
        $model = $this->findModel($id);
        $request = Yii::$app->request;

        if($model->status != 'clear'){
            if($request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'title'=> "Удалить невозможно",
                    'content'=>$this->renderAjax('delete_denied', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];
            }
            else {
                return $this->render('delete_denied', [
                    'model' => $model,
                ]);
            }
        }
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
     * Archive an existing AnswerList model.
     * For ajax request will return json object
     * and for non-ajax request if archive is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionArchive($id)
    {
        $model = $this->findModel($id);
        $request = Yii::$app->request;

        if($model->status != 'done') {
            if($request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'title'=> "Перенести в архив невозможно",
                    'content'=>$this->renderAjax('archive_denied', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];
            }
            else {
                return $this->render('archive_denied', [
                    'model' => $model,
                ]);
            }
        }
        $model->status = 'archive';
        $model->save();
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        } else {
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
        $modelsCantBeDelete = []; //модели, которые немогут быть удалены
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            if($model->status != 'clear') {
                $modelsCantBeDelete[] = $model;
            } else {
                $model->delete();
            }
        }
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($modelsCantBeDelete)
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Удалить невозможно",
                    'content'=>$this->renderAjax('bulk_delete_denied', [
                        'modelsCantBeDelete' => new ArrayDataProvider([
                            'allModels' => $modelsCantBeDelete,
                        ]),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            if($modelsCantBeDelete)
                return $this->render('bulk_delete_denied', [
                    'modelsCantBeDelete' => new ArrayDataProvider([
                        'allModels' => $modelsCantBeDelete,
                    ]),
                ]);
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Archive multiple existing AnswerList model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkArchive()
    {
        $request = Yii::$app->request;
        $modelsCantBeArchive = []; //модели, которые немогут быть удалены
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            if($model->status != 'done') {
                $modelsCantBeArchive[] = $model;
            } else {
                $model->status='archive';
                $model->save();
            }
        }
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($modelsCantBeArchive)
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Перенести в архив невозможно",
                    'content'=>$this->renderAjax('bulk_archive_denied', [
                        'modelsCantBeArchive' => new ArrayDataProvider([
                            'allModels' => $modelsCantBeArchive,
                        ]),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            if($modelsCantBeArchive)
                return $this->render('bulk_archive_denied', [
                    'modelsCantBeArchive' => new ArrayDataProvider([
                        'allModels' => $modelsCantBeArchive,
                    ]),
                ]);
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

    protected function findModelAnswerList($id)
    {
        $model = AnswerList::findOne($id);
        if(!$model) throw new NotFoundHttpException('The requested page does not exist.');
        if($model->status =='clear') return $model;

        $query = AnswerList::find(['id'=>$id])->with(['questionList'=>function($query){
            $query->with('questions');
        }])->joinWith(['answers'=>function($q){
            $q->with(['question'=>function($q){
                $q->with('answerVariants');
            }]);
        }])->where([
            'questionlist_answer_list.id'=>$id,
            'questionlist_answers.answer_list_id'=>$id,
        ]);

        $model = $query->one();

        if($model) return $model;
        else throw new NotFoundHttpException('Не найдено.');
    }
}
