<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $statusList array */
return [
    ['class' => 'kartik\grid\SerialColumn'],
    'id',
    'questionList.title',
    'date_from',
    'date_to',
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'statusName',
        'filter' => $statusList,
    ],
    'officeName',
    'scores',
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{create} {view}',
        'buttons' => [
            'create' => function($url, $model) {
                if($model->status === 'archive') return;
                $action = $model->status === 'clear' ? 'create' : 'update';
                return Html::a(
                    '<span class="glyphicon glyphicon-play"></span>',
                    Url::toRoute(['write-test/'.$action,'id'=>$model->id]));
            },
            'view' => function($url, $model) {
                if($model->status === 'clear') return;
                return Html::a(
                    '<span class="glyphicon glyphicon-eye-open"></span>',
                    Url::toRoute(['write-test/view','id'=>$model->id]));
            }
        ],
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{send}',
        'buttons' => [
            'send' => function($url, $model) {
                if($model->status !== 'answered') return;
                return Html::a(
                    '<button>Отправить<span class="glyphicon glyphicon-share"></span></button>',
                    Url::toRoute(['write-test/send','id'=>$model->id]));
            }
        ],
    ],
];