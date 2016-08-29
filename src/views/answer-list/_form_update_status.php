<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model igribov\questionlist\models\AnswerList */
/* @var $form yii\widgets\ActiveForm */
/* @var $questionLists array */
/* @var $DoList array */
/* @var $statusList array */

?>

<div class="answer-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <? if(!empty($statusList)):?>
        <?= $form->field($model, "status")->dropDownList($statusList,
            [ $model->status => ['selected'=>'selected']]);?>
    <? endif?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group" style="margin-top : 50px;">
            <?= Html::submitButton('Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
