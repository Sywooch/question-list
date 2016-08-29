<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\unicred\questionlist\QuestionCreateUpdateAsset as Asset;
use wbraganca\dynamicform\DynamicFormWidget;
use app\modules\unicred\questionlist\models\AnswerVariant;
use app\modules\unicred\questionlist\models\Question;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\Question */
/* @var $form yii\widgets\ActiveForm */
/* @var $list_id int*/

Asset::register($this);
?>

<div class="question-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?php echo $form->field($model, "type")->dropDownList($model->getQuestionTypes())?>

    <?php echo $form->field($model, 'ordering')->textInput(['type' => 'number']) ?>

    <?php echo $form->field($model, 'quest_text')->textArea(['maxlength' => true]) ?>

    <div id="visible_condition_block" class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-eye-open"></i> Условие видимости</h4></div>
        <div class="panel-body">
            <div class="col-md-6 col-sm-10">
                <?php
                    $query = Question::find()->where(['list_id'=>$list_id]);
                    $query->andWhere(['<>','type','text']);
                    // Если вопрос изменяется, то исключим его из выбора вопроса, связаного условием
                    if($model->id) $query->andWhere(['<>','id',$model->id]);
                    $questionsInList = ArrayHelper::map($query->all(),'id','quest_text');
                ?>
                <?php echo $form->field($model, "visible_condition")->dropDownList($questionsInList,['prompt' => 'Нет',])?>
            </div>
            <div class="col-md-6 col-sm-10">
                <?php echo $form->field($model, 'visible_condition_value')->hiddenInput(['maxlength' => true]);?>
                <div id="condition-value-block" class="col-md-12 col-sm-10">
                </div>
            </div>
        </div>
    </div>


    <div id="checkbox-scores-block" class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-ok"></i> Чекбокс</h4></div>
        <div class="panel-body">
            <div class="col-md-6 col-sm-10">
                <?php echo Html::label('Если чек-бокс установлен то начислить баллов','checkboxUpScores',[
                'style'=>['padding'=>'6px'],
                ]);?>
            </div>
            <div class="col-md-6 col-sm-2">
                <?php $value = $model->answerVariants[0] ? $model->answerVariants[0]->scores : 0; ?>
                <?php echo Html::input('number','checkboxUpScores', $value ,['class'=>'form-control']);?>
            </div>
        </div>
    </div>
    <?php $modelsAnswerVariants = $model->answerVariants;?>
    <?php $modelsAnswerVariants = $modelsAnswerVariants  ? $modelsAnswerVariants  : [new AnswerVariant(),new AnswerVariant()];?>
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
                            <h3 class="panel-title pull-left">Вариант ответа <?php echo ($i+1);?></h3>
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
                                    <?php echo $form->field($modelsAnswerVariant, "[{$i}]answer")->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php echo $form->field($modelsAnswerVariant, "[{$i}]scores")->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php echo $form->field($modelsAnswerVariant, "[{$i}]htmlAttributes[showcomment]")
                                        ->checkbox(['label' =>'С комментарием'])
                                        ->label(false)?>
                                    <em style="font-size:10px">
                                        Если установлен, то (при выборе данного варианта) будет отображено поле для ввода комментария.
                                    </em>
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
    <?php echo Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
