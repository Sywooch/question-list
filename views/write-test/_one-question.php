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


$modelAnswer->question_id = $modelQuestion->id;
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
            <?php echo $form->field($modelAnswer, "[{$questionIndex}]question_id")->hiddenInput()->label(false);?>
            <?php if(in_array($modelQuestion->type,['select_one','radio'])){
                $answerVariants = [];
                foreach ($modelQuestion->answerVariants as $av) {
                    $answerVariants[$av->id] = $av->answer;
                    foreach($av->htmlAttributes as $attributeName => $attributeValue) {
                        if($attributeValue) $options[$av->id]['data-'.$attributeName] = $attributeValue;
                    }
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
                    }
                    echo $form->field($modelAnswer, "[{$questionIndex}]answer",[
                        'options'=>['class'=>'question-field']])
                        ->radioList($answerVariants,[
                                'item'=> function($index, $label, $name, $checked, $value) use($radioOptions){
                                    $return = '<label class="modal-radio">';
                                    $return .= '<input type="radio" name="'.$name.'" value="'.$value.'" ';
                                    if($checked) $return .= 'checked ';
                                    if($radioOptions[$index])foreach($radioOptions[$index] as $attributeName => $attributeValue) {
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
                        ->checkbox(['label'=>false])->label($modelQuestion->quest_text);
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
