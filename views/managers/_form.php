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

$userRoles = Users::findAll([
    'profile_id' => Yii::$app->user->identity->username,
    'profile_office_role' => 'commercial_director'
]);
$userRegions = ArrayHelper::map($userRoles, 'region_id','region_id');
$offices = Office::find()->where(['region_id'=>array_values($userRegions)])->orderBy('region_id')->all();
$offices = ArrayHelper::map($offices, 'id', 'name');
//$regions = ArrayHelper::map(Region::findAll(array_values($userRegions)), 'id', 'name');
?>

<div class="users-offices-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'profile_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, "office_id")->dropDownList($offices,[
        $model->office_id => ['selected'=>'selected'],
        'prompt' => 'Выберите ..',
    ]);?>

    <?
    /*echo $form->field($model, "region_id")->dropDownList($regions,[
        $model->region_id => ['selected'=>'selected'],
        'prompt' => 'Выберите ..',
    ]);*/
    ?>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
