<?php

use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\AnswerList */
?>
<div class="answer-list-delete">
    <p> Данный опрос находится в статусе "<?php echo $model->statusName;?>". Удалить невозможно. </p>
</div>
