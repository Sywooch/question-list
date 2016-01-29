<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;

return [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'class' => 'kartik\grid\ExpandRowColumn',
        'attribute' => 'name',
        'value' => function($model,$key,$index,$column) {
            return GridView::ROW_COLLAPSED;
        },
        'detail' => function($model,$key,$index,$column) {
            return Yii::$app->controller->renderPartial('_expand-row_details',['model'=>$model]);
        },
        'expandOneOnly' => true,
        'headerOptions' => ['class' => 'kartik-sheet-style'],
    ],
    'id',
    'title',
    'questionsCount',
    ['class' => 'yii\grid\ActionColumn'],
];