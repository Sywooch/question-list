<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AnswerList */
/* @var $form yii\widgets\ActiveForm */

/*$this->registerJs('
');*/
?>

<div class="answer-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
        $statuses = app\modules\unicred\questionlist\models\AnswerList::getStatusList();
        //if($model)
        $statuses['answered'] = 'В работе у отделения';
        yii\helpers\ArrayHelper::remove($statuses,'clear');
        //yii\helpers\ArrayHelper::remove($statuses,'archive');
    ?>

    <?= $form->field($model, "status")->dropDownList($statuses,
        [ $model->status => ['selected'=>'selected']]);?>

    <?= $form->field($model, 'comment')->textarea() ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
