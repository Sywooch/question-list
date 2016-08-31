<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use \kartik\grid\GridView;
use yii\helpers\Html;
use app\models\User;
use \kartik\editable\Editable;

return [
	'id',
	'profile_id',
	'fullname',
	'email',
	[
	    'class'=>'kartik\grid\EditableColumn',
	    'attribute' => 'authAssignmentsItemName', 
	    'readonly'=>function($model, $key, $index, $widget) {
	        return sprintf('%s', $model->roles[$model->authAssignments->item_name]);
	    },
	    'editableOptions'=>[
	        'header'=>'Роль', 
	        'inputType'=>Editable::INPUT_DROPDOWN_LIST,		        
            'name'=>'authAssignments.item_name', 
		    'asPopover' => true,
		    'format' => Editable::FORMAT_BUTTON,
		    'inputType' => Editable::INPUT_DROPDOWN_LIST,
		    'data'=> $rolesData, // any list of values
		    'options' => ['class'=>'form-control'],
		    'formOptions'=>['action' => 'change-role'],
		    'editableValueOptions'=>['class'=>'text-danger']
	        
	    ],
	    'hAlign'=>'right', 
	    'vAlign'=>'middle',
	    'width'=>'7%',
	],
	[
		'attribute' => 'authAssignments.item_name',
		'format' => 'raw',
		'value' => function ($data) {
			if ($data->id == Yii::$app->user->id) {
				return sprintf('%s', $data->roles[$data->authAssignments->item_name]);
			}
			else {
			
				$load = sprintf('<span style="display:none;" id="load_%s">Загрузка... <img src="%s/img/loading.gif"></span>',
					$data->id,
					Yii::$app->urlManager->baseUrl
				);
				
				$ddl = Html::dropDownList('role', 
					$data->authAssignments->item_name, 
					(new User)->roles, 
					['OnChange' => 'changeRole('.$data->id.');', 'class' => 'changeRole_'.$data->id]
				);

				return $load.$ddl;
			}
		}
	],
	'reg_date',
	[
		'class'=> '\yii\grid\ActionColumn',
		'template' => '{update}', //{view} 
		'options' => ['style'=>'width:50px;'],
		'buttons' => [
			'update' => function ($url, $model) {
				return $model->genButton('update');
			},
			// 'view' => function ($url, $model) {
			// 	return $model->genButton('view');
			// },
		]
	],
];
