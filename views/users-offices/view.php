<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\unicred\models\UsersOffices */
?>
<div class="users-offices-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'profile_id',
            'officeName',
            'profile_office_role',
        ],
    ]) ?>

</div>
