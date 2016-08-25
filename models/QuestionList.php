<?php

namespace app\modules\unicred\questionlist\models;

use Yii;
use app\modules\unicred\questionlist\models\Question;
use app\modules\unicred\questionlist\models\AnswerList;

/**
 * This is the model class for table "question_list".
 *
 * @property integer $id
 * @property string $title
 */
class QuestionList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questionlist_question_list';
    }

    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['list_id' => 'id']);
    }

    public function getAnswerLists()
    {
        return $this->hasMany(AnswerList::className(), ['question_list_id' => 'id']);
    }

    public function getQuestionsCount()
    {
        return count($this->questions);
    }

    public function beforeDelete()
    {
        if(parent::beforeDelete()) {
          /* @var $al AnswerList*/
          array_filter(array_merge($this->answerLists, $this->questions), function($item){
              $item->questionListWasDelete();
          });
          $res = Yii::$app->db
              ->createCommand("DELETE FROM questionlist_questions_qlists WHERE list_id=:id")
              ->bindValue(':id',$this->id)
              ->execute();
          return true;
        } else {
          return false;
        }
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Список вопросов',
            'questionsCount' => 'Кол-во вопросов',
        ];
    }

}
