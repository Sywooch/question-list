<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $modelsCantBeDelete yii\data\ArrayDataProvider */
?>
<div class="answer-list-delete">
    <p> Невозможно удалить опросы : </p>
    <?= GridView::widget([
        'dataProvider' => $modelsCantBeDelete,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
        ],
    ]); ?>
</div>
