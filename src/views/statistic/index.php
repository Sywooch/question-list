<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AnswerListStatisticSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Answer Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Answer List', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'question_list_id',
            'date_from',
            'date_to',
            'status',
            // 'do_id',
            // 'list_name',
            // 'scores',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
