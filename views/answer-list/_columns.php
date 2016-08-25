<?php
use yii\helpers\Url;
use yii\helpers\Html;
/* @var $statusList array */

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
        'headerOptions'=>['data'=>['resizable-column-id'=>'CheckboxColumn', 'noresize'=>'']],
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
        'headerOptions'=>['data'=>['resizable-column-id'=>'SerialColumn', 'noresize'=>'']],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'questionList.title',
        'headerOptions'=>['data'=>['resizable-column-id'=>'question-list-title']],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_from',
        'headerOptions'=>['data'=>['resizable-column-id'=>'date_from']],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_to',
        'headerOptions'=>['data'=>['resizable-column-id'=>'date_to']],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'statusName',
        'filter' => $statusList,
        'headerOptions'=>['data'=>['resizable-column-id'=>'statusName']],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'officeName',
        'headerOptions'=>['data'=>['resizable-column-id'=>'officeName']],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'scores',
        'headerOptions'=>['data'=>['resizable-column-id'=>'scores']],
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'template' => '{view}{update}{delete}{archive}',
        'buttons' => [
            'update' => function($url, $model) {
                if($model->status != 'clear') return '';
                return Html::a(
                    '<span class="glyphicon glyphicon-pencil"></span>',
                    Url::toRoute(['update','id'=>$model->id]),
                    ['data-pjax'=>0,'role'=>'modal-remote','data-toggle'=>'tooltip']);

            },
            'archive' => function($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-book"></span>',
                    Url::toRoute(['archive','id'=>$model->id]),
                    [
                        'data-pjax'=>0,'role'=>'modal-remote','data-toggle'=>'tooltip',
                        'data-request-method' => 'post',
                        "title"=>"Удаление","data-confirm-title"=>"Подтвердите удаление",
                        "data-confirm-message"=>"Вы уверены, что хотите перенести в архив?",
                    ]);

            }
        ],
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Просмотр','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Редактирование', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удаление',
            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
            'data-request-method'=>'post',
            'data-toggle'=>'tooltip',
            'data-confirm-title'=>'Подтвердите удаление',
            'data-confirm-message'=>'Вы уверены, что хотите удалить?'],
    ],
];