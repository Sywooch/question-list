<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\modules\unicred\questionlist\models\AnswerListSearch */

$this->title = 'Мои опросные листы';
$moduleID = \Yii::$app->controller->module->id;$this->params['breadcrumbs'][] = ['label' => 'Система опросов', 'url' => ['/'.$moduleID]];
$this->params['breadcrumbs'][] = $this->title;

$css = '
tr.style-done { background-color: rgba(33, 222, 73, 0.65); }
tr.style-clear {  }
tr.style-time-over {
    background-color: rgba(247, 3, 3, 0.42);
    color : red;
    font-weight : bold;
}
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
        'rowOptions' => function($model, $key, $index) {
            // Если просрочен срок заполнения опроса, и опрос не в архиве
            $timeOver = (strtotime($model->date_to) - time() < 0 ) &&  $model->status!='archive';
            $class = $timeOver ?'style-time-over' : 'style-'.$model->status;
            return [ 'key' => $key, 'index' => $index, 'class' => $class];
        },
        'columns' => require(__DIR__.'/_columns.php'),
    ]); ?>

</div>
