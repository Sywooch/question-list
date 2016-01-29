<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $modelQuestion app\modules\unicred\models\Question */
/* @var $form yii\widgets\ActiveForm; */
/* @var $questionIndex int; */
/* @var $questionListId int; */
/* @var $answerListId int; */
/* @var $modelAnswer; */
?>
    <?/*= $form->field($modelQuestion, "[{$modelQuestion->id}]quest_text")->textArea(['maxlength' => true]) */
    $modelAnswer->question_id = $modelQuestion->id;
    $modelAnswer->question_type = $modelQuestion->type;
    $modelAnswer->question_text = $modelQuestion->quest_text;
    $modelAnswer->question_list_id = $questionListId;
    $modelAnswer->answer_date = (new DateTime())->format('Y-m-d');
    $modelAnswer->answer_list_id = $answerListId;
    ?>
<div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"><?=$modelQuestion->quest_text;?></i>
            <div class="clearfix"></div>
        </div>
    <div class="panel-body container-questions">
        <div class="form-group">
            <? if (!$modelAnswer->isNewRecord)echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]id");?>
            <?= Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]question_id");?>
            <?= Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]question_type");?>
            <?= Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]question_text");?>
            <?= Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]question_list_id");?>
            <?= Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]answer_date");?>
            <?= Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]answer_list_id");?>
            <? switch($modelQuestion->type) {
                case 'multiple' :
                    $answerVariants = [];
                    foreach ($modelQuestion->answerVariants as $av) $answerVariants[$av->answer] = $av->answer;
                    echo $form->field($modelAnswer, "[{$questionIndex}]answer")
                        ->dropDownList($answerVariants,[$modelAnswer->answer => ['selected'=>'selected']]);
                    break;
                case 'boolean' :
                    echo $form->field($modelAnswer, "[{$questionIndex}]answer")
                        ->radioList(['Да'=>'Да','Нет'=>'Нет']);
                    break;
                default :
                    echo $form->field($modelAnswer, "[{$questionIndex}]answer")->textArea(['maxlength' => true]);
                    break;
            }?>
        </div>
    </div>
</div>
