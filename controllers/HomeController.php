<?php

namespace app\modules\unicred\questionlist\controllers;

use app\modules\unicred\questionlist\controllers\ModuleBaseController as Controller;
use app\modules\unicred\questionlist\models\UsersAccess;
use yii\filters\AccessControl;
use Yii;

class HomeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }


    public function actionIndex()
    {
        $actions = UsersAccess::getAvailableActions(Yii::$app->user->identity->username);
        $userRoles = UsersAccess::getUserRoles(Yii::$app->user->identity->username);

        return $this->render('index_',['actions' => $actions, 'userRoles'=>$userRoles]);
    }

}
