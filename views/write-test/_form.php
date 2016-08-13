<?php
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use app\modules\unicred\questionlist\models\Answer;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelQuestionList app\modules\unicred\questionlist\models\QuestionList */
/* @var $modelsQuestion app\modules\unicred\questionlist\models\Question */
/* @var $modelsAnswer app\modules\unicred\questionlist\models\Answer */
/* @var $modelAnswerList app\modules\unicred\questionlist\models\AnswerList */

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
        <?php 
            foreach($modelsQuestion as $questionIndex => $q) {
                echo $this->render('_one-question', [
                    'modelQuestion' =>  $q,
                    'modelAnswer' =>  (isset($modelsAnswer) && isset($modelsAnswer[$questionIndex])) ?
                        $modelsAnswer[$questionIndex] :
                        new Answer(),
                    'questionIndex' =>  $questionIndex,
                    'form' => $form,
                    'questionListId' => $modelQuestionList->id,
                    'answerListId' => $modelAnswerList->id,
                ]);
            }
        ?>
    </div>

</div>
<div class="form-group">
    <?= Html::submitButton($modelQuestion->isNewRecord ?
        'Готово' : 'Обновить',
        ['class' => 'btn btn-primary','submit-button']) ?>
</div>

<?php ActiveForm::end(); ?>
</div>