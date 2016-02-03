<?php

namespace igribov\questionlist\controllers;
use Yii;
use igribov\questionlist\controllers\ModuleBaseController as Controller;
use igribov\questionlist\models\Model;
use igribov\questionlist\models\QuestionList;
use igribov\questionlist\models\UsersOffices;
use igribov\questionlist\models\Answer;
use igribov\questionlist\models\AnswerList;
use igribov\questionlist\models\WriteTestSearch;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;

/**
 * Class AnswerListController
 * @package igribov\questionlist\controllers
 * Класс для создания сущности список ответов на вопросный лист
 */
class WriteTestController extends Controller
{
    protected function getAccessToOffice($office_id)
    {
        return in_array($office_id,$this->getOffiсeIds(Yii::$app->user->identity->username));
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
        // если пользователь лезет не в свое ДО, на просмотр которого нет прав, то редирект.
        if(! $this->getAccessToOffice($modelAnswerList->do_id) )
        {
            Yii::$app->getResponse()->redirect(Url::toRoute(['write-test/index']));
        }

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

    /**
     * @param $profile_id
     * @return array
     * Возвращает массив ID отделений, где пользователь является управляющим
     */
    protected function getOffiсeIds($profile_id)
    {
        $modelsUsersOffices = UsersOffices::findAll([
            'profile_id' => $profile_id,
            'profile_office_role' => 'manager'
        ]);
        return ArrayHelper::map($modelsUsersOffices, 'office_id', 'office_id');
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

        /*if(! $this->getAccessToOffice($modelAnswerList->do_id) )
        {
            Yii::$app->getResponse()->redirect(Url::toRoute(['write-test/index']));
        }*/

        if($modelAnswerList->status !== 'clear')
            Yii::$app->getResponse()->redirect(Url::toRoute(['write-test/update','id'=>$modelAnswerList->id]));

        $modelQuestionList = $modelAnswerList->questionList;
        $modelsQuestion = $modelQuestionList->questions;

        // если форма отправлена.
        if($postData = Yii::$app->request->post())
        {
            $modelAnswerList->status = 'answered';

            $modelsAnswer = Model::createMultiple(Answer::classname(),[],$scenario=['scenario'=>'create']);
            Model::loadMultiple($modelsAnswer, $postData);
            $valid = $modelQuestionList->validate();
            $summScores = 0;
            foreach($modelsAnswer as $indexModelAnswer => $modelAnswer) {
                $summScores += $modelAnswer->scores;
                $modelAnswer->profile_id = Yii::$app->user->identity->username;
                $valid = $modelAnswer->validate() && $valid;
            }
            if($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $flag = false;
                    $modelAnswerList->scores = $summScores;
                    if($modelAnswerList->save())
                        foreach($modelsAnswer as $indexModelAnswer => $modelAnswer)
                        {
                            if (! ($flag = $modelAnswer->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
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
        $modelQuestionList = $modelAnswerList->questionList;
        $modelsQuestion = $modelQuestionList->questions;
        $modelsAnswer = $modelAnswerList->answers;

        /*if(! $this->getAccessToOffice($modelAnswerList->do_id) )
        {
            Yii::$app->getResponse()->redirect(Url::toRoute(['write-test/index']));
        }*/

        // если форма отправлена.
        if($postData = Yii::$app->request->post())
        {
            $valid = $modelQuestionList->validate();
            $summScores = 0;

            if(isset($postData['Answer'])) {
                $answerIds = ArrayHelper::getColumn($postData['Answer'], 'id');
                $modelsAnswer = Answer::findAll($answerIds);
                Model::loadMultiple($modelsAnswer, $postData);
            }
            $summScores = 0;
            foreach($modelsAnswer as $indexModelAnswer => $modelAnswer) {
                $summScores += $modelAnswer->scores;
                $modelAnswer->profile_id = Yii::$app->user->identity->username;
                $valid = $modelAnswer->validate() && $valid;
            }
            if($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $flag = false;
                    $modelAnswerList->scores = $summScores;
                    if($modelAnswerList->save())foreach($modelsAnswer as $indexModelAnswer => $modelAnswer) {
                        if (! ($flag = $modelAnswer->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
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

    protected function findAnswerListModel($answer_list_id)
    {
        if (($model = AnswerList::findOne($answer_list_id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
