<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model igribov\questionlist\models\UsersOffices */
/* @var $usersRoles array */
?>
<div class="users-offices-update">

    <?= $this->render('_form', [
        'model' => $model,
        'usersRoles' => $usersRoles,
    ]) ?>

</div>
