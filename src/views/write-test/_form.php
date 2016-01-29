<?php
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use igribov\questionlist\models\Answer;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelQuestionList igribov\questionlist\models\QuestionList */
/* @var $modelsQuestion igribov\questionlist\models\Question */
/* @var $modelsAnswer igribov\questionlist\models\Answer */
/* @var $modelAnswerList igribov\questionlist\models\AnswerList */

?>

<div class="question-list-write">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<div class="padding-v-md">
    <div class="line line-dashed"></div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-envelope"></i><?=$modelQuestionList->title;?>
        <div class="clearfix"></div>
    </div>

    <div class="panel-body container-questions">
        <? foreach($modelsQuestion as $questionIndex => $q):?>
            <?= $this->render('_one-question', [
                'modelQuestion' =>  $q,
                'modelAnswer' =>  (isset($modelsAnswer) && isset($modelsAnswer[$questionIndex])) ? $modelsAnswer[$questionIndex] : new Answer(),
                'questionIndex' =>  $questionIndex,
                'form' => $form,
                'questionListId' => $modelQuestionList->id,
                'answerListId' => $modelAnswerList->id,
            ]); ?>
        <? endforeach;?>
    </div>

</div>
<div class="form-group">
    <?= Html::submitButton($modelQuestion->isNewRecord ? 'Готово' : 'Обновить', ['class' => 'btn btn-primary','submit-button']) ?>
</div>

<?php ActiveForm::end(); ?>
</div>