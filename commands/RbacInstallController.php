<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 12.08.2016
 * Time: 12:13
 */

namespace app\modules\unicred\questionlist\commands;
use yii\console\Controller;
use yii\helpers\Console;
use Yii;


class RbacInstallController extends Controller
{

    public function actionCreateRoles()
    {
        $admin = Yii::$app->authManager->createRole('admin');
        $admin->description = 'Администратор';
        Yii::$app->authManager->add($admin);

        $comdir = Yii::$app->authManager->createRole('commercial_director');
        $comdir->description = 'Коммерческий директор';
        Yii::$app->authManager->add($comdir);

        $manager = Yii::$app->authManager->createRole('manager');
        $manager->description = 'Управляющий';
        Yii::$app->authManager->add($manager);

        Yii::$app->authManager->addChild($admin, $comdir);
        Yii::$app->authManager->addChild($admin, $manager);

        Yii::$app->authManager->addChild($comdir, $manager);

    }

    public function actionCreatePermissions()
    {
        $permit = Yii::$app->authManager->createPermission('createQuestionList');
        $permit->description = 'Право на создание опросного листа';
        Yii::$app->authManager->add($permit);

        $role = Yii::$app->authManager->getRole('admin');
        $permit = Yii::$app->authManager->getPermission('createQuestionList');
        Yii::$app->authManager->addChild($role, $permit);

    }

    public function actionRemoveRoles()
    {
        $roleNames = ['admin','manager','commercial_director'];
        foreach($roleNames as $roleName) {
            $role = Yii::$app->authManager->getRole($roleName);
            Yii::$app->authManager->remove($role);
        }

    }
} 