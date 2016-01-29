<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\models\QuestionList */
/* @var $modelsQuestion app\modules\unicred\models\Question */
/* @var $modelQuestionList app\modules\unicred\models\QuestionList */
/* @var $modelsAnswerVariant app\modules\unicred\models\AnswerVariant */

$this->title = 'Создать опросный лист';
$this->params['breadcrumbs'][] = ['label' => 'Система опросов', 'url' => ['/unicred/']];
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
