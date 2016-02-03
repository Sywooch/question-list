<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use igribov\questionlist\models\Region;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\models\Office */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="office-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php $regions =  yii\helpers\ArrayHelper::map(igribov\questionlist\models\Region::find()->all(), 'id', 'name');?>

    <?= $form->field($model, "region_id")->dropDownList($regions,
        [ $model->region_id => ['selected'=>'selected']]);?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
