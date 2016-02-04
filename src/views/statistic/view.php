<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AnswerList */
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
            'do_id',
            'list_name',
            'scores',
        ],
    ]) ?>

</div>
