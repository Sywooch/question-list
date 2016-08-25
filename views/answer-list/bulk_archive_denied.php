<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $modelsCantBeArchive array */
?>
<div class="answer-list-delete">
    <p> Невозможно перенести в архив опросы : </p>
    <?= GridView::widget([
        'dataProvider' => $modelsCantBeArchive,
        'columns' => [
            'id',
            'questionList.title',
            'statusName',
            'officeName',
        ],
    ]); ?>
</div>
