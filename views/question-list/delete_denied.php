<?php

use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\QuestionList */
/* @var $modelsAnswerLists array */

?>
<div class="answer-list-delete">
    <p> Данный опрос уже назначен на отделения, указанные в списке ниже. Удалить невозможно. </p>
    <?= GridView::widget([
        'dataProvider' => $modelsAnswerLists,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'officeName',
            'statusName',
            'author',
            [
                'class'=>'yii\grid\DataColumn',
                'attribute'=>'url',
                'format'=>'raw',
                'value'=> function($model){
                    return Html::a('Просмотр', ['answer-list/view','id'=>$model->id],["target"=>"_blank"]);
                },
            ],
        ],
    ]); ?>
</div>

