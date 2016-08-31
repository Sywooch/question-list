<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
use app\components\IeB;
use app\components\ModerWidget;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/news/favicon.ico" type="image/x-icon" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style type="text/css">
    h3 {
        margin-top: 0px;
    }
    div.required label:after {
        content: " *";
        color: red;
    } 
    </style>
</head>
<body>

<?php 
    $browser = new IeB();
    if(!is_null($browser->br) && ($browser->ver == '8.0' || $browser->ver == '7.0')) {
        $browser->showBlock();
        die;
    }
?>

<script type='text/javascript'>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<?php $this->beginBody() ?>

<?=ModerWidget::widget();?>

    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->params['name'],
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default', //navbar-fixed-top
                ],
            ]);
            
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Настройки', 'url' => ['/setup/roles'], 'visible'=>\app\models\Common::showMenu('admin')],
                    //['label' => 'О системе', 'url' => ['/site/about']],
                    //['label' => 'Сообщить об ошибках', 'url' => ['/site/about'], 'visible'=>!Yii::$app->user->isGuest],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Вход', 'url' => ['/site/login']] :
                        [
                            'label' => 'Выход (' . Yii::$app->user->identity->profile_id . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => [
                                'data-method' => 'post', 
                                'data-toggle' => "tooltip",
                                'title'=> 'Ваша роль: '.Yii::$app->user->identity->roles[Yii::$app->user->identity->authAssignments->item_name],
                                'data-placement'=> "bottom",
                            ]
                        ],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container" style="padding: 0;">
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; UniCreditBank | <?=Yii::$app->params['name']; ?> </p>
            
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
