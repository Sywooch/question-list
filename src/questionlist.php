<?php

namespace app\modules\unicred;

class questionlist extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\unicred\controllers';

    public function init()
    {
        parent::init();
        /*return [
            'components' => [
                'authManager' => [
                    'class' => 'yii\rbac\DbManager',
                ],
            ],
            'modules' => [
                'rbac' => [
                    'class' => 'johnitvn\rbacplus\Module'
                ],
            ],
        ];*/
        // custom initialization code goes here
    }

}
