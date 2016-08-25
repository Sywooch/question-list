<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\modules\unicred\questionlist\models\Office;
use app\modules\unicred\questionlist\models\AnswerList;
use yii\helpers\Html;

return [
    /*[
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],*/
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'questionList.title',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_from',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_to',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'statusName',
        'filter' => AnswerList::getStatusList(),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'officeName',
        'filter' => ArrayHelper::map(Office::find()->all(),'id','name'),
    ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'scores',
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'author',
    ],
    [
        'class' => '\kartik\grid\ActionColumn',
        'template' => '{confirm}',
        'buttons'=>[
            'confirm' => function($url, $model) {
                return Html::a(
                    '<span class="glyphicon glyphicon-list"></span>',
                    Url::toRoute(['confirm','id'=>$model->id]));

            }
        ],
    ],

];

