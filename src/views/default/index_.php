<?php
use webvimark\modules\UserManagement\components\GhostMenu;

$this->title = 'Система опросов';
$this->params['breadcrumbs'][] = $this->title;

echo GhostMenu::widget([
    'encodeLabels'=>false,
    'activateParents'=>true,
    'options' =>['style'=>['width'=>'500px']],
    'itemOptions' => ['class'=>'list-group-item'],
    'items'=>[
        ['label'=>'Конструктор', 'url'=>['/unicred/question-list-constructor/index']],
        ['label'=>'Управление опросами', 'url'=>['/unicred/answer-list/index']],
        ['label'=>'Мои опросные листы', 'url'=>['/unicred/write-test/index']],
        ['label'=>'Пользователи и роли', 'url'=>['/unicred/users-offices/index']],
        ['label'=>'Выход', 'url'=>['/user-management/auth/logout']],
        ['label'=>'Вход', 'url'=>['/user-management/auth/login']],
    ],
]);
?>
