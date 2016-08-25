<?php

use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $modelAnswerList app\modules\unicred\questionlist\models\AnswerList */
/* @var $noAjax boolean */

if($noAjax) {
    $this->title = $modelAnswerList->id;
    $this->params['breadcrumbs'][] = ['label' => 'Назначенные чек-листы', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}
?>
<div class="answer-list-update">

    <? echo DetailView::widget([
        'model' => $modelAnswerList,
        'attributes' => [
            'id',
            'questionList.title',
            'date_from',
            'date_to',
            'statusName',
            'officeName',
            'listName',
            'scores',
        ],
    ]) ?>
    <h4> Ответы : </h4>
    <?if($modelAnswerList->status !=='clear'):?>
        <? echo GridView::widget([
            'dataProvider' => new ArrayDataProvider([
                    'allModels' => $modelAnswerList->answers,
                ]),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'question.quest_text',
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'answer',
                    'format'=>'raw',
                    'value' => function($model) {
                        switch($model->question->type)
                        {
                            case 'select_one' :
                            case 'radio' :
                                foreach($model->question->answerVariants as $av) {
                                    if($av->id == $model->answer){
                                        return $av->answer;
                                    }
                                }
                                break;
                            case 'checkbox' :
                                return $model->answer ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>';
                                break;
                        }
                        return $model->answer;
                    },
                ],
            ],
        ]); ?>
    <? else: ?>
        <p> Ответы на опросный лист еще не даны отделением.</p>
    <?endif;?>

</div>
