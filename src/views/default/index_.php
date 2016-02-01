<?php
use yii\widgets\Menu;

$this->title = 'Система опросов';
$this->params['breadcrumbs'][] = $this->title;

echo Menu::widget([
    'encodeLabels'=>false,
    'activateParents'=>true,
    'options' =>['style'=>['width'=>'500px']],
    'itemOptions' => ['class'=>'list-group-item'],
    'items'=>[
        ['label'=>'Конструктор', 'url'=>['question-list-constructor/index']],
        ['label'=>'Управление опросами', 'url'=>['answer-list/index']],
        ['label'=>'Мои опросные листы', 'url'=>['write-test/index']],
        ['label'=>'Пользователи и роли', 'url'=>['users-offices/index']],
    ],
]);
?>
