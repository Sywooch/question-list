<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;
use yii\helpers\Url;

CrudAsset::register($this);
?>

<h3>Настройка прав пользователя: <?= $user->fullname ?></h3>
<br />
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $user,
    ]) ?>

</div>

<div class="col-lg-6" style="text-align: center;margin-bottom: 20px;">
	<h4><?= $user->roles[User::MANAGER]; ?> в офисах </h4>
	<?= GridView::widget([
		'dataProvider' => $officesDataProvider,
		'columns' => [
			[
				'attribute' => 'id',
				'options' => ['style'=>'width:30px']
			],
			'name',
			[
				'class'=> 'kartik\grid\ActionColumn',
				'template' => '{delete}', //{view} 
				'options' => ['style'=>'width:50px;'],
				'buttons' => [
					'delete' => function ($url, $model) use ($user) {				 
					    return Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', 
			            	[
			            		'setup/delete-user-office', 
			            		'id'=>$model->id, 
			            		'user_id'=>$user->id
			            	]);
					}
				]
			],
		]
	]) ?>
</div>

<div class="col-lg-6" style="text-align: center;margin-bottom: 20px;">
	<div id="ajaxCrudDatatableRegions">
		<h4><?= $user->roles[User::COMDIR]; ?> в регионах </h4>
		<?= GridView::widget([
			'id'=>'crud-datatable-regions',
			'dataProvider' => $regionsDataProvider,
			'striped' => true,
			'pjax'=>true,
	        'condensed' => true,
	        'responsive' => true,
	        'toolbar'=> [
	            ['content'=>
	                Html::a('Добавить <i class="glyphicon glyphicon-plus"></i>', ['create'],
	                ['role'=>'modal-remote','title'=> 'Добавить регион','class'=>'btn btn-default']).
	                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['','id'=>$user->id],
	                ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Обновить'])
	                //.'{toggleData}'
	                //.'{export}'
	            ],
	        ],
	        'panel' => [
                //'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Коммерческий директор в регионах',
                //'before'=>'<em></em>',
            ],
			'columns' => [
				[
					'attribute' => 'id',
					'options' => ['style'=>'width:30px']
				],
				'name',
				[
					'class' => 'kartik\grid\ActionColumn',
			        'dropdown' => false,
			        'template' => '{delete}',
			        'vAlign'=>'middle',
			        'urlCreator' => function($action, $model, $key, $index) use ($user) {
			            //if($action=='delete') return Url::to(['setup/delete-user-region','id'=>$model->id, 'user_id'=>$user->id]);
			            return Url::to(["user-linked-offices-regions/{$action}-region", 'region_id'=>$model->id, 'user_id'=>$user->id]);
			        },
			        //'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
			        'updateOptions'=>['role'=>'modal-remote','title'=>'Переименовать', 'data-toggle'=>'tooltip'],
			        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить',
			                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
			                          'data-request-method'=>'post',
			                          'data-toggle'=>'tooltip',
			                          'data-confirm-title'=>'Подтверждение удаления',
			                          'data-confirm-message'=>'Вы уверены, что хотите удалить?'],
				],
			],
		]);?>
	</div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
