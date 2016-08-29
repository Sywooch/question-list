<?php

namespace app\modules\unicred\questionlist\models;

use Yii;

/**
 * This is the model class for table "questionlist_answers".
 *
 * @property integer $id
 * @property integer $question_id
 * @property integer $question_list_id
 * @property string $answer_date
 * @property string $answer
 * @property integer $answer_list_id
 * @property string $answer_comment
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
            [['question_id', 'question_list_id', 'answer_list_id'], 'required'],
            [['question_id', 'question_list_id', 'answer_list_id'], 'integer'],
            [['answer_date'], 'safe'],
            [['answer'],'required','when'=>function($model){
                return false;
            },
                /* Нужно определить, отображено ли поле в данный момент.*/
                'whenClient'=>'function(attribute, value){
                var linkedFieldQuestionId = $("#"+attribute.id)
                        .parents(".one-question-block")
                        .attr("data-visible-condition-linked-question-id");
                // смотрим от какого вопроса зависит нужно ли поле к заполнению или нет.
                if(!linkedFieldQuestionId) return true;
                // смотрим значение ответа связанного вопроса, при котором наше поле должно быть заполнено.
                var linkedFieldQuestionValue = $("#"+attribute.id)
                        .parents(".one-question-block")
                        .attr("data-visible-condition-linked-question-value");
                // ищем этот вопрос ан странице
                var linkedBlock = $(".one-question-block[data-question-id="+linkedFieldQuestionId+"]");
                if(!linkedBlock) return true;
                // смотрим каким значением заполнено поле, сначала ищем поле
                var linkedField = linkedBlock.find(".question-field").find("input[type!=hidden], select"),
                        linkedFieldValue;
                // если это чек-бокс, то значение зависит от того установлен он или нет.
                if(linkedField.prop("type")=="checkbox") linkedFieldValue = linkedField.prop("checked");
                else linkedFieldValue = linkedField.val();
                // Итого, если значение связанного поля соответствует тому, которое нужно для отображения нашего поля
                // То наше поле должно быть заполнено значением.
                return linkedFieldValue == linkedFieldQuestionValue;
             }'],
            [['answer', 'answer_comment'], 'string', 'max' => 1000],
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
            'question_id' => 'Question ID',
            'question_list_id' => 'Question List ID',
            'answer_date' => 'Дата ответа',
            'answer' => 'Ответ',
            'answer_list_id' => 'Answer List ID',
            'answer_comment' => 'Комментарий',
        ];
    }

    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id'=>'question_id']);
    }
}
