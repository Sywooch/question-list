<?php

namespace app\modules\unicred\questionlist\controllers;

use app\modules\unicred\questionlist\controllers\ModuleBaseController as Controller;
use app\modules\unicred\questionlist\models\UsersAccess;
use Yii;

class ActionListController extends Controller
{
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
        // user login or signup comes here
    }

    public function actionIndex()
    {
        $actions = UsersAccess::getAvailableActions(Yii::$app->user->identity->username);
        $userRoles = UsersAccess::getUserRoles(Yii::$app->user->identity->username);

        return $this->render('index_',['actions' => $actions, 'userRoles'=>$userRoles]);
    }

}
