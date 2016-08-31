<?php 
use yii\helpers\Url;
use app\models\Common;
$this->beginContent('@app/views/layouts/main.php'); 
?>

<div class="col-md-2">
    <nav class="affix" style='position: fixed;'>
        <ul class="nav">
        	<li class=""><?= Common::getBaseUrlForLeftMenu(); ?></li>
            <?php if (Common::showMenu('admin')): ?>
                <li class=""><a href="<?=Url::to(['setup/roles']);?>"><span class="glyphicon glyphicon-user"></span> Роли</a></li>
            <?php endif ?>
            <?php if (Common::showMenu('moderator, super_moderator, admin') && 1==2): ?>
                <li class=""><a href="<?=Url::to(['setup/deputy']);?>"><span class="glyphicon glyphicon-baby-formula"></span> Заместители</a></li>                     	
            <?php endif ?>
        </ul>
    </nav>
</div>

<div class="col-md-10">
    <?php echo $content; ?>
</div>

<?php $this->endContent(); ?>