<?php
use yii\helpers\Url;
?>

<script type="text/javascript">
    setInterval(function(){

        var badge = $('.moder-count');

            if (badge.hasClass('badge')) {
                badge.removeClass('badge');
            }
            else {
                badge.addClass('badge');
            }
        },
        15000
    );
</script>

<style type="text/css">
.moder-info {
    position: absolute;
    width: 80px;
    border: 1px solid transparent;
    background-color: #f8f8f8;
    border-radius: 10px;
    border-color: #e7e7e7;
    margin: 100px 0 0 -5px;
    padding-left: 5px;
    padding-right: 3px;
    text-align: center;
}
</style>

<a href="<?=Url::to(['news/admin'])?>">
    <div class="moder-info">
        У вас<br>
        <span class="badge moder-count"><?=$count; ?></span><br>
        новость(и)
    </div>
</a>