<?php
use yii\widgets\Menu;


$this->title = 'Система опросов';
$this->params['breadcrumbs'][] = $this->title;

echo Menu::widget([
    'encodeLabels'=>false,
    'activateParents'=>true,
    'options' =>['style'=>['width'=>'500px']],
    'itemOptions' => ['class'=>'list-group-item'],
    'items'=> $actions,
]);
?>

<pre>	
		$users = [
	        '100' => [
	            'id' => '100',
	            'username' => 'admin',  //АДМИН
	            'password' => 'admin',
	            'authKey' => 'test100key',
	            'accessToken' => '100-token',
	        ],
	        '101' => [
	            'id' => '101',
	            'username' => 'empl', // ОБЫЧНЫЙ СОТРУДНИК
	            'password' => 'pass',
	            'authKey' => 'test101key',
	            'accessToken' => '101-token',
	        ],
	        '102' => [
	            'id' => '102',
	            'username' => 'ql_manager_1', // УПРАВЛЯЮЩИЙ ОТДЕЛЕНИЕ 1 РЕГИОН 1
	            'password' => 'pass',
	            'authKey' => 'test102key',
	            'accessToken' => '102-token',
	        ],
	        '103' => [
	            'id' => '103',
	            'username' => 'comdir1',  // КОМ.ДИР РЕГИОН 1
	            'password' => 'pass',
	            'authKey' => 'test103key',
	            'accessToken' => '103-token',
	        ],
	        '105' => [
	            'id' => '105',
	            'username' => 'comdir2', // КОМ.ДИР РЕГИОН 2
	            'password' => 'pass',
	            'authKey' => 'test105key',
	            'accessToken' => '105-token',
	        ],
	        '104' => [
	            'id' => '104',
	            'username' => 'ql_manager_2', // УПРАВЛЯЮЩИЙ ОТДЕЛЕНИЕ 3 РЕГИОН 2
	            'password' => 'pass',
	            'authKey' => 'test104key',
	            'accessToken' => '104-token',
	        ],
	    ];
</pre>
