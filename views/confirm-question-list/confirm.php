<?php

use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\AnswerList */
/* @var $answersOnList array */

$this->title = "Ответы #{$model->id} на Чек-лист \"{$model->questionList->title}\" отделения {$model->officeName}";
$moduleID = \Yii::$app->controller->module->id;
$this->params['breadcrumbs'][] = ['label' => 'Система опросов', 'url' => ['/'.$moduleID]];
$this->params['breadcrumbs'][] = ['label' => 'Чек-листы', 'url' => ['confirm-question-list/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="answer-list-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'questionList.title',
            'officeName',
            'date_from',
            'date_to',
            'scores',
            'statusName',
            'date',
        ],
    ]) ?>

    <h4> Ответы : </h4>
    <?if($model->status !=='clear'):?>
        <?= GridView::widget([
            'dataProvider' => $answersDataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'question.quest_text',
                'question.questionTypeName',
                [
                    'class' => 'yii\grid\DataColumn',
                    'attribute' => 'answer',
                    'format' => 'raw',
                    'value' => function($model) use($answersOnList) {
                        switch($model->question->type) {
                            case 'select_one':
                            case 'select_multiple':
                            case 'radio':
                                if(isset($answersOnList[$model->question->id]))
                                    return implode(';',$answersOnList[$model->question->id]);
                                break;
                            case 'checkbox':
                                $class = $model->answer ? 'ok' : 'remove';
                                return "<span class=\"glyphicon glyphicon-{$class}\"></span>";
                                break;
                            case 'text':
                            default:
                                return $model->answer;
                        }
                    }
                ],
                'answer_comment',
            ],
        ]); ?>
    <? else: ?>
        <p> Ответы на вопросный лист еще не даны отделением.</p>
    <?endif;?>

</div>
