<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $modelQuestionList igribov\questionlist\models\QuestionList */

$js = '
$(".add-answervariant").click(function() {
    var button = $(this);
    setTimeout( function(){
        var lastTr = button.parents("table").find("tr.answervariant-item");
        var deleteThisItems = [];
        $.each(lastTr, function(i,el) {
            if(!$(el).find("input[type=text]").val()) {
                deleteThisItems.push(el);
            }
        });
        deleteThisItems.shift();
        $(deleteThisItems).remove();
    },0);
});
';

$this->registerJs($js);

$this->title = 'Редатирование : ' . ' ' . $modelQuestionList->title;
$this->params['breadcrumbs'][] = ['label' => 'Система опросов', 'url' => ['/questionlist/']];
$this->params['breadcrumbs'][] = ['label' => 'Список опросных листов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelQuestionList->title, 'url' => ['view', 'id' => $modelQuestionList->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="question-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelsQuestion' =>  $modelsQuestion,
        'modelQuestionList' =>  $modelQuestionList,
        'modelsAnswerVariant' =>  $modelsAnswerVariant,
    ]) ?>

</div>

