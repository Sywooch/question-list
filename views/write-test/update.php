<?php
/* @var $this yii\web\View */
/* @var $modelQuestionList app\modules\unicred\questionlist\models\QuestionList */
/* @var $modelAnswerList app\modules\unicred\questionlist\models\AnswerList */
/* @var $modelsQuestion app\modules\unicred\questionlist\models\Question */
/* @var $modelsAnswer app\modules\unicred\questionlist\models\Answer */
$this->title = 'ID#'.$modelAnswerList->id;
$this->params['breadcrumbs'][] = ['label' => 'Система опросов', 'url' => ['/'.$moduleID]];
$this->params['breadcrumbs'][] = ['label' => 'Мои опросные листы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="question-list-view">

<?= $this->render('_form', [
    'modelQuestionList' =>  $modelQuestionList,
    'modelAnswerList' =>  $modelAnswerList,
    'modelsQuestion' =>  $modelsQuestion,
    'modelsAnswer' =>  $modelsAnswer,
]) ?>



</div>
