<?php

namespace app\modules\unicred\models;

use Yii;
use app\modules\unicred\models\Answer;

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
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answers';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['answer_list_id','question_text', 'question_type', 'question_id', 'profile_id', 'question_list_id', 'answer_date', 'answer'], 'required'],
            [['id'], 'required','on'=>'update'],
            [['id', 'question_id', 'question_list_id'], 'integer'],
            [['answer_date'], 'safe'],
            [['question_text', 'answer'], 'string', 'max' => 1000],
            [['question_type'], 'string', 'max' => 25],
            [['profile_id'], 'string', 'max' => 25],
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
        ];
    }

}
