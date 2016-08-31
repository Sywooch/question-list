<?php
namespace app\components;

use app\models\Users;
use app\models\News;
use app\models\RelationCategories;
use yii\rbac\Rule;

class StatusAllowUpdateRule extends Rule
{
    public $name = 'statusAllowUpdate';

    public function execute($user, $item, $params)
    {
        $user_role = Users::findOne($user)->authAssignments->item_name;

        if (isset($params['news'])) {
            $news_status = $params['news']->status;
            $news_category = $params['news']->category_id;
            $relCat = !is_null(RelationCategories::findOne(['user_id'=>$user, 'category_id'=>$news_category]));

            if ($user_role == 'moderator' && $relCat && isset($params['action']) && $params['action'] == 'view') {
                return true;
            }

            if ($news_status == News::MODER_NEWS) {
                if ($user_role == 'moderator') {
                    return $relCat;
                }
            }

            if ($news_status == News::SMODER_NEWS) {
                if ($user_role == 'super_moderator') {
                    return true;
                }
            }
        }
        elseif (isset($params['question'])) {
            if ($user_role == 'moderator') {
                $news = News::findOne($params['question']->news_id);
                if (!is_null($news)) {
                    if ($news->status == News::MODER_NEWS && !is_null(RelationCategories::findOne(['user_id'=>$user, 'category_id'=>$news->category_id]))) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}