<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model igribov\questionlist\models\QuestionList */
/* @var $modelsQuestion igribov\questionlist\models\Question */
/* @var $modelQuestionList igribov\questionlist\models\QuestionList */
/* @var $modelsAnswerVariant igribov\questionlist\models\AnswerVariant */

$this->title = 'Создать опросный лист';
$moduleID = \Yii::$app->controller->module->id;$this->params['breadcrumbs'][] = ['label' => 'Система опросов', 'url' => ['/'.$moduleID]];
$this->params['breadcrumbs'][] = ['label' => 'Список опросных листов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-list-create">

    <h1><?= Html::encode($this->title);?></h1>
    <?= $this->render('_form', [
        'modelsQuestion' =>  $modelsQuestion,
        'modelQuestionList' =>  $modelQuestionList,
        'modelsAnswerVariant' =>  $modelsAnswerVariant,
    ]) ?>

</div>
