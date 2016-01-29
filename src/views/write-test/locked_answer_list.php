<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $modelAnswerList igribov\questionlist\models\AnswerList */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Answer Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-list-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'question_text',
            'question_type',
            'answer',
        ],
    ]) ?>

</div>

