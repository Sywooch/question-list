Question List module for Yii 2
=====

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist igribov/question-list
```

or add

```
"igribov/question-list": "*"
```

to the require section of your `composer.json` file.

Configuration
---

1) In your config/web.php

```php

'modules'=>[
	'questionlist' => [
          'class' => 'igribov\questionlist\Module',
          'onBeforeAction' => function($controllerId,$actionId,$user,$urlParams){
              return true;
          },
      ],
],

```
Метод onBeforeAction заданный анонимной функцией, должен возвращать boolean.
Он определяет доступ к методу контроллера, для настройки доступа.

2) Run migrations

```php

./yii migrate --migrationPath=vendor/igribov/question-list/src/migrations/

```

Where you can go
-----

```php

<?php
use yii\widgets\Menu;

echo Menu::widget([
    'encodeLabels'=>false,
    'activateParents'=>true,
    'items'=>[
        ['label'=>'Конструктор', 'url'=>['question-list-constructor/index']],
        ['label'=>'Управление опросами', 'url'=>['answer-list/index']],
        ['label'=>'Мои опросные листы', 'url'=>['write-test/index']],
        ['label'=>'Пользователи и роли', 'url'=>['users-offices/index']],
    ],
]);
?>

```

First steps
---

1) Зайти как admin/admin

2) Зайти в Пользователи и роли и добавить роль Менеджер пользователю admin, выбрать отделение;

3) Зайти в "Конструктор" и создать новый список вопросов;

4) Зайти в "Управление опросами" и назначить порос отделению, которое выбрано в п.1

5) Зайти в "Мои опросные листы" и ответить на опрос.