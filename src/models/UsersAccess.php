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