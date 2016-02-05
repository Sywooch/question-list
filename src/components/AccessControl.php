<?php
namespace igribov\questionlist\components;

use yii\base\Action;
use igribov\questionlist\models\UsersOffices;
use igribov\questionlist\models\UsersAccess;
use igribov\questionlist\models\AnswerList;
use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;
use yii\helpers\ArrayHelper;

class AccessControl extends ActionFilter
{
    public $onBeforeAction;

    public function beforeAction($action)
    {
        $modelsUsersOffices = null;
        if($profileId = Yii::$app->user->identity->username)
        {
            $modelsUsersOffices = UsersOffices::find()->where(['profile_id'=>$profileId])->joinWith('office')->all();
        }
        $params = \yii\helpers\ArrayHelper::merge(Yii::$app->getRequest()->getQueryParams(),
            Yii::$app->getRequest()->getBodyParams());

        // если пользователем была передана своя управления функция доступом в конфиге
        if( $beforeActionFunction = $this->onBeforeAction ) {
            $res = $beforeActionFunction($action->controller->id,
                $action->id,
                Yii::$app->user->identity,
                $modelsUsersOffices,
                $params);

            if($res) return true;
            else return $this->denyAccess();
        // если накстройки не было, то поведение стандартное
        } else {
            $access = true;
            $profile_id = Yii::$app->getUser()->identity->username;
            switch($action->controller->id)
            {
                // Данная часть доступна для коммерческих директоров
                case 'statistic' :
                    switch($action->id) {
                        case 'index' :
                            $access =  !!UsersAccess::getUserCommercialDirectorRoles($profile_id);
                            break;
                        case 'update' :
                        case 'view' :
                        $access = false;
                            $roles = UsersAccess::getUserCommercialDirectorRoles($profile_id);
                            $model = AnswerList::findOne($params['id']);
                            foreach( ArrayHelper::map($roles,'region_id','region_id') as $region_id )
                            {
                                if($model->office->region->id === $region_id) { $access = true; break; }
                            }
                        break;
                    }
                    break;
                case 'users-offices' :
                case 'answer-list' :
                case 'constructor' :
                case 'offices' :
                case 'regions' :
                    $access =  !!UsersAccess::getUserAdminRole($profile_id);
                    break;
                case 'default' :
                    break;
            }

            return $access ? true : $this->denyAccess();
        }
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
        return false;
    }

} 