<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\unicred\questionlist\models\Region;
use app\modules\unicred\questionlist\models\Users;
use app\modules\unicred\questionlist\models\Office;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\Users */
/* @var $form yii\widgets\ActiveForm */
/* @var $usersRoles array */

$offices = ArrayHelper::map(Office::find()->all(), 'id', 'name');
$regions = ArrayHelper::map(Region::find()->all(), 'id', 'name');

?>

<div class="users-offices-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'profile_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, "office_id")->dropDownList($offices,[
        $model->office_id => ['selected'=>'selected'],
        'prompt' => 'Выберите ..',
    ]);?>

    <?= $form->field($model, "region_id")->dropDownList($regions,[
        $model->region_id => ['selected'=>'selected'],
        'prompt' => 'Выберите ..',
    ]);?>

    <?= $form
        ->field($model, "profile_office_role")
        ->dropDownList($usersRoles,[
            $model->profile_office_role => ['selected'=>'selected'],
            'prompt' => 'Выберите ..',
        ]);?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
