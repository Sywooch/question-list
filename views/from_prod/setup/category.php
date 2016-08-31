<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Categories;
?>

<h3>Настройка категорий пользователя: <?= $user->name_ru ?></h3>
<br />
<div class="col-lg-6" style="text-align: center;margin-bottom: 20px; text-align: left;">
	<?php $form = ActiveForm::begin([]); ?>

	<?= $form->errorSummary($relations); ?>

	<?= $form->field($relations, 'category_title')->dropDownList(
        ArrayHelper::map(Categories::find()->orderBy('title ASC')->all(), 'id', 'title'),
        ['prompt'=>'Выберите категорию']);
    ?>
    <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
</div>


	<?php $form = ActiveForm::end(); ?>

<div class="col-lg-6" style="text-align: center;margin-bottom: 20px;">
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			[
				'attribute' => 'id',
				'options' => ['style'=>'width:30px']
			],
			'category.title',
			[
				'class'=> '\yii\grid\ActionColumn',
				'template' => '{delete}', //{view} 
				'options' => ['style'=>'width:50px;'],
				'buttons' => [
					'delete' => function ($url, $model) {
						return $model->genButton('delete');
					}
				]
			],
		]
	]) ?>
</div>
