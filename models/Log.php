<?php

namespace app\models;

use Yii;

class Log extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'log';
    }

    public function rules()
    {
        return [
            [['user_id', 'news_id'], 'integer'],
            [['model'], 'string'],
            [['create_date'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'news_id' => 'News ID',
            'model' => 'Model',
            'create_date' => 'Create Date',
        ];
    }

    public function logIt($news) {
        $this->user_id = Yii::$app->user->id;
        $this->news_id = $news->id;
        $this->news_status = $news->status;
        $this->model = json_encode($news->attributes);
        $this->save();
    }
}
