<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\DetailView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $modelAnswerList app\modules\unicred\models\AnswerList */

?>
<div class="question-list-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title'
        ],
    ]) ?>
    <?= GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $model->questions,
        ]),
        //'filterModel' => false,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'quest_text',
            'questionTypeName',
            'answerVariantsInline',
        ],
    ]) ?>

</div>