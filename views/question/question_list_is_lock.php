<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $action string  */
/* @var $modelQuestionList app\modules\unicred\questionlist\models\QuestionList */
/* @var $list_id integer */

$this->title = $action=='create' ? 'Добавление вопроса' : 'Изменение вопроса';
$this->params['breadcrumbs'][] = ['label' => 'Опросные листы', 'url' => ['question-list/index']];
$this->params['breadcrumbs'][] = ['label' => 'Вопросы опросного листа "'.$modelQuestionList->title.'"', 'url' => ['index','list_id'=>$modelQuestionList->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-update">
    <h4> Изменение запрещено.</h4>
<p>
    Данный опросный лист уже назначен отделениям. Изменять содержание опроса невозможно.
</p>
</div>
