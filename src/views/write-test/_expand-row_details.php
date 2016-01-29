<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\modules\unicred\models\Answer;

/* @var $this yii\web\View */
/* @var $modelAnswerList app\modules\unicred\models\AnswerList */

$this->title = "Ответы на опрос '$model->list_name'";
?>
<div class="answer-list-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => Answer::find()->where(['answer_list_id'=>$model->id]),
        ]),
        //'filterModel' => false,
        'columns' => [
            'question_text',
            'question_type',
            'answer',
        ],
    ]) ?>

</div>

