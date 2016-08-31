<?php
namespace app\components;

use yii\rbac\Rule;

class UserOwnRule extends Rule {
    
    public $name = 'userOwn';

    public function execute($user, $item, $params)
    {	

        if (isset($params['news'])) {
            
            $news_status = $params['news']->status;
            $user_id = $params['news']->user_id;
            
            if ($news_status == 2 || $news_status == 10) {
                return $user_id == $user;
            }
            elseif (isset($params['action']) && $params['action'] == 'view' && $user == $user_id) {
                return true;
            }
        }
        elseif (isset($params['question'])) {
            return $params['question']->user_id == $user;
        }

        return false;
    }
}