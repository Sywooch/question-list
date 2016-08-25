<?php

namespace app\modules\unicred\questionlist\controllers;

use Yii;
use app\modules\unicred\questionlist\models\AnswerList;
use app\modules\unicred\questionlist\models\AnswerListSearch;
use app\modules\unicred\questionlist\controllers\ModuleBaseController as Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use \yii\web\Response;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;

/**
 * StatisticController implements the CRUD actions for AnswerList model.
 */
class ConfirmQuestionListController extends Controller
{
    /**
     * Lists all AnswerList models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new AnswerListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single AnswerList model.
     * @param integer $id
     * @return mixed
     */
    public function actionConfirm($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isGet){
            return $this->render('confirm', [
                'model' => $model,
                'answersDataProvider' => new ArrayDataProvider([
                    'allModels' => $model->answers,
                ]),
            ]);
        }else if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('confirm', [
            'model' => $model,
            'answersDataProvider' => new ArrayDataProvider([
                'allModels' => $model->answers,
            ]),
        ]);


    }
    /*
     * Вывод сообщения о том,
     *  что изменение данного опроса невозможно.
     * */
    protected function updateDenied($model){
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> "Опросный лист #".$model->id,
                'content'=>$this->renderAjax('update_denied', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
            ];
        }else{
            return $this->render('update_denied', [
                'model' => $model,
            ]);
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
        $model = $this->findModel($id);
        // Если опрос в работе у отделения, и отделение уже дало ответы
        // Изменять статус опроса нельзя.
        if($model->status == 'answered'){
            return $this->updateDenied($model);
        }
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Обновление назначенного опросного листа #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Обновление назначенного опросного листа #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'answersDataProvider' => new ArrayDataProvider([
                            'allModels' => $model->answers,
                        ]),
                    ]),
                    'footer'=> Html::button('Закрыть',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Изменить',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update AnswerList #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
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
                return $this->redirect(['view',
                    'id' => $model->id,
                    'answersDataProvider' => new ArrayDataProvider([
                        'allModels' => $model->answers,
                    ]),
                ]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
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
