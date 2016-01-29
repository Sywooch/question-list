<?php

namespace igribov\questionlist\models;

use Yii;
use igribov\questionlist\models\Question;


/**
 * This is the model class for table "answers_variants".
 *
 * @property integer $id
 * @property integer $question_id
 * @property string $answer
 */
class AnswerVariant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answers_variants';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id','answer'], 'required',"on"=>"form"],
           /* [['question_id'], 'required'],*/
            [['question_id'], 'integer'],
            [['answer'], 'string', 'max' => 255]
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['form'] = ['answer','question_id'];
        return $scenarios;
    }

    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'answer' => 'Answer',
        ];
    }
}
