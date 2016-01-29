<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model igribov\questionlist\models\AnswerList */
/* @var $questionLists array */
/* @var $DoList array */

?>
<div class="answer-list-create">
    <?= $this->render('_form', [
        'model' => $model,
        'questionLists' => $questionLists,
        'DoList' => $DoList,
    ]) ?>
</div>
