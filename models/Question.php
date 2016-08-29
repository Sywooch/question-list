<?php

namespace app\modules\unicred\questionlist\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "question".
 *
 * @property integer $id
 * @property string $type
 * @property string $quest_text
 * @property string $ordering
 * @property integer $list_id
 * @property string $visible_condition
 * @property string $visible_condition_value
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
            [['ordering'], 'number'],
            [['quest_text'], 'string', 'max' => 1000],
            [['visible_condition'], 'string', 'max' => 1000],
            [['visible_condition_value'], 'string', 'max' => 100],
            [['visible_condition_value'], 'required', 'when' => function($model){
                if(!$model->visible_condition)return false;
                $linkedQuestion = Question::findOne($model->visible_condition);
                if(!$linkedQuestion) throw new \NotFoundHttpException();
                switch($linkedQuestion->type){
                    case 'select_one':case 'select_multiple':case 'radio':case 'checkbox':
                        return true;
                    case 'text':default:
                        return false;
                }

            },'whenClient'=>'function(){return false;}'],
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

    public function getAnswerVariantsInline($glue = ';')
    {
        return implode($glue,ArrayHelper::map($this->answerVariants,'id','answer'));
    }
    public function delete()
    {
        foreach($this->answerVariants as $model) $model->delete();
        parent::delete();
    }

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
            'ordering' => 'Номер вопроса',
            'answer' => 'Варианты ответа',
            'answerVariantsInline' => 'Варианты ответа',
            'visible_condition' => 'Связанный вопрос',
            'visible_condition_value' => 'Ответ на связанный вопрос',
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
            'select_one'=>'Выбор одного из списка',
            //'select_multiple'=>'Множественный выбор',
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
