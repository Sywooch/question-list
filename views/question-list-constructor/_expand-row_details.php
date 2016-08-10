<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\DetailView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $modelAnswerList app\modules\unicred\questionlist\models\AnswerList */

?>
<div class="question-list-view">

    <h1><?= Html::encode($model->title) ?></h1>

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