<?php

namespace app\modules\unicred\questionlist\models;

use Yii;


/**
 * This is the model class for table "question".
 *
 * @property integer $id
 * @property string $type
 * @property string $quest_text
 * @property integer $list_id
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
            [['type', 'quest_text','list_id'], 'required'],
            [['type'], 'string', 'max' => 50],
            [['quest_text', 'answer'], 'string', 'max' => 1000]
        ];
    }

    public function getQuestionList()
    {
        return $this->hasOne(QuestionList::className(), ['list_id' => 'id']);
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
    public function delete()
    {
        foreach($this->answerVariants as $model) $model->delete();
        parent::delete();
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
            'select_one'=>'Выбор одного варианта из списка вариантов',
            'select_multiple'=>'Выбор нескольких вариантов из списка вариантов',
            'radio'=>'Радио-кнопки',
            'checkbox'=>'Чек-бокс',
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
