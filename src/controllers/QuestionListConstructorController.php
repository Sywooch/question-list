<?php

namespace igribov\questionlist\controllers;

use Yii;
use igribov\questionlist\models\QuestionList;
use igribov\questionlist\models\QuestionListSearch;
use igribov\questionlist\controllers\ModuleBaseController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use igribov\questionlist\models\Question;
use igribov\questionlist\models\Model;
use igribov\questionlist\models\AnswerVariant;


/**
 * QuestionListController implements the CRUD actions for QuestionList model.
 */
class QuestionListConstructorController extends Controller
{
    /**
     * Lists all QuestionList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuestionListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single QuestionList model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new QuestionList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // TODO : Провести рефакторинг
        $modelQuestionList = new QuestionList();
        // добавляем в объект класса QuestionList данные, пришедние из формы
        if ($modelQuestionList->load(Yii::$app->request->post())) {
            // создаются
            $modelsQuestion = Model::createMultiple(Question::classname());
            $modelsAnswerVariant = [];
            Model::loadMultiple($modelsQuestion, Yii::$app->request->post());

            $valid = $modelQuestionList->validate();
            $valid = Model::validateMultiple($modelsQuestion) && $valid;
            $postAnswerVariants = Yii::$app->request->post()['AnswerVariant'];
            if (isset($postAnswerVariants[0])) {
                foreach ($postAnswerVariants as $indexQuestion => $answers) {

                    if($modelsQuestion[$indexQuestion]->type === 'multiple') {
                        foreach ($answers as $indexAnswer => $answer) {
                            $data = [];
                            $data['AnswerVariant'] = $answer;
                            $modelAnswerVariant = new AnswerVariant;
                            $modelAnswerVariant->load($data);
                            $modelsAnswerVariant[$indexQuestion][] = $modelAnswerVariant;
                        }
                    }
                }
            }
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $modelQuestionList->save(false)) {

                        foreach ($modelsQuestion as $indexQuestion => $modelQuestion) {

                            if (! ($flag = $modelQuestion->save(false))) {
                                $transaction->rollBack();
                                break;
                            }else {
                                $modelQuestion->link('questionLists', $modelQuestionList);
                            }

                            if (isset($modelsAnswerVariant[$indexQuestion]) && is_array($modelsAnswerVariant[$indexQuestion])) {
                                foreach ($modelsAnswerVariant[$indexQuestion] as $modelAnswerVariant) {
                                    if(!$modelAnswerVariant->answer) continue;

                                    $modelAnswerVariant->question_id = $modelQuestion->id;
                                    if (!($flag = $modelAnswerVariant->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelQuestionList->id]);
                    }else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

        } else {
            return $this->render('create', [
                'modelQuestionList' => $modelQuestionList,
                'modelsQuestion' => (empty($modelsQuestions)) ? [new Question()] : $modelsQuestions,
                'modelsAnswerVariant' => (empty($modelsAnswerVariant)) ? [[new AnswerVariant]] : $modelsAnswerVariant,
            ]);

        }
    }

    /**
     * Updates an existing QuestionList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelQuestionList = $this->findModel($id);
        $modelsQuestion = $modelQuestionList->questions;
        $modelsAnswerVariant = [];
        $oldAnswerVariants = [];

        if (!empty($modelsQuestion)) {
            foreach ($modelsQuestion as $indexQuestion => $modelQuestion) {
                $answerVariants = $modelQuestion->answerVariants;
                $modelsAnswerVariant[$indexQuestion] = $answerVariants;
                $oldAnswerVariants = ArrayHelper::merge(ArrayHelper::index($answerVariants, 'id'), $oldAnswerVariants);
            }
        }

        if ( $modelQuestionList->load(Yii::$app->request->post()) )
        {
            $oldQuestionIDs = ArrayHelper::map($modelsQuestion, 'id', 'id');
            $modelsQuestion = [];
            $postQuestionData = Yii::$app->request->post()['Question'];
            if($postQuestionData)foreach($postQuestionData as $q) {
                $question = new Question();
                if($q['id']) {
                    $actualIds[$q['id']] = $q['id'];
                    $question->id = $q['id'];
                }
                $modelsQuestion[] = $question;
            }

            Model::loadMultiple($modelsQuestion, Yii::$app->request->post());
            $deletedQuestionIDs = array_diff($oldQuestionIDs, array_filter(ArrayHelper::map($modelsQuestion, 'id', 'id')));

            $valid = $modelQuestionList->validate();
            $valid = Model::validateMultiple($modelsQuestion) && $valid;

            $answerVariantsIDs = [];
            $postAnswersData = Yii::$app->request->post()['AnswerVariant'];

            if (isset($postAnswersData[0])) {
                foreach ($postAnswersData as $indexQuestion => $answerVariants) {
                    $answerVariantsIDs = ArrayHelper::merge($answerVariantsIDs, array_filter(ArrayHelper::getColumn($answerVariants, 'id')));
                    foreach ($answerVariants as $indexAnswerVariant => $answerVariant) {
                        if(!$answerVariant['answer']) continue;
                        $data['AnswerVariant'] = $answerVariant;
                        $modelAnswerVariant = (isset($answerVariant['id']) && isset($oldAnswerVariants[$answerVariant['id']])) ? $oldAnswerVariants[$answerVariant['id']] : new AnswerVariant();
                        $modelAnswerVariant->load($data);
                        $modelsAnswerVariant[$indexQuestion][$indexAnswerVariant] = $modelAnswerVariant;

                        $valid = $modelAnswerVariant->validate();
                    }
                }
            }

            $oldAnswerVariantsIDs = ArrayHelper::getColumn($oldAnswerVariants, 'id');
            $deletedAnswerVariantsIDs = array_diff($oldAnswerVariantsIDs, $answerVariantsIDs);

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelQuestionList->save(false)) {

                        if (! empty($deletedAnswerVariantsIDs)) {
                            AnswerVariant::deleteAll(['id' => $deletedAnswerVariantsIDs]);
                        }

                        if (!empty($deletedQuestionIDs)) {
                            foreach($deletedQuestionIDs as $q_id) {
                                Question::findOne($q_id)->unlink('questionLists', $modelQuestionList);
                                Question::findOne($q_id)->delete();
                            }
                        }
                        foreach ($modelsQuestion as $indexQuestion => $modelQuestion) {

                            if($modelQuestion->id) {
                                $model = Question::findOne($modelQuestion->id);
                                $data = $modelQuestion->toArray();
                                if($model){
                                    $model->attributes = $data;
                                    $modelQuestion = $model;
                                }
                            }
                            if (! ($flag = $modelQuestion->save()) ) {
                                $transaction->rollBack();
                                break;
                            }
                            if (isset($modelsAnswerVariant[$indexQuestion]) && is_array($modelsAnswerVariant[$indexQuestion])) {
                                foreach ($modelsAnswerVariant[$indexQuestion] as $indexAnswerVariant => $modelAnswerVariant) {
                                    if($modelsQuestion[$indexQuestion]->type !== 'multiple') {
                                        $modelAnswerVariant->delete();
                                    } else {
                                        $modelAnswerVariant->question_id = $modelQuestion->id;
                                        if (!($flag = $modelAnswerVariant->save(false))) {
                                            break;
                                        }
                                    }
                                }
                            }
                            if(!$actualIds[$modelQuestion->id])
                                $modelQuestion->link('questionLists', $modelQuestionList);
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelQuestionList->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
                'modelQuestionList' => $modelQuestionList,
                'modelsQuestion' => (empty($modelsQuestion)) ? [new Question] : $modelsQuestion,
                'modelsAnswerVariant' => (empty($modelsAnswerVariant)) ? [[new AnswerVariant]] : $modelsAnswerVariant,
            ]);

    }

    /**
     * Deletes an existing QuestionList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the QuestionList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return QuestionList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = QuestionList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
