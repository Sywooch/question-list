<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\Question */
/* @var $list_id integer */

$this->title = 'Update Question: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id,'list_id'=>$list_id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="question-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
