<?php

namespace app\modules\unicred\questionlist;

use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'app\modules\unicred\questionlist\controllers';

    public $onBeforeAction;

    public $defaultRoute = 'home';

    public $behaviors;

    public function init()
    {
        parent::init();
        if($this->onBeforeAction) $this->params['onBeforeAction'] = $this->onBeforeAction ;
        if($this->behaviors) $this->params['behaviors'] = $this->behaviors ;
    }

    public function bootstrap($app)
    {
        if($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\unicred\questionlist\commands';
        }
    }

}
