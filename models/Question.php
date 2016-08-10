<?php

namespace app\modules\unicred\questionlist\models;

use Yii;


/**
 * This is the model class for table "question".
 *
 * @property integer $id
 * @property string $type
 * @property string $quest_text
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questionlist_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'quest_text'], 'required'],
            [['type'], 'string', 'max' => 10],
            [['quest_text', 'answer'], 'string', 'max' => 1000]
        ];
    }


    public function getQuestionLists()
    {
        return $this->hasMany(QuestionList::className(), ['id' => 'list_id'])
            ->viaTable('questionlist_questions_qlists', ['question_id' => 'id']);
    }

    public function getAnswerVariants()
    {
        return $this->hasMany(AnswerVariant::className(), ['question_id' => 'id']);
    }

    public function getAnswerVariantsInline()
    {
        $res = '';
        foreach($this->answerVariants as $av) {
            $res.= $av->answer.';';
        }
        return $res;
    }


    /*protected function questionTypeValidation($attribute, $params){
        die();
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'questionTypeName' => 'Тип вопроса',
            'quest_text' => 'Текст вопроса',
            'answer' => 'Варианты ответа',
            'answerVariantsInline' => 'Варианты ответа',
        ];
    }

    public function questionListWasDelete()
    {
        $this->delete();
    }

    /**
     * Возвращает массив типов вопросов
     * @return array
     */
    public function getQuestionTypes()
    {
        return [
            'text' => 'Поле для ответа',
            'multiple'=>'Выбор из списка вариантов',
            //'boolean'=>'Да/Нет',
        ];
    }

    /**
     * Возвращает имя типа вопроса
     * @return string
     */
    public function getQuestionTypeName()
    {
        return $this->getQuestionTypes()[$this->type];
    }
}
