<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\unicred\questionlist\QuestionCreateUpdateAsset as Asset;
use wbraganca\dynamicform\DynamicFormWidget;
use app\modules\unicred\questionlist\models\AnswerVariant;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\Question */
/* @var $form yii\widgets\ActiveForm */

Asset::register($this);
?>

<div class="question-form">

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<?php echo $form->field($model, "type")->dropDownList($model->getQuestionTypes())?>

<?php echo $form->field($model, 'quest_text')->textArea(['maxlength' => true]) ?>

<?php $modelsAnswerVariants = $model->answerVariants;?>

<?php $modelsAnswerVariants = $modelsAnswerVariants  ? $modelsAnswerVariants  : [new AnswerVariant(),new AnswerVariant()];?>
    <div id="checkbox-scores-block" class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-ok"></i> Чекбокс</h4></div>
        <div class="panel-body">
            <div class="col-md-6 col-sm-10">
                <?= Html::label('Если чек-бокс установлен то начислить баллов','checkboxUpScores',[
                    'style'=>['padding'=>'6px'],
                ]);?>
            </div>
            <div class="col-md-6 col-sm-2">
                <?php $value = $model->answerVariants[0] ? $model->answerVariants[0]->scores : 0; ?>
                <?= Html::input('number','checkboxUpScores', $value ,['class'=>'form-control']);?>
            </div>
        </div>
    </div>
    <div id="answer-variants-block" class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-list"></i> <?php echo $model->getAttributeLabel('answer');?></h4></div>
        <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                //'limit' => 4,
                'min' => 2, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsAnswerVariants[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'answer',
                    'scores',
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
                <?php foreach ($modelsAnswerVariants as $i => $modelsAnswerVariant): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">Вариант <?php echo ($i+1);?></h3>
                            <div class="pull-right">
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                            // necessary for update action.
                            if (! $modelsAnswerVariant->isNewRecord) {
                                echo Html::activeHiddenInput($modelsAnswerVariant, "[{$i}]id");
                            }
                            ?>
                            <div class="one-answer-variant row">
                                <div class="col-sm-4">
                                    <?= $form->field($modelsAnswerVariant, "[{$i}]answer")->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-sm-4">
                                    <?= $form->field($modelsAnswerVariant, "[{$i}]scores")->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-sm-4">
                                    <?= $form->field($modelsAnswerVariant, "[{$i}]htmlAttributes[showcomment]")
                                        ->checkbox(['label' =>'С комментарием'])
                                        ->label(false)?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>


<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
