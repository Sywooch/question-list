<?php

namespace igribov\questionlist\controllers;

use igribov\questionlist\controllers\ModuleBaseController as Controller;
use igribov\questionlist\models\UsersAccess;
use Yii;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        $actions = UsersAccess::getAvailableActions(Yii::$app->user->identity->username);
        return $this->render('index_',['actions' => $actions]);
    }

}
