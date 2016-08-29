<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Region */
?>
<div class="region-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

</div>
