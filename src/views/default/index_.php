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
