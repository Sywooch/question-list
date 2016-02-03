<?php

namespace igribov\questionlist\controllers;

use igribov\questionlist\controllers\ModuleBaseController as Controller;
use Yii;

class DefaultController extends Controller
{
	public function behaviors()
    {
        return [
            'access'=> [
                'class' => 'igribov\questionlist\components\AccessControl',
                'onBeforeAction' => Yii::$app->controller->module->params['onBeforeAction'],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index_');
    }

}
