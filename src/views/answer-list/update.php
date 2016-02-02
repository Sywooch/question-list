<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model igribov\questionlist\models\AnswerList */
/* @var $questionLists array */
/* @var $DoList array */
/* @var $statusList array */
?>
<div class="answer-list-update">

    <?= $this->render('_form', [
        'model' => $model,
        'questionLists' => $questionLists,
        'DoList' => $DoList,
        'statusList' => $statusList, // отобразить еще поле select для изменения стутуса
    ]) ?>

</div>
