<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;

?>
<div class="site-error">

    <h2><?= Html::encode($this->title) ?></h2>
    <br>
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <br>
    
    <?=$this->render('index.php') ?>

</div>
