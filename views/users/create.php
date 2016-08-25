<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\unicred\questionlist\models\UsersOffices */
/* @var $offices array список отделений для селекта */
/* @var $usersRoles array список отделений для селекта */

?>
<div class="users-offices-create">
    <?= $this->render('_form', [
        'model' => $model,
        'usersRoles' => $usersRoles,
    ]) ?>
</div>
