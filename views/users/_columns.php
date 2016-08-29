<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'profile_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'officeName',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'regionName',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'roleName',
        'filter' => app\modules\unicred\questionlist\models\Users::getRoles(),
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Просмотр','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Изменить', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Подтверждение удаления',
                          'data-confirm-message'=>'Вы уверены, что хотите удалить?'],
    ],

];   