<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AnswerList */

$this->title = 'Create Answer List';
$this->params['breadcrumbs'][] = ['label' => 'Answer Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
