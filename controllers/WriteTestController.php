<?php

namespace app\modules\unicred\questionlist\controllers;
use app\modules\unicred\questionlist\models\AnswerVariant;
use app\modules\unicred\questionlist\models\Question;
use Yii;
use app\modules\unicred\questionlist\controllers\ModuleBaseController as Controller;
use app\modules\unicred\questionlist\models\Model;
use app\modules\unicred\questionlist\models\QuestionList;
use app\modules\unicred\questionlist\models\Users;
use app\modules\unicred\questionlist\models\Answer;
use app\modules\unicred\questionlist\models\AnswerList;
use app\modules\unicred\questionlist\models\WriteTestSearch;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Class AnswerListController
 * @package app\modules\unicred\questionlist\controllers
 * Класс для создания сущности список ответов на вопросный лист
 */
class WriteTestController extends Controller
{

    /**
     * Меняет статус листа на Отправлен
     * @param integer $id
     * @return mixed
     */
    public function actionSend($id)
    {
        //$request = Yii::$app->request;
        $model = $this->findAnswerListModel($id);
        if(!$model) throw new NotFoundHttpException();
        $model->status = 'send';
        $model->save();
        return $this->redirect(['index']);
    }
    /**
     * Displays a single AnswerList model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $modelAnswerList = $this->findAnswerListModel($id);
        $modelQuestionList = $modelAnswerList->questionList;

        if(! $modelQuestionList ) {
            return $this->render('locked_answer_list', [
                'modelAnswerList' => $modelAnswerList,
                'dataProvider' => new ActiveDataProvider([
                    'query' => Answer::find()->where(['answer_list_id'=>$id]),
                ]),
            ]);
        }
        $modelsQuestion = $modelQuestionList->questions;

        $dataProvider = new ArrayDataProvider([
            'allModels' => $modelAnswerList->answers,
        ]);

        return $this->render('view', [
            'modelAnswerList' => $modelAnswerList,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex()
    {
        $statusList = AnswerList::getStatusList();
        $searchModel = new WriteTestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'statusList' => $statusList,
        ]);
    }

    /**
     * @return string
     *
     * Отображает чистую форму для заполнения со списком вопросов
     */
    public function actionCreate($id)
    {
        $modelAnswerList = $this->findAnswerListModel($id);
        $modelAnswerList->scenario = 'write-test';
        if ($modelAnswerList->status !== 'clear')
            Yii::$app->getResponse()->redirect(Url::toRoute(['update', 'id' => $modelAnswerList->id]));

        $modelQuestionList = $modelAnswerList->questionList;
        $modelsQuestion = $modelQuestionList->questions;

        // если форма отправлена.
        if ($postData = Yii::$app->request->post()) {
            $modelsAnswer = Model::createMultiple(Answer::classname(), [], $scenario = ['scenario' => 'create']);
            Model::loadMultiple($modelsAnswer, $postData);
            $valid = false;

            $sumScores = 0;
            $groupsOfModelsAnswerVariants = $this->getAllAnswerVariantsGroupByQuestionId($modelAnswerList->question_list_id);
            foreach ($modelsAnswer as $modelAnswer) {
                $modelAnswer->question_list_id = $modelAnswerList->question_list_id;
                $modelAnswer->answer_list_id = $modelAnswerList->id;
                $valid = $modelAnswer->validate();
                if (!$valid) break;
                if (isset($groupsOfModelsAnswerVariants[$modelAnswer->question_id])
                    && isset($groupsOfModelsAnswerVariants[$modelAnswer->question_id][$modelAnswer->answer])
                ) {
                    $score = $groupsOfModelsAnswerVariants[$modelAnswer->question_id][$modelAnswer->answer]->scores;
                    $sumScores += $score;
                }
            }
            //если все ответы на вопросы корректны, сохраняем вопросынй лист и ответы
            $transaction = \Yii::$app->db->beginTransaction();
            if ($valid) {
                $modelAnswerList->date = date('Y-m-d');
                $modelAnswerList->status = 'answered';
                $modelAnswerList->scores = $sumScores;
                $modelAnswerList->author = Yii::$app->user->identity->username;
                if (($valid = $modelAnswerList->validate()) && $modelAnswerList->save()) {
                    foreach ($modelsAnswer as $modelAnswer) if (!$valid = $modelAnswer->save()) break;
                } else {
                    $transaction->rollBack();
                }
                if ($valid) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $modelAnswerList->id]);
                }
            }
            //  если были ошибки то перенаправляем на изменение
            $transaction->rollBack();
            return $this->render('create', [
                'modelQuestionList' => $modelQuestionList,
                'modelAnswerList' => $modelAnswerList,
                'modelsQuestion' => $modelsQuestion,
            ]);
        }
        return $this->render('create', [
            'modelQuestionList' => $modelQuestionList,
            'modelAnswerList' => $modelAnswerList,
            'modelsQuestion' => $modelsQuestion,
        ]);
    }

    /**
     * @return string
     *
     * Отображает чистую форму для заполнения со списком вопросов
     */
    public function actionUpdate($id)
    {

        $modelAnswerList = $this->findAnswerListModel($id);
        $modelAnswerList->scenario = 'write-test';

        $modelQuestionList = $modelAnswerList->questionList;
        $modelsQuestion = $modelQuestionList->questions;

        $modelsAnswer = $modelAnswerList->answers;

        // если форма отправлена.
        if($postData = Yii::$app->request->post())
        {
            $valid = $modelQuestionList->validate();
            $answerIds = ArrayHelper::getColumn($postData['Answer'], 'id');
            $modelsAnswer = Answer::findAll($answerIds);
            Model::loadMultiple($modelsAnswer, $postData);
            //если был удален один вопрос, на который ранее отвечали
            $oldAnswerIDs = ArrayHelper::map($modelAnswerList->answers, 'id', 'id');
            $deletedAnswerIDs = array_diff($oldAnswerIDs, array_filter($answerIds));

            // если был добавлен еще один вопрос, то создадим пустой и добавим
            foreach($postData['Answer'] as $answer) {
                if(!$answer['id']){
                    $modelAnswerVariant = new Answer();
                    $modelAnswerVariant->load(['Answer'=>$answer]);
                    $modelsAnswer[] = $modelAnswerVariant;
                }
            }
            // сумма очков
            $sumScores = 0;
            $groupsOfModelsAnswerVariants = $this->getAllAnswerVariantsGroupByQuestionId($modelAnswerList->question_list_id);
            foreach ($modelsAnswer as $modelAnswer) {
                $modelAnswer->question_list_id = $modelAnswerList->question_list_id;
                $modelAnswer->answer_list_id = $modelAnswerList->id;
                $valid = $modelAnswer->validate();
                if (!$valid) break;
                if (isset($groupsOfModelsAnswerVariants[$modelAnswer->question_id])
                    && isset($groupsOfModelsAnswerVariants[$modelAnswer->question_id][$modelAnswer->answer])
                ) {
                    $score = $groupsOfModelsAnswerVariants[$modelAnswer->question_id][$modelAnswer->answer]->scores;
                    $sumScores += $score;
                }
            }
            $transaction = \Yii::$app->db->beginTransaction();
            if($valid) {
                try {
                    $flag = false;
                    $modelAnswerList->scores = $sumScores;

                    if($modelAnswerList->save())foreach($modelsAnswer as $indexModelAnswer => $modelAnswer) {
                        if (! ($flag = $modelAnswer->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                    // удаляем вопросы, которые могли быть удалены в конструкторе
                    if($deletedAnswerIDs){
                        $del = Answer::findAll(array_values($deletedAnswerIDs));
                        foreach($del as $model) $model->delete();
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelAnswerList->id]);
                    }else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'modelQuestionList' => $modelQuestionList,
            'modelAnswerList' => $modelAnswerList,
            'modelsQuestion' => $modelsQuestion,
            'modelsAnswer' => $modelsAnswer,
        ]);
    }

    /**
     * Finds the QuestionList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return QuestionList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findQuestionListModel($id)
    {
        if (($model = QuestionList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getAllAnswerVariantsGroupByQuestionId($question_list_id)
    {
        $result = [];
        $modelQuestionList = Question::findAll(['list_id'=>$question_list_id]);
        $ids = array_values(ArrayHelper::map($modelQuestionList, 'id','id'));
        $answerVariants = AnswerVariant::findAll(['question_id'=>$ids]);
        foreach($answerVariants as $answerVariant) {
            $result[$answerVariant->question_id][$answerVariant->id] = $answerVariant;
        }
        return $result;
    }

    /*
     * @return app\modules\unicred\questionlist\models\AnswerList $model
     */
    protected function findAnswerListModel($answer_list_id)
    {
        $model = AnswerList::findOne($answer_list_id);
        return $model;

    }

}
