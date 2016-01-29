<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel igribov\questionlist\models\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список опросных листов';
$this->params['breadcrumbs'][] = ['label' => 'Система опросов', 'url' => ['/questionlist/']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-list-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => require(__DIR__.'/_columns.php'),
        'toolbar'=> [
              ['content'=>
                  Html::a('<i class="glyphicon glyphicon-plus">Создать</i>', ['create'],
                  ['role'=>'modal-remote','title'=> 'Создать опрос','class'=>'btn btn-default']).
                  Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                  ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Обновить']).
                  '{toggleData}'
              ],
          ],
          'striped' => true,
          'condensed' => true,
          'responsive' => true,
           'panel' => [
               'type' => 'primary',
               'heading' => '<i class="glyphicon glyphicon-list"></i> Конструктор опросов',
               'before'=>'<em>* Потяните за границу колонки, чтобы изменить ее размер.</em>',
               'after'=>BulkButtonWidget::widget([
                           'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                               ["bulk-delete"] ,
                               [
                                   "class"=>"btn btn-danger btn-xs",
                                   'role'=>'modal-remote-bulk',
                                   'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                   'data-request-method'=>'post',
                                   'data-confirm-title'=>'Вы уверены?',
                                   'data-confirm-message'=>'Вы уверены, что хотите удалить выделенные записи?'
                               ]),
                       ]).
                       '<div class="clearfix"></div>',
           ],
    ]); ?>

</div>
