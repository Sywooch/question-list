<?php
use yii\helpers\Url;

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
        'attribute'=>'title',
        'headerOptions'=>['data'=>['resizable-column-id'=>'title']],
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'template' => '{view} {update} {delete}',
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
            if($action=='view') return Url::to(['question/index','list_id'=>$key]);
            return Url::to([$action,'id'=>$key]);
        },
        //'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Переименовать', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Подтверждение удаления',
                          'data-confirm-message'=>'Вы уверены, что хотите удалить?'],
    ],
];   