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
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view}{update}{delete}',
        'buttons' => [
            'update' => function($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-pencil"></span>',
                    Url::toRoute(['update','id'=>$model->id]));
            },
            'view' => function($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-list"></span>',
                    Url::toRoute(['question/index','list_id'=>$model->id]));
            },
            'delete' => function($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-trash"></span>',
                    Url::toRoute(['delete','id'=>$model->id]),
                    [
                        'data-confirm'=>'Вы уверены, что хотите удалить форму?',
                        'data-method' => 'post',
                    ]);
            }
        ],
    ],
];