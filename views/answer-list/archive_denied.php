<?php

use yii\widgets\DetailView;
use yii\grid\GridView;
use app\modules\unicred\questionlist\models\AnswerList;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\AnswerList */
$statusList = AnswerList::getStatusList();
?>
<div class="answer-list-delete">
    <p> Данный опрос находится в статусе <b>"<?php echo $model->statusName;?>"</b>.<br/>
        Перенести в архив невозможно.
        <?php if($model->status=='archive'):?>
            Опрос уже находится в данной группе.
        <?php endif; ?>
    </p>
    <p> Для переноса в архив, опрос должен быть в статусе <br>
        <b>"<?php echo $statusList['done'];?>"</b>. </p>
</div>
