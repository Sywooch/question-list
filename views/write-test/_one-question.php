<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use app\modules\unicred\questionlist\QuestionListWriteAsset as Asset;

Asset::register($this);

/* @var $this yii\web\View */
/* @var $modelQuestion app\modules\unicred\questionlist\models\Question */
/* @var $form yii\widgets\ActiveForm; */
/* @var $questionIndex int; */
/* @var $questionListId int; */
/* @var $answerListId int; */
/* @var $modelAnswer; */
/*$this->registerJs('
function setScores(){
    var id = $(this).attr("id").slice(7, $(this).attr("id").indexOf("-answer")),
        value = $(this).val(),
        scores = $(this).find("option[value=\'"+value+"\']").attr("scores");
    $("input#answer-"+id+"-scores").val(scores);
}
$(".select_answer select").each(function(i,element){
    setScores.call(element);
});
$(".select_answer select").change(setScores);
');*/

$modelAnswer->question_id = $modelQuestion->id;
$modelAnswer->question_type = $modelQuestion->type;
$modelAnswer->question_text = $modelQuestion->quest_text;
$modelAnswer->question_list_id = $questionListId;
$modelAnswer->answer_date = (new DateTime())->format('Y-m-d');
$modelAnswer->answer_list_id = $answerListId;

?>
<div>
    <h4><span class="label label-info">Вопрос №<?= ($questionIndex+1) ?></span></h4>
    <?php if(!in_array($modelQuestion->type,['checkbox'])):?>
    <div class="panel-heading">
        <i class="fa fa-envelope"><?php echo $modelQuestion->quest_text;?></i>
    </div>
    <?php endif; ?>
    <div class="panel-body container-questions">
        <div class="form-group one-question-group">
            <?php if (!$modelAnswer->isNewRecord)echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]id");?>
            <?php echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]question_id");?>
            <?php echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]question_type");?>
            <?php echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]question_text");?>
            <?php echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]question_list_id");?>
            <?php echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]answer_date");?>
            <?php echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]answer_list_id");?>
            <?php echo Html::activeHiddenInput($modelAnswer, "[{$questionIndex}]scores");?>
            <?php if(in_array($modelQuestion->type,['select_one','radio'])){
                $answerVariants = [];
                foreach ($modelQuestion->answerVariants as $av) {
                    $answerVariants[$av->answer] = $av->answer;
                    foreach($av->htmlAttributes as $attributeName => $attributeValue) {
                        if($attributeValue) $options[$av->answer]['data-'.$attributeName] = $attributeValue;
                    }
                    $options[$av->answer]['scores']= $av->scores;
                }
            }?>
            <?php switch($modelQuestion->type) {
                case 'select_one' :
                    echo $form->field($modelAnswer, "[{$questionIndex}]answer",['options'=>['class'=>'question-field']])
                        ->dropDownList($answerVariants,[
                            'options'=> $options,
                            'prompt' => 'Выберите ..',
                        ])->label(false);
                    break;
                case 'radio' :
                    $radioOptions = [];
                    foreach ($modelQuestion->answerVariants as $k => $av) {
                        foreach($av->htmlAttributes as $attributeName => $attributeValue) {
                            if($attributeValue) $radioOptions[$k]['data-'.$attributeName] = $attributeValue;
                        }
                        $radioOptions[$k]['scores']= $av->scores;
                    }
                    echo $form->field($modelAnswer, "[{$questionIndex}]answer",[
                        'options'=>['class'=>'question-field']])
                        ->radioList($answerVariants,[
                                'item'=> function($index, $label, $name, $checked, $value) use($radioOptions){
                                    $return = '<label class="modal-radio">';
                                    $return .= '<input type="radio" name="'.$name.'" value="'.$value.'" ';
                                    if($checked) $return .= 'checked ';
                                    foreach($radioOptions[$index] as $attributeName => $attributeValue) {
                                        if($attributeValue) $return.=' '.$attributeName.'="'.$attributeValue.'"';
                                    }
                                    $return .= '>';
                                    $return .= $label;
                                    $return .= '</label>';
                                    return $return;
                                }
                            ],
                            ['options'=>['class'=>'question-field'],
                        ])->label(false);
                    break;
                case 'checkbox' :
                    echo $form->field($modelAnswer, "[{$questionIndex}]answer",['options'=>['class'=>'question-field']])
                        ->checkbox(['scores'=> ($modelQuestion->answerVariants[0] ? $modelQuestion->answerVariants[0]->scores : 0),
                            'label'=>false])->label($modelQuestion->quest_text);
                    break;
                default :
                    echo $form->field($modelAnswer, "[{$questionIndex}]answer")->textArea(['maxlength' => true]);
                    break;
            }?>
            <?php echo $form->field($modelAnswer, "[{$questionIndex}]answer_comment",['options'=>['class'=>'question-comment','style'=>['display'=>'none']]])
                ->textArea(['maxlength' => true]);?>
        </div>
    </div>
</div>
<hr>
