<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use app\models\User;
use app\models\Common;
use app\models\News;

class ModerWidget extends Widget {

    public function run() {

        return;
        
        if (!Yii::$app->user->isGuest) {
            if (Common::getRole() == User::MODER || 
                Common::getRole() == User::SMODER || 
                Common::getRole() == User::ADMIN) {

                if (($count = $this->getCount()) > 0) {
                    return $this->render('moder', ['count'=>$count]);
                }   
            }
        }   	
    }

    public function getCount() {

    	$query = News::find();

    	if (Common::getRole() == User::MODER) {
    		$query->where(['status' => News::MODER_NEWS, 'category_id'=>$this->getCategoryId()]);
    	}
    	elseif (Common::getRole() == User::SMODER) {
    		$query->where(['status' => News::SMODER_NEWS, 'category_id'=>$this->getCategoryId()]);
    	}
    	elseif (Common::getRole() == User::ADMIN) {
    		$query->where(['status' => News::ADMIN_NEWS]);
    	}

    	return count($query->all());
    }

    public function getCategoryId() {
    	
    	return (new \yii\db\Query)
            ->select('category_id')
            ->from('relation_categories')
            ->where(['user_id'=>Yii::$app->user->id]);
    }
}