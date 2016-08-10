<?php

use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\AnswerList */
?>
<div class="answer-list-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'question_list_id',
            'date_from',
            'date_to',
            'status',
            'officeName',
            'list_name',
            'scores',
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
                'question_type',
                'scores',
            ],
        ]); ?>
    <? else: ?>
        <p> Ответы на вопросный лист еще не даны отделением.</p>
    <?endif;?>

</div>
