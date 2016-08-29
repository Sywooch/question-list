<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\Question */
/* @var $list_id integer */

$this->title = 'Изменение вопроса ';
$this->params['breadcrumbs'][] = ['label' => 'Опросные листы', 'url' => ['question-list/index']];
$this->params['breadcrumbs'][] = ['label' => 'Вопросы опросного листа #'.$list_id, 'url' => ['index','list_id'=>$list_id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="question-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list_id' => $list_id,
    ]) ?>

</div>
