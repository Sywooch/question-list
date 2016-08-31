<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Вход';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h2><?= Html::encode($this->title) ?></h2>

    <p>Для входа используйте <span style="color: red;">ваш логин и пароль от Windows</span></p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?php echo $form->field($model, 'login') ?>

    <?php if(!\app\models\Common::isLocalServer()) : ?>
   
    <?php echo $form->field($model, 'password')->passwordInput();?>

    <?php endif;?>

    <?php    
    // $form->field($model, 'rememberMe', [
    //     'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
    // ])->checkbox() 
    ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Вход', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
