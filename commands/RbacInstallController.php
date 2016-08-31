<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 12.08.2016
 * Time: 12:13
 */

namespace app\commands;
use yii\console\Controller;
use yii\helpers\Console;
use Yii;


class RbacInstallController extends Controller
{
    public function actionCreate()
    {
        $admin = Yii::$app->authManager->getRole('admin');
        $comdir = Yii::$app->authManager->getRole('comdir');
        $manager = Yii::$app->authManager->getRole('manager');
        
        Yii::$app->authManager->addChild($admin, $comdir);
        Yii::$app->authManager->addChild($admin, $manager);
    }
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

        $guest = Yii::$app->authManager->createRole('guest');
        $guest->description = 'Гость';
        Yii::$app->authManager->add($guest);
        
        Yii::$app->authManager->addChild($manager, $guest);

        Yii::$app->authManager->addChild($comdir, $manager);

        Yii::$app->authManager->addChild($admin, $comdir);
        Yii::$app->authManager->addChild($admin, $manager);
    }

    public function actionCreatePermissions()
    {
        $permits = [
            /*'manager'=> [
                'beLinkedToOffices' => 'Быть прикрепленным к офисам',
            ],
            'commercial_director' => [
                'beLinkedToRegions' => 'Быть прикрепленным к регионам',
            ],*/
            'admin' => [
                'manageUsers' => 'Изменять данные пользователей',
                'createChecklist' => 'Создавать опросные листы',
            ],
        ];

        foreach ($permits as $role_code => $data) {
            foreach ($data as $pcode => $pdesc) {
                // создаем
                $permit = Yii::$app->authManager->createPermission($pcode);
                $permit->description = $pdesc;                
                Yii::$app->authManager->add($permit);
                // Добавляем 
                $role = Yii::$app->authManager->getRole($role_code);                
                $permit = Yii::$app->authManager->getPermission($pcode);
                Yii::$app->authManager->addChild($role, $permit);
            }
        }
    }

    public function actionRemoveRoles()
    {
        $roleNames = ['admin','manager','commercial_director'];
        foreach($roleNames as $roleName) {
            $role = Yii::$app->authManager->getRole($roleName);
            Yii::$app->authManager->remove($role);
        }

    }

    public function actionRemovePermissions()
    {
        $permits = ['beLinkedToOffices','beLinkedToRegions'];

        foreach($permits as $pcode) {
            $permit = Yii::$app->authManager->getPermission($pcode);
            Yii::$app->authManager->remove($permit);
        }

    }
} 