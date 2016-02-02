<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model igribov\questionlist\models\UsersOffices */
/* @var $offices array */
/* @var $usersRoles array */
?>
<div class="users-offices-update">

    <?= $this->render('_form', [
        'model' => $model,
        'offices' => $offices,
        'usersRoles' => $usersRoles,
    ]) ?>

</div>
