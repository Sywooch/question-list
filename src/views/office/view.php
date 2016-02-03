<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\models\Office */
?>
<div class="office-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'regionName',
            'name',
        ],
    ]) ?>

</div>
