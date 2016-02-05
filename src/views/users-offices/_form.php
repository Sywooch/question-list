<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use igribov\questionlist\models\Region;
use igribov\questionlist\models\Office;

/* @var $this yii\web\View */
/* @var $model igribov\questionlist\models\UsersOffices */
/* @var $form yii\widgets\ActiveForm */
/* @var $usersRoles array */

$offices = ArrayHelper::merge([0=>'-'],ArrayHelper::map(Office::find()->all(), 'id', 'name'));
?>

<div class="users-offices-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'profile_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, "office_id")->dropDownList($offices,[ $model->office_id => ['selected'=>'selected']]);?>

    <? $regions = ArrayHelper::merge([0=>'-'],ArrayHelper::map(Region::find()->all(), 'id', 'name'));?>
    <?= $form->field($model, "region_id")->dropDownList($regions,[ $model->region_id => ['selected'=>'selected']]);?>

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
