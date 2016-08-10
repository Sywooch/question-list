<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $modelAnswerList app\modules\unecred\questionlist\models\AnswerList */
/* @var $dataProvider app\modules\unecred\questionlist\models\AnswerList */

$this->title = $modelAnswerList->id;
$moduleID = \Yii::$app->controller->module->id;$this->params['breadcrumbs'][] = ['label' => 'Система опросов', 'url' => ['/'.$moduleID]];
$this->params['breadcrumbs'][] = ['label' => 'Мои опросные листы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss('
.comment {
    border : 1px solid red ;
    border-radius : 5px;
    background-color : white;
    padding : 5px;
    margin : 5px;
}
');

?>
<div class="answer-list-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if($modelAnswerList->id) echo Html::a('Изменить', ['update', 'id' => $modelAnswerList->id], ['class' => 'btn btn-primary']); ?>

    <?php if($modelAnswerList->comment): ?>
        <div class="comment">
            <p><i>Комментарий : <?php echo $modelAnswerList->comment; ?></i></p>
        </div>
    <?php endif ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'question_text',
            'question_type',
            'answer',
            'answer_comment',
            'scores',
        ],
    ]) ?>

</div>
