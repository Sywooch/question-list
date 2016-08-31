<?php 
use yii\helpers\Url;
use app\models\Common;
$this->beginContent('@app/views/layouts/main.php'); 
?>

<div class="col-md-2">
    <nav class="affix" style='position: fixed;'>
        <ul class="nav">
        	<li class=""><?= Common::getBaseUrlForLeftMenu(); ?></li>
            <li class=""><a href="<?=Url::to(['question/create']);?>"><span class="glyphicon glyphicon-plus-sign"></span> Новый вопрос</a></li>
            <li class=""><a href="<?=Url::to(['question/user']);?>"><span class="glyphicon glyphicon-user"></span> Мои вопросы</a></li>
            <?php if (Common::showMenu('admin')): ?>
            <li class=""><a href="<?=Url::to(['question/admin']);?>"><span class="glyphicon glyphicon-cog"></span> Управление</a></li>                     	
            <?php endif ?>
        </ul>
    </nav>
</div>

<div class="col-md-10">
    <?php echo $content; ?>
</div>

<?php $this->endContent(); ?>