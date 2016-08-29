<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model igribov\questionlist\models\UsersOffices */
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
