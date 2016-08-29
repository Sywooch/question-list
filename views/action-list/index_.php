<?php
use yii\widgets\Menu;

/**
 * @var $actions array;
 * @var $userRoles array;
 */

$this->title = 'Система опросов';
$this->params['breadcrumbs'][] = $this->title;
?>
<ul class="roles-list">
<?php
foreach($userRoles as $role){
    echo '<li>'.$role->roleName;
    if($role->regionName) echo '(Регион : '.$role->regionName.')';
    if($role->officeName) echo '(Офис : '.$role->officeName.')';
    echo '</li>';
}
?>
</ul>
<?php

echo Menu::widget([
    'encodeLabels'=>false,
    'activateParents'=>true,
    'options' =>['style'=>['width'=>'500px']],
    'itemOptions' => ['class'=>'list-group-item'],
    'items'=> $actions,
]);
?>

