<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model igribov\questionlist\models\UsersOffices */
/* @var $offices array список отделений для селекта */
/* @var $usersRoles array список отделений для селекта */

?>
<div class="users-offices-create">
    <?= $this->render('_form', [
        'model' => $model,
        'offices' => $offices,
        'usersRoles' => $usersRoles,
    ]) ?>
</div>
