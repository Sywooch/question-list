<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelQuestionList igribov\questionlist\models\QuestionList */
/* @var $modelAnswerList igribov\questionlist\models\AnswerList */
/* @var $modelsQuestion igribov\questionlist\models\Question */
/* @var $modelsAnswer igribov\questionlist\models\Answer */

$this->title = $modelAnswerList->id;
$moduleID = \Yii::$app->controller->module->id;$this->params['breadcrumbs'][] = ['label' => 'Система опросов', 'url' => ['/'.$moduleID]];
$this->params['breadcrumbs'][] = ['label' => 'Мои опросные листы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="question-list-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelQuestionList' =>  $modelQuestionList,
        'modelAnswerList' =>  $modelAnswerList,
        'modelsQuestion' =>  $modelsQuestion
    ]) ?>



</div>
