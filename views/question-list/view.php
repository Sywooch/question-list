<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\QuestionList */
?>
<div class="question-list-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
        ],
    ]) ?>

</div>
