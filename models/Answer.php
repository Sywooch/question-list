<?php

namespace app\modules\unicred\questionlist\models;

use Yii;

/**
 * This is the model class for table "answers".
 *
 * @property integer $id
 * @property string $question_text
 * @property string $question_type
 * @property integer $question_id
 * @property string $profile_id
 * @property integer $question_list_id
 * @property string $answer_date
 * @property string $answer
 * @property string $answer_comment
 * @property integer $scores
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questionlist_answers';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answer_list_id','question_text', 'question_type', 'question_id', 'profile_id', 'question_list_id', 'answer_date', 'answer'], 'required'],
            [['id'], 'required','on'=>'update'],
            [['id', 'question_id', 'question_list_id','scores'], 'integer'],
            [['answer_date'], 'safe'],
            [['question_text', 'answer','answer_comment'], 'string', 'max' => 1000],
            [['question_type'], 'string', 'max' => 25],
            [['profile_id'], 'string', 'max' => 25],
            ['answer_comment', 'required','when'=>function(){
                return false;
            },'whenClient' =>'function(attribute, value){
                var requiredField = false;
                var questionField = $(attribute.input).parent(".question-comment")
                .siblings(".question-field").find("select,input[type!=hidden],textarea");
                switch(questionField.prop("tagName"))
                {
                    case "SELECT" :
                        requiredField = questionField.find("option:selected").attr("data-showcomment");
                    break;
                    case "INPUT" :
                        if($(questionField).attr("type")!="radio") break;
                        $(questionField).each(function(){
                            if($(this).prop("checked")){
                                requiredField = $(this).attr("data-showcomment")
                            }
                        });
                }
                return requiredField;
            }'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_text' => 'Текст впороса',
            'question_type' => 'Тип вопроса',
            'question_id' => 'Question ID',
            'profile_id' => 'Profile ID',
            'question_list_id' => 'Question List ID',
            'answer_date' => 'Дата ответа',
            'answer' => 'Ответ',
            'answer_comment' => 'Комментарий',
            'scores' => 'Баллы',
        ];
    }

}

