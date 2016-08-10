<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\QuestionList */
/* @var $modelsQuestion app\modules\unicred\questionlist\models\Question */
/* @var $modelQuestionList app\modules\unicred\questionlist\models\QuestionList */
/* @var $modelsAnswerVariant app\modules\unicred\questionlist\models\AnswerVariant */

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
