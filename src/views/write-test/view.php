<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $modelAnswerList igribov\questionlist\models\AnswerList */
/* @var $dataProvider igribov\questionlist\models\AnswerList */

$this->title = $modelAnswerList->id;
$moduleID = \Yii::$app->controller->module->id;$this->params['breadcrumbs'][] = ['label' => 'Система опросов', 'url' => ['/'.$moduleID]];
$this->params['breadcrumbs'][] = ['label' => 'Мои опросные листы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-list-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <? if($modelAnswerList->id): ?>
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $modelAnswerList->id], ['class' => 'btn btn-primary']) ?>
        <?/*= Html::a('Delete', ['delete', 'id' => $modelAnswerList->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>
    </p>
    <? endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'question_text',
            'question_type',
            'answer',
            'answer_comment',
        ],
    ]) ?>

</div>
