<?php

namespace app\modules\unicred\questionlist\controllers;

use app\modules\unicred\questionlist\models\QuestionList;
use yii\helpers\ArrayHelper;
use Yii;
use app\modules\unicred\questionlist\models\Question;
use app\modules\unicred\questionlist\models\QuestionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\unicred\questionlist\models\Model;
use app\modules\unicred\questionlist\models\AnswerVariant;

/**
 * QuestionController implements the CRUD actions for Question model.
 */
class QuestionController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Question models.
     * @return mixed
     */
    public function actionIndex($list_id)
    {
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'list_id' => intval($list_id),
        ]);
    }

    /**
     * Displays a single Question model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $list_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'list_id' => $list_id,
        ]);
    }

    /**
     * Creates a new Question model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($list_id)
    {
        $model = new Question();
        $model->list_id = $list_id;
        $post = Yii::$app->request->post();

        //если данные загрузились в объект вопроса и он валиден
        if ($model->load($post) && $valid = $model->validate()) {
            $transaction = \Yii::$app->db->beginTransaction();
            // Если сохранили успешно объек вопроса
            if($model->save()) {
                //Если для этого типа нужно сохранять опции
                switch($model->type)
                {
                    case 'select_one':
                    case 'select_multiple':
                    case 'radio':
                        if(is_array($post['AnswerVariant'])) foreach($post['AnswerVariant'] as $av_data){
                            $answerVariantModel = new AnswerVariant($av_data);
                            $answerVariantModel->question_id = $model->id;
                            $valid = $answerVariantModel->save();
                        }
                        break;
                    case 'checkbox' :
                        if(!(int)$post['checkboxUpScores']) break;
                        $answerVariantModel = new AnswerVariant();
                        $answerVariantModel->answer = '1';
                        $answerVariantModel->scores = (int)$post['checkboxUpScores'];
                        $answerVariantModel->question_id = $model->id;
                        $valid = $answerVariantModel->save();
                        break;
                }

            } else {
                $transaction->rollBack();
            }
            if($valid) {
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id,'list_id' => $list_id]);
            }
            else {
                $transaction->rollBack();
                return $this->render('create', [
                    'model' => $model,
                    'list_id' => $list_id,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'list_id' => $list_id,
            ]);
        }
    }

    /**
     * Updates an existing Question model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $list_id
     * @return mixed
     */
    public function actionUpdate($id, $list_id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();

        //$model->answerVariants

        //если данные загрузились в объект вопроса и он валиден
        if ($model->load($post) && $valid = $model->validate()) {

            $transaction = \Yii::$app->db->beginTransaction();
            // Если сохранили успешно объек вопроса
            if($model->save()) {
                //Если для этого типа нужно сохранять опции
                switch($model->type)
                {
                    case 'select_one':
                    case 'select_multiple':
                    case 'radio':
                    $modelsAnswerVariants = [];
                    $deletedAnswerVariantsIDs = array_values(ArrayHelper::map($model->answerVariants, 'id', 'id'));
                    if($post['AnswerVariant']) foreach($post['AnswerVariant'] as $av) {
                        $m = new AnswerVariant();$m->id = $av['id'];
                        $modelsAnswerVariants[] = ($m);
                    }
                    Model::loadMultiple($modelsAnswerVariants, $post);
                    if(!empty($deletedAnswerVariantsIDs))AnswerVariant::deleteAll(['id'=>$deletedAnswerVariantsIDs]);
                    foreach($modelsAnswerVariants as $answerVariantModel){
                        $answerVariantModel->question_id = $model->id;
                        $valid = $answerVariantModel->save();
                    }
                    if($valid) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id,'list_id' => $list_id,]);
                    }
                    else {
                        $transaction->rollBack();
                        return $this->render('update', [
                            'model' => $model,
                            'list_id' => $list_id,
                        ]);
                    }
                        break;
                    case 'checkbox' :
                        $answerVariantModel = $model->answerVariants[0];
                        // если не переданы кол-во балов при установке чек-бокса
                        if(!(int)$post['checkboxUpScores']){
                            //но они были ранее
                            if($answerVariantModel) $answerVariantModel->delete();
                            break;
                        }
                        if(!$answerVariantModel){
                            $answerVariantModel = new AnswerVariant();
                            $answerVariantModel->answer = '1';
                            $answerVariantModel->question_id = $model->id;
                        }
                        //а если переданы, то заменяем
                        $answerVariantModel->scores = (int)$post['checkboxUpScores'];
                        $valid = $answerVariantModel->save();
                        break;
                    default:
                        //На тот случай, если сменили тип поля с ВЫБОР ИЗ ВАРИАНТОВ на ТЕКСТ, удаляем варианты ответа
                        AnswerVariant::deleteAll(['id'=>array_values(ArrayHelper::map($model->answerVariants,'id','id'))]);
                }

            } else {
                $transaction->rollBack();
            }
            if($valid) {
                $transaction->commit();
                return $this->redirect(['view', 'id'=>$model->id, 'list_id'=>$list_id]);
            }
            else {
                $transaction->rollBack();
                return $this->render('create', [
                    'model' => $model,
                    'list_id' => $list_id,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'list_id' => $list_id,
            ]);
        }
    }

    /**
     * Deletes an existing Question model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id,$list_id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'list_id'=>$list_id]);
    }

    /**
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
