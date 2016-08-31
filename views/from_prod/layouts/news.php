<?php 
use yii\helpers\Url;
use app\models\Common;
$this->beginContent('@app/views/layouts/main.php'); 
?>

<div class="col-md-2">
    <nav class="bs-docs-sidebar hidden-print hidden-xs hidden-sm affix">
        <ul class="nav">
        	<li class=""><?= Common::getBaseUrlForLeftMenu(); ?></li>
            <li class=""><a href="<?=Url::to(['news/index']);?>"><span class="glyphicon glyphicon-plus-sign"></span> Создать новость</a></li>
            <li class=""><a href="<?=Url::to(['news/user']);?>"><span class="glyphicon glyphicon-user"></span> Мои новости</a></li>
            <?php if (Common::showMenu('admin, moderator, super_moderator')): //Yii::$app->user->can() ?>
            <li class=""><a href="<?=Url::to(['news/admin']);?>"><span class="glyphicon glyphicon-cog"></span> Управление</a></li>                     	
            <?php endif ?>
        </ul>
    </nav>
</div>

<div class="col-md-10">
    <?php echo $content; ?>
</div>

<?php $this->endContent(); ?>