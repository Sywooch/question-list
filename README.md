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
      ],
],

```

2) Run migrations

```php

./yii migrate --migrationPath=vendor/igribov/question-list/src/migrations/

```

Where you can go

```php
/questionlist
```


