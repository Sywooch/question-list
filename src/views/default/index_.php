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
        ['label'=>'Конструктор', 'url'=>['/questionlist/question-list-constructor/index']],
        ['label'=>'Управление опросами', 'url'=>['/questionlist/answer-list/index']],
        ['label'=>'Мои опросные листы', 'url'=>['/questionlist/write-test/index']],
        ['label'=>'Пользователи и роли', 'url'=>['/questionlist/users-offices/index']],
        ['label'=>'Выход', 'url'=>['/user-management/auth/logout']],
        ['label'=>'Вход', 'url'=>['/user-management/auth/login']],
    ],
]);
?>
