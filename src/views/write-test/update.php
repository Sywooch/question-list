<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelQuestionList app\modules\unicred\models\QuestionList */
/* @var $modelAnswerList app\modules\unicred\models\AnswerList */
/* @var $modelsQuestion app\modules\unicred\models\Question */
/* @var $modelsAnswer app\modules\unicred\models\Answer */

$this->title = $modelAnswerList->id;
$this->params['breadcrumbs'][] = ['label' => 'Система опросов', 'url' => ['/unicred/']];
$this->params['breadcrumbs'][] = ['label' => 'Мои опросные листы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="question-list-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelQuestionList' =>  $modelQuestionList,
        'modelAnswerList' =>  $modelAnswerList,
        'modelsQuestion' =>  $modelsQuestion,
        'modelsAnswer' =>  $modelsAnswer,
    ]) ?>



</div>
