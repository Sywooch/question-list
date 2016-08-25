<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\AnswerList */
/* @var $form yii\widgets\ActiveForm */
/* @var $questionLists array */
/* @var $DoList array */
/* @var $statusList array */

?>

<? echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'statusName',
    ],
]) ?>

<div class="answer-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, "question_list_id")->dropDownList($questionLists,
        [ $model->question_list_id => ['selected'=>'selected']]);?>

    <? if(!empty($statusList)):?>
        <? /*echo $form->field($model, "status")->dropDownList($statusList,
            [ $model->status => ['selected'=>'selected']]);*/ ?>
    <? endif?>

    <?= $form->field($model, "status")->dropDownList($statusList,
        [ $model->status => ['selected'=>'selected']]);?>

    <?= $form->field($model, "do_id")->dropDownList($DoList,
        [ $model->question_list_id => ['selected'=>'selected']]);?>

    <div class="form-group field-answerlist-dates">
        <?= DatePicker::widget(
            [
                'name'=>'date_from',
                'type'=> DatePicker::TYPE_RANGE,
                'name2' => 'date_to',
                'form' => $form,
                'model' => $model,
                'attribute' => 'date_from',
                'attribute2' => 'date_to',
                'language'=>'ru',
                'separator'=>' - ',
                'pluginOptions' => [
                    'format'=>'yyyy-mm-dd',
                ],
            ]
        ); ?>
    </div>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group" style="margin-top : 50px;">
            <?= Html::submitButton($model->isNewRecord ? 'Назначить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
