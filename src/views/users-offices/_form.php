<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\models\UsersOffices */
/* @var $form yii\widgets\ActiveForm */
/* @var $offices array */
/* @var $usersRoles array */

?>

<div class="users-offices-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'profile_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, "office_id")->dropDownList($offices,[ $model->office_id => ['selected'=>'selected']]);?>

    <?= $form
        ->field($model, "profile_office_role")
        ->dropDownList($usersRoles,[ $model->profile_office_role => ['selected'=>'selected']]);?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
