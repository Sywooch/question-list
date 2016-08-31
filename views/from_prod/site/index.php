<?php
use yii\helpers\Url;
use app\models\Common;

$this->title = 'Control System';

?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
  
            <div class='col-lg-6' style="text-align: center;">
                <a href="<?=Url::to(['news/index']);?>">
                <img style="width: 50px;margin-bottom: 10px" src="<?php echo Yii::$app->urlManager->baseUrl; ?>/img/notepad.svg">
                <!-- <span class="glyphicon glyphicon-edit" style="font-size: 35px;" aria-hidden="true"></span> -->
                <h3>
                    Новости</a>
                </h3>
                <p>Создание и управление новостями</p>
            </div>
            
            <div class='col-lg-6' style="text-align: center;">
            <a href="<?= Url::to(['question/create']);?>">
            <img style="width: 50px;margin-bottom: 10px" src="<?php echo Yii::$app->urlManager->baseUrl; ?>/img/bubbles-alt.svg">
            <!-- <span class="glyphicon glyphicon-question-sign" style="font-size: 35px;" aria-hidden="true"></span> -->
                <h3>
                    Вопросы</a>
                </h3>
                <p>Создание и управление вопросами.<br/>Ежемесячное тестирование</p>
            </div>
        </div>

        <br/>

        <div class="row">
            <div class="col-lg-12">
            <center>
                <span style="font-size: 14px;" class="label label-primary">По всем техническим проблемам звонить по номеру 6150</span>
            </center>
            </div>
        </div>

    </div>
</div>
