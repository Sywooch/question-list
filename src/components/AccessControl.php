<?php
namespace igribov\questionlist\components;

use yii\base\Action;
use igribov\questionlist\models\UsersOffices;
use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

class AccessControl extends ActionFilter
{
    public $onBeforeAction;

    public function beforeAction($action)
    {
        $modelsUsersOffices = null;
        if($profileId = Yii::$app->user->identity->username)
        {
            $modelsUsersOffices = UsersOffices::find(['profile_id'=>$profileId])->joinWith('office')->all();
        }
        $params = \yii\helpers\ArrayHelper::merge(Yii::$app->getRequest()->getQueryParams(),
            Yii::$app->getRequest()->getBodyParams());

        if(! $beforeActionFunction = $this->onBeforeAction ) return true;
        $res = $beforeActionFunction($action->controller->id,
            $action->id,
            Yii::$app->user->identity,
            $modelsUsersOffices,
            $params);
        if($res) return true;
        else return $this->denyAccess();
    }


    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     *
     * @throws ForbiddenHttpException if the user is already logged in.
     */
    protected function denyAccess()
    {
        if ( Yii::$app->user->getIsGuest() )
        {
            Yii::$app->user->loginRequired();
        }
        else
        {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

} 