<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\AnswerList */
/* @var $questionLists array */
/* @var $DoList array */
/* @var $statusList array */
?>
<div class="answer-list-update">

    <?= $this->render('_form_update_status', [
        'model' => $model,
        'statusList' => $statusList, // отобразить еще поле select для изменения стутуса
    ]) ?>

</div>
