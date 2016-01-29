<?php

namespace igribov\questionlist\models;

use Yii;

/**
 * This is the model class for table "answer_list".
 *
 * @property integer $id
 * @property integer $question_list_id
 * @property string $date_from
 * @property string $date_to
 * @property string $status
 * @property integer $do_id
 *
 */
class AnswerList extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer_list';
    }

    /**
     * @inheritdoc
     */
    public static function getStatusList()
    {
        return [
            'clear'=>'Ожидает заполнения',
            'answered'=>'Заполнен',
            'done' => 'Подтвержден',
            'archive' => 'Архив'
        ];
    }

    public function getStatusName()
    {
        return $this->getStatusList()[$this->status];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_list_id','list_name','date_from', 'date_to', 'do_id'], 'required'],
            [['question_list_id', 'do_id'], 'integer'],
            [['date_from', 'date_to','list_name'], 'safe'],
            [['status'], 'string', 'max' => 10],
            [['list_name'], 'string', 'max' => 50],
        ];
    }

    public function getQuestionList()
    {
        return $this->hasOne(QuestionList::className(), ['id' => 'question_list_id']);
    }

    public function getOfficeName()
    {
        return $this->office->name;
    }

    public function getOffice()
    {
        return $this->hasOne(Office::className(), ['id' => 'do_id']);
    }

    public function questionListWasDelete()
    {
        $this->status = 'archive';
        $this->save();
    }


    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['answer_list_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_list_id' => 'Список вопросов',
            'date_from' => 'Дата начала опроса',
            'date_to' => 'Дата окончания опроса',
            'status' => 'Статус опроса',
            'statusName' => 'Статус опроса',
            'do_id' => 'Отделение',
            'list_name' => 'Название',
            'officeName' => 'Отделение',
        ];
    }
}
