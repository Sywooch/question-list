<?php

use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model igribov\questionlist\models\AnswerList */
?>
<div class="answer-list-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'list_name',
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
                'question_text',
                'answer',
                'answer_comment',
                'scores',
            ],
        ]); ?>
    <? else: ?>
        <p> Ответы на вопросный лист еще не даны отделением.</p>
    <?endif;?>

</div>
