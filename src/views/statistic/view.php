<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AnswerList */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Answer Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-list-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'question_list_id',
            'date_from',
            'date_to',
            'status',
            'do_id',
            'list_name',
            'scores',
        ],
    ]) ?>

</div>
