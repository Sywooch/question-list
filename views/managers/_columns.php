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
        'width' => '20px',
        'headerOptions'=>['data'=>['resizable-column-id'=>'SerialColumn', 'noresize'=>'']],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'profile_id',
        'headerOptions'=>['data'=>['resizable-column-id'=>'profile_id']],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'roleName',
        'headerOptions'=>['data'=>['resizable-column-id'=>'profile_office_role']],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'officeName',
        'headerOptions'=>['data'=>['resizable-column-id'=>'office_name']],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'regionName',
        'headerOptions'=>['data'=>['resizable-column-id'=>'regionName']],
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   