<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\modules\unicred\questionlist\models\Answer;

/* @var $this yii\web\View */
/* @var $modelAnswerList app\modules\unicred\questionlist\models\AnswerList */

$this->title = "Ответы на опрос '$model->list_name'";
$this->registerCss('
.comment {
    border : 1px solid red ;
    border-radius : 5px;
    background-color : white;
    padding : 5px;
    margin : 5px;
}
');

?>
<div class="answer-list-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?if($model->comment):?>
    <div class="comment">
        <p><i>Комментарий : <?=$model->comment?></i></p>
    </div>
    <?endif?>

    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => Answer::find()->where(['answer_list_id'=>$model->id]),
        ]),
        //'filterModel' => false,
        'columns' => [
            'question_text',
            'question_type',
            'answer',
            'answer_comment',
        ],
    ]) ?>

</div>

