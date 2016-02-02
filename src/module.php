<?php

namespace igribov\questionlist;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'igribov\questionlist\controllers';

    public $onBeforeAction;

    public function init()
    {
        parent::init();
        if($this->onBeforeAction) $this->params['onBeforeAction'] = $this->onBeforeAction ;
    }

}
