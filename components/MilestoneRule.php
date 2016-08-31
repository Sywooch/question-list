<?php
namespace app\components;

use yii\rbac\Rule;

class MilestoneRule extends Rule {
    
    public $name = 'milestone';

    public function execute($user, $item, $params)
    {	

        if (isset($params['milestone'])) {
            return ($params['milestone']->active == 1) ? true : false;
        }

        return false;
    }
}