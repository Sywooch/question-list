<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 05.02.2016
 * Time: 11:27
 */

namespace igribov\questionlist\models;

use Yii;
use igribov\questionlist\models\UsersOffices;


class UsersAccess extends UsersOffices {

    static $allActions = [
        'admin' => [
            ['label'=>'Конструктор', 'url'=>['question-list-constructor/index']],
            ['label'=>'Управление опросами', 'url'=>['answer-list/index']],
            ['label'=>'Пользователи и роли', 'url'=>['users-offices/index']],
            ['label'=>'Офисы', 'url'=>['office/index']],
            ['label'=>'Регионы', 'url'=>['region/index']],
        ],
        'comdir' => [
            ['label'=>'Статистика', 'url'=>['statistic/index']],
        ],
        'manager' => [
            ['label'=>'Мои опросные листы', 'url'=>['write-test/index']],
        ],

    ];

    /*
     *  Возвращает все роли пользователя
     *
     */
    static public function getUserRoles($profile_id)
    {
        return self::findModels($profile_id);
    }

    /*
    *  Возвращает все роли пользователя где он CommercialDirector
    *
    */
    static public function getUserCommercialDirectorRoles($profile_id)
    {
        return self::findModels($profile_id,'commercial_director');
    }

    static public function isUserCommercialDirectorOfRegion($profile_id, $region_id)
    {
        return !!self::findOne([
            'region_id'=>$region_id,
            'profile_id'=>$profile_id,
            'profile_office_role'=>'commercial_director',
        ]);
    }

    static public function isUserManagerInOffice($profile_id, $office_id)
    {
        return !!self::findOne([
            'office_id'=>$office_id,
            'profile_id'=>$profile_id,
            'profile_office_role'=>'manager',
        ]);
    }

    /*
     *  Возвращает доступные пользователю экшены
     */
    static public function getAvailableActions($profile_id)
    {
        $roles = self::getUserRoles($profile_id);
        $roles = array_values(\yii\helpers\ArrayHelper::map($roles,'profile_office_role','profile_office_role'));
        // берем все экшены
        $actions = self::$allActions;
        // отсеиваем лишние руппы
        $actions = array_intersect_key($actions,array_flip($roles));
        $return = [];
        // экшены из оставшихся группы собираем в один массив
        foreach($actions as $group)
        {
            foreach($group as $action) $return[] = $action;
        }
        return $return;
    }

    /*
    *  Возвращает все роли пользователя где он Управляющий
    *
    */
    static public function getUserManagerRoles($profile_id)
    {
        return self::findModels($profile_id,'manager');
    }

    /*
    *  Возвращает все роли пользователя если он Админ
    *
    */
    static public function getUserAdminRole($profile_id)
    {
        return self::findModels($profile_id,'admin');
    }

    static protected function findModels($profile_id, $role = null)
    {
        $condition = [
            'profile_id' => $profile_id,
        ];
        if($role) $condition['profile_office_role'] = $role;

        return self::findAll($condition);
    }
} 