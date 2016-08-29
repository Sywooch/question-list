<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\Users */
?>
<div class="users-offices-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'profile_id',
            'officeName',
            'regionName',
            'roleName',
        ],
    ]) ?>

</div>
