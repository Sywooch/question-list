<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\UsersOffices */
?>
<div class="users-offices-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'profile_id',
            'officeName',
            'roleName',
        ],
    ]) ?>

</div>
