<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\Question */
/* @var $list_id integer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index','list_id'=>$list_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id, 'list_id'=>$list_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id, 'list_id'=>$list_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить вопрос?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php
    foreach($model->answerVariants as $item){
        $answerVariantsString.= $item->answer;
        $answerVariantsString.= '('.$item->scores.' б.)<br/>';
    }
    $attributes = ['questionTypeName','quest_text'];
    if($answerVariantsString) $attributes[] = [
        'label' => 'Варианты ответа',
        'format'=>'raw',
        'value' => $answerVariantsString,
    ];
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>

</div>
