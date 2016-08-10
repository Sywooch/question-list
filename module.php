<?php

namespace app\modules\unicred\questionlist;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\unicred\questionlist\controllers';

    public $onBeforeAction;

    public $behaviors;

    public function init()
    {
        parent::init();
        if($this->onBeforeAction) $this->params['onBeforeAction'] = $this->onBeforeAction ;
        if($this->behaviors) $this->params['behaviors'] = $this->behaviors ;
    }

}
