<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $modelQuestion app\modules\unicred\questionlist\models\Question */
/* @var $form yii\widgets\ActiveForm; */
/* @var $questionIndex int; */
/* @var $questionListId int; */
/* @var $answerListId int; */
/* @var $modelAnswer; */
$this->registerJs('
function setScores(){
    var id = $(this).attr("id").slice(7, $(this).attr("id").indexOf("-answer")),
        value = $(this).val(),
        scores = $(this).find("option[value=\'"+value+"\']").attr("scores");
    $("input#answer-"+id+"-scores").val(scores);
}
$(".select_answer select").each(function(i,elemenet){
    setScores.call(elemenet);
});
$(".select_answer select").change(setScores);
');

$modelAnswer->question_id = $modelQuestion->id;
$modelAnswer->question_type = $modelQuestion->type;
$modelAnswer->question_text = $modelQuestion->quest_text;
$modelAnswer->question_list_id = $questionListId;
$modelAnswer->answer_date = (new DateTime())->format('Y-m-d');
$modelAnswer->answer_list_id = $answerListId;

?>
<div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"><?php echo $modelQuestion->quest_text;?></i>
            <div class="clearfix"></div>
        </div>
    <div class="panel-body container-questions">
        <div class="form-group">
            <?php if (!$modelAnswer->isNewRecord)echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]id");?>
            <?php echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]question_id");?>
            <?php echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]question_type");?>
            <?php echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]question_text");?>
            <?php echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]question_list_id");?>
            <?php echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]answer_date");?>
            <?php echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]answer_list_id");?>
            <?php echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]scores");?>
            <?php switch($modelQuestion->type) {
                case 'multiple' :
                    //$answerVariants = [];
                    $answerVariants = ['' => 'Выберите'];
                    foreach ($modelQuestion->answerVariants as $av) {
                        $answerVariants[$av->answer] = $av->answer;
                        $options[$av->answer] = ['scores' => $av->scores];
                    }
                    echo '<div class="select_answer">';
                    echo $form->field($modelAnswer, "[{$questionIndex}]answer")
                        ->dropDownList($answerVariants,['options'=>$options, $modelAnswer->answer => ['selected'=>'selected']]);
                    echo '</div>';
                    break;
                case 'boolean' :
                    echo $form->field($modelAnswer, "[{$questionIndex}]answer")
                        ->radioList(['Да'=>'Да','Нет'=>'Нет']);
                    break;
                default :
                    echo $form->field($modelAnswer, "[{$questionIndex}]answer")->textArea(['maxlength' => true]);
                    break;
            }?>
            <?php echo $form->field($modelAnswer, "[{$questionIndex}]answer_comment")->textArea(['maxlength' => true]);?>
        </div>
    </div>
</div>
