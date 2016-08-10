<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

// TODO : исправить тут строка 21!
$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-question").each(function(index) {
        jQuery(this).html("Вопрос: " + (index + 1));
    });
jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-question").each(function(index) {
        jQuery(this).html("Вопрос: " + (index + 1))
    });
});
rebuildQuestionFormValidToSelectType();

$(".add-answervariant").last().click( function(){
        var button = $(this);
        var foo = function() {
            var trList = button.parents(".answer-variants").find(".answervariant-item");
            var emptyTr = 0;
            $.each(trList,function( i, element ){
                if(i==0) return;
                if( $(element).find("input[type=text]").val()==""){
                    emptyTr++;
                }
            });
            while(emptyTr > 1){
                var el = Array.prototype.pop.call(trList);
                $(el).remove();
                emptyTr--;
            }
        }
        setTimeout(foo,0);
    });
});

jQuery(document).on("change",".select-question-type select",function(){
    var select = $(this),
    num = select.attr("id").slice(9, select.attr("id").indexOf("-type")) ;

    switch(select.val()) {
        case "multiple" :
            $(".answer-variants").eq(num).show();
            $(".answer-variants").eq(num).find(".container-answervariants").find("input[type=text]").val("");
        break;
        default :
            if(!confirm("Сменить тип вопроса? Варианты ответа будут очищены из формы?")) {
                select.find("option[value=multiple]").attr("selected","selected");
                return;
            }
            $(".answer-variants").eq(num).hide();
            $(".answer-variants").eq(num).find(".container-answervariants").find("input[type=text]").val("-");
            $(".answer-variants").eq(num).find(".container-answervariants").find("input[type=number]").val(0);
    }
    $.each($(".answer-variants").eq(num).find(".answervariant-item"),function( i, element ){
        if(i===0) return;
        element.remove();
    });
});

/**
 * Обходит все вопросы, скрывает варианты ответа, если не выбран тип multiple
 *
 */
function rebuildQuestionFormValidToSelectType() {
    jQuery.each($(".select-question-type").find("select"),function( i, element ) {
        var answerVariantsDiv = $(element).parents(".select-question-type").siblings(".answer-variants");
        switch($(element).val()) {
            case "multiple":
            break;
            default :
                answerVariantsDiv.find("input[type=text]").last().val("-");
                answerVariantsDiv.hide();
            break;
        }
    });
}
jQuery(document).ready(function() {
    rebuildQuestionFormValidToSelectType();
});

';

$this->registerJs($js);

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\QuestionList */
/* @var $form yii\widgets\ActiveForm */

?>


<div class="question-list-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($modelQuestionList, 'title')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-questions', // required: css class selector
        'widgetItem' => '.question', // required: css class
        //'limit' => 20, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-question', // css class
        'deleteButton' => '.remove-question', // css class
        'model' => $modelsQuestion[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'type',
            'quest_text',
            'answer'
        ],
    ]); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> Вопросы
            <button type="button" id="add-question-button" class="pull-right add-question btn btn-success btn-xs"><i class="fa fa-plus"></i>Добавить вопрос</button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-questions"><!-- widgetContainer -->
            <?php foreach ($modelsQuestion as $index => $modelQuestion): ?>

            <div class="question panel panel-default"><!-- widgetBody -->
                <div class="panel-heading">
                    <span class="panel-title-question">Вопрос : <?= ($index + 1) ?></span>
                    <button type="button" class="pull-right remove-question btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <?php
                    // necessary for update action.
                    if (!$modelQuestion->isNewRecord) {
                        echo Html::activeHiddenInput($modelQuestion, "[{$index}]id");
                    }
                    ?>
                    <?= $form->field($modelQuestion, "[{$index}]quest_text")->textArea(['maxlength' => true]) ?>

                    <div class="row">
                        <div class="col-sm-6 select-question-type">
                            <?= $form->field($modelQuestion, "[{$index}]type")->listBox($modelQuestion->getQuestionTypes(),['size'=>1])?>
                        </div>
                        <div class="col-sm-6 answer-variants">
                            <?= $this->render('_form-answervariant', [
                                'form' => $form,
                                'indexQuestion' => $index,
                                'modelsAnswerVariant' =>  $modelsAnswerVariant[$index]
                            ]) ?>
                        </div>
                    </div><!-- end:row -->
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
    <?php DynamicFormWidget::end(); ?>



    <div class="form-group">
        <?php echo Html::submitButton($modelQuestion->isNewRecord ? 'Создать' : 'Обновить', ['class' => 'btn btn-primary','submit-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
