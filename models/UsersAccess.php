<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 05.02.2016
 * Time: 11:27
 */

namespace app\modules\unicred\questionlist\models;

use Yii;
use app\modules\unicred\questionlist\models\UsersOffices;


class UsersAccess extends UsersOffices {

    static $allActions = [
        'admin' => [
            ['label'=>'Конструктор', 'url'=>['question-list/index']],
            ['label'=>'Управление опросами', 'url'=>['answer-list/index']],
            ['label'=>'Пользователи и роли', 'url'=>['users-offices/index']],
            ['label'=>'Офисы', 'url'=>['office/index']],
            ['label'=>'Регионы', 'url'=>['region/index']],
        ],
        'commercial_director' => [
            ['label'=>'Чек-листы', 'url'=>['confirm-question-list/index']],
            ['label'=>'Назначить управляющих', 'url'=>['managers/index']],
        ],
        'manager' => [
            ['label'=>'Чек-листы', 'url'=>['write-test/index']],
        ],

    ];

    /*
     *  Возвращает все роли пользователя
     *
     */
    static public function getUserRoles($profile_id)
    {
        return Yii::$app->session->get('qlUserData') ? Yii::$app->session->get('qlUserData') : self::findModels($profile_id);
    }

    /*
     *  Возвращает доступные пользователю экшены
     */
    static public function getAvailableActions($profile_id)
    {
        $roles = self::getUserRoles($profile_id);
        $roles = array_values(\yii\helpers\ArrayHelper::map($roles, 'profile_office_role', 'profile_office_role'));
        // берем все экшены
        $actions = self::$allActions;
        // отсеиваем лишние руппы
        $actions = array_intersect_key($actions, array_flip($roles));
        $return = [];
        // экшены из оставшихся группы собираем в один массив
        foreach ($actions as $group) {
            foreach ($group as $action) $return[] = $action;
        }
        return $return;
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