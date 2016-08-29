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
        } else {
            // если накстройки не было, то поведение стандартное
            $access = true;
            $user_id = Yii::$app->getUser()->identity->username;
            switch($action->controller->id)
            {
                // экшены для управляющего
                case 'write-test' :
                    switch($action->id) {
                        case 'index' :
                            $access =  !!UsersAccess::getUserManagerRoles($user_id);
                            break;
                        case 'send' :
                            // можно отправить ком.директору только лист который заполнялся.
                            $model = AnswerList::findOne($params['id']);
                            $access = $access && ($model->status==='answered');
                        case 'create' :
                        case 'update' :
                            $model = empty($model) ? $model :AnswerList::findOne($params['id']);
                            // при создании и редактировании лист не должен быть в закрытых статусах
                            $access = $access && (!in_array($model->status,['archive','send','done']));
                        case 'view' :
                            // при просмотре важен только доступ к офисам региона
                            $access =  $access && UsersAccess::getUserManagerRoles($user_id);
                            $model = empty($model) ? $model : AnswerList::findOne($params['id']);
                            if(!$access) break;
                            $roles = UsersAccess::getUserManagerRoles($user_id);
                            foreach( ArrayHelper::map($roles,'region_id','region_id') as $region_id )
                            {
                                if($model->office->region->id === $region_id) { $access = true; break; }
                            }
                            break;
                    }
                    break;
                // Данная часть доступна для коммерческих директоров
                case 'statistic' :
                    switch($action->id) {
                        case 'index' :
                            $access =  !!UsersAccess::getUserCommercialDirectorRoles($user_id);
                            break;
                        case 'update' :
                        case 'view' :
                        $access = false;
                            $roles = UsersAccess::getUserCommercialDirectorRoles($user_id);
                            $model = AnswerList::findOne($params['id']);
                            foreach( ArrayHelper::map($roles,'region_id','region_id') as $region_id )
                            {
                                if($model->office->region->id === $region_id) { $access = true; break; }
                            }
                        break;
                    }
                    break;
                // экщены для админа
                case 'users-offices' :
                    $isComDir = UsersAccess::getUserCommercialDirectorRoles($user_id);
                    $isAdmin = UsersAccess::getUserAdminRole($user_id);
                    $access =  $isComDir || $isAdmin;
                    // если не админ и не комм.директор то не проверяем дальше.
                    if(!$access) break;
                    switch($action->id) {
                        case 'create' :
                            if($isComDir) {

                            }
                            break;
                        case 'update' :
                        case 'delete' :
                        case 'bulk-delete' :
                            // если ком.дир, то он может обновлять данные по пользователям своих регионов
                            if($isComDir && !$isAdmin) {
                                // берем модель, которую пользователь пытается изменить или удалить
                                $model = UsersOffices::findOne($params['id']);
                                // и самого пользоватлея
                                $user = UsersOffices::findOne(['profile_id'=>$user_id]);
                                $access = ($model->profile_office_role === 'manager' &&
                                    ($user->region_id === $model->region->id) );
                            }
                            break;
                    }
                    break;
                case 'answer-list' :
                case 'question-list-constructor' :
                case 'office' :
                case 'region' :
                    $access =  !!UsersAccess::getUserAdminRole($user_id);
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