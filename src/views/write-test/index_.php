<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel igribov\questionlist\models\AnswerListSearch */

$this->title = 'Мои опросные листы';
$moduleID = \Yii::$app->controller->module->id;$this->params['breadcrumbs'][] = ['label' => 'Система опросов', 'url' => ['/'.$moduleID]];
$this->params['breadcrumbs'][] = $this->title;

$css = '
tr.style-done { background-color: rgba(33, 222, 73, 0.65); }
tr.style-clear { background-color: rgba(247, 3, 3, 0.42); }
tr.style-answered { background-color: rgba(247, 228, 3, 0.64); }
tr.style-send { background-color: rgba(162, 193, 220, 0.64); }
';
$this->registerCss($css);
?>
<div class="answer-list-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'striped' => false,
        'rowOptions' => function($model,$key,$index) {
            $class = 'style-'.$model->status;
            return [
                'key' => $key,
                'index' => $index,
                'class' => $class,
            ];
        },
        'columns' => require(__DIR__.'/_columns.php'),
    ]); ?>

</div>
