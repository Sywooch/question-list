<?php

namespace app\modules\unicred\questionlist\models;

use Yii;
use app\modules\unicred\questionlist\models\Question;
use yii\helpers\Json;


/**
 * This is the model class for table "answers_variants".
 *
 * @property integer $id
 * @property integer $question_id
 * @property string $answer
 * @property integer $scores
 * @property string $html_attributes
 */
class AnswerVariant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questionlist_answers_variants';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id'], 'required'],
            [['scores','answer'], 'required', 'whenClient'=>'function(){
                var value = $("#question-type").val();
                return ["select_one","radio","select_multiple"].indexOf(value)!=-1;
            }'],
            [['question_id'], 'integer'],
            //[['html_attributes'], 'string', 'max'=>1000],
            //[['html_attributes'], 'safe'],
            [['scores'], 'integer']
        ];
    }

    /*public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['form'] = ['answer','question_id','scores'];
        return $scenarios;
    }*/

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
            'question_id' => 'ID Вопроса',
            'answer' => 'Ответ',
            'scores' => 'Баллы',
        ];
    }

    public function getHtmlAttributes()
    {
        try {
            return Json::decode($this->html_attributes);
        } catch(\yii\base\InvalidParamException $e) {
            return [];
        }
    }

    public function setHtmlAttributes($attributes)
    {
        if(is_array($attributes)) $this->html_attributes = [];
        $this->html_attributes = Json::encode($attributes);
    }

    public function load($data, $formName = null)
    {
        if($res = parent::load($data, $formName)){
            $this->htmlAttributes = $data['htmlAttributes'];
        }
    }

    public function getHtml_attributes_show_comment()
    {
        var_dump($this->html_attributes);
    }
}
