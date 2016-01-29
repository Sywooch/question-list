<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use app\modules\unicred\models\AnswerVariant;

$answVar = new AnswerVariant();
$answVar->id = $modelsAnswerVariant[0]->id;
$answVar->question_id = $modelsAnswerVariant[0]->question_id;
$answVar->answer = $modelsAnswerVariant[0]->answer;
$modelsAnswerVariant[0] = $answVar;
$modelsAnswerVariant[0]->oldAttributes=$modelsAnswerVariant[1]->oldAttributes;
?>
<?

DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-answervariants',
    'widgetItem' => '.answervariant-item',
    //'limit' => 4,
    'min' => 1,
    'insertButton' => '.add-answervariant',
    'deleteButton' => '.remove-answervariant',
    'model' => new AnswerVariant(['scenario'=>'form']),
    'formId' => 'dynamic-form',
    'formFields' => [
        'answer'
    ],
]); ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Вариант ответа</th>
            <th class="text-center">
                <button type="button" class="add-answervariant btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
            </th>
        </tr>
        </thead>
        <tbody class="container-answervariants">
        <?php if($modelsAnswerVariant) foreach ($modelsAnswerVariant as $indexAnswerVariant => $modelAnswerVariant): ?>
            <tr class="answervariant-item">
                <td class="vcenter">
                    <?php
                    // necessary for update action.
                    if (! $modelAnswerVariant->isNewRecord) {
                        echo Html::activeHiddenInput($modelAnswerVariant, "[{$indexQuestion}][{$indexAnswerVariant}]id");
                    }
                    ?>
                    <?= $form->field($modelAnswerVariant, "[{$indexQuestion}][{$indexAnswerVariant}]answer")->label(false)->textInput(['maxlength' => true]) ?>
                </td>
                <td class="text-center vcenter" style="width: 90px;">
                    <button type="button" class="remove-answervariant btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php DynamicFormWidget::end(); ?>