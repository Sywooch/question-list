<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\Question */

$this->title = 'Создание вопроса';
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index','list_id'=>$list_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
